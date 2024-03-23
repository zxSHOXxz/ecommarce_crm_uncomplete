<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\OrderProductDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Nafezly\Payments\Classes\PayPalPayment;

class ApiOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->middleware('can:orders-create', ['only' => ['store']]);
    }

    public function payment_verify(Request $request)
    {
        $payment = new PayPalPayment();
        $response = $payment->verify($request);
        $order_id = Cache::get('payment_source');
        $order = Order::findOrFail($order_id);
        if ($response['success'] == true) {
            $order->update([
                'status' => 'pending'
            ]);
        } else {
            return response()->json([
                'translate_message' => 'An error occurred while executing the operation',
                'order' => $order,
                'response' => $response
            ]);
        }
        return response()->json([
            'translate_message' => 'operation completed successfully',
            'order' => $order,
            'response' => $response
        ]);
    }

    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|string',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer',
        ], [
            'status.string' => 'The status field must be a string.',
            'products.*.id.required' => 'The product ID field is required for all products.',
            'products.*.id.integer' => 'The product ID must be an integer for all products.',
            'products.*.quantity.required' => 'The quantity field is required for all products.',
            'products.*.quantity.integer' => 'The quantity must be an integer for all products.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 422); // Unprocessable Entity
        }

        // Validation passed, continue with the logic
        $validatedData = $validator->validated();
        $validatedData['customer_id'] = auth()->id();
        // Check product stock availability before creating order
        $insufficientStock = false;
        $productsWithInsufficientStock = [];
        $productQuantities = [];

        foreach ($request->products as $product) {
            $productId = $product['id'];
            $requestedQuantity = $product['quantity'];

            $product = Product::findOrFail($productId);

            if (isset($productQuantities[$productId])) {
                $productQuantities[$productId] += $requestedQuantity;
            } else {
                $productQuantities[$productId] = $requestedQuantity;
            }

            if ($product->quantity < $productQuantities[$productId]) {
                $insufficientStock = true;
                $productsWithInsufficientStock[] = $productId;
                break;
            }
        }

        if ($insufficientStock) {
            $errorMessage = "Insufficient stock for products: " . implode(', ', $productsWithInsufficientStock);
            return response()->json(['error' => $errorMessage], 422);
        }

        // Create order with validated data (assuming pending status)
        $order = Order::create([
            'customer_id' => $validatedData['customer_id'],
            'total_amount' => 0,
            'status' => $validatedData['status'] ?? 'faild',
        ]);

        // Calculate total_amount and create order details
        $total_amount = 0;
        foreach ($productQuantities as $productId => $quantity) {
            $product_model = Product::findOrFail($productId);

            $product_model->decrement('quantity', $quantity);

            $orderDetails = OrderProductDetails::create([
                'product_id' => $productId,
                'order_id' => $order->id,
                'total_price' => ($product_model->price - $product_model->discount) * $quantity,
                'unit_price' => ($product_model->price - $product_model->discount),
                'quantity' => $quantity,
            ]);

            $total_amount += $orderDetails->total_price;
        }

        $order->update(['total_amount' => $total_amount]);

        $payment = new PayPalPayment();
        $customer = Customer::findOrFail($validatedData['customer_id']);

        $response = $payment->setAmount($total_amount)
            ->setUserId($customer->id)
            ->setUserFirstName($customer->name)
            ->setUserEmail($customer->email)
            ->setUserPhone($customer->phone)
            ->setSource($order->id)
            ->pay();
        Cache::add('payment_source', $order->id);
        return response()->json($response['redirect_url']);
    }
}
