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


/**
 * @OA\Schema(
 *     schema="Order",
 *     title="Order",
 *     required={"id", "customer_id", "total_amount", "status","products"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Order ID"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="integer",
 *         format="int64",
 *         description="Customer ID"
 *     ),
 *     @OA\Property(
 *         property="total_amount",
 *         type="number",
 *         format="float",
 *         description="Total amount of the order"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Order status"
 *     ),
 *      @OA\Property(
 *                 property="products",
 *                 type="array",
 *                 @OA\Items(
 *                     required={"id", "quantity"},
 *                     @OA\Property(
 *                         property="id",
 *                         type="integer",
 *                         description="Product ID"
 *                     ),
 *                     @OA\Property(
 *                         property="quantity",
 *                         type="integer",
 *                         description="Product quantity"
 *                     )
 *                 )
 *             )
 * )
 */

class ApiOrdersController extends Controller
{
    /**
     * Create a new ApiOrdersController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['payment_verify']]);
        // $this->middleware('can:orders-create', ['only' => ['store']]);
    }

    /**
     * @OA\Post(
     *     path="/api/orders/create",
     *     summary="Store a new order",
     *     tags={"Orders"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"products"},
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     required={"id", "quantity"},
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="Product ID"
     *                     ),
     *                     @OA\Property(
     *                         property="quantity",
     *                         type="integer",
     *                         description="Product quantity"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="string",
     *             description="URL to redirect for payment"
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Error message"
     *             )
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     *
     */

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
            $paypal_email = $response['process_data']['result']['payment_source']['paypal']['email_address'];
            $customer = Customer::findOrFail($order->customer_id);
            $customer->update([
                'billing_data' => 'paypal email :' . $paypal_email,
            ]);
        } else {
            foreach ($order->products as $product) {
                $product_model = Product::findOrFail($product->product_id);

                $product_model->decrement('quantity', $product->quantity);
                $product_model->decrementincrement('reserved', $product->quantity);
            }
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
        $validator = Validator::make($request->all(), [
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer',
        ], [
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

        $customer = Customer::findOrFail($validatedData['customer_id']);

        // Calculate total_amount and create order details
        $total_amount = 0;
        foreach ($productQuantities as $productId => $quantity) {
            $product_model = Product::findOrFail($productId);

            // Update product quantity (locking is recommended in high-traffic environment)
            $product_model->decrement('quantity', $quantity);
            $product_model->increment('reserved', $quantity);


            $discount = $customer->customer_discount ? $customer->customer_discount : $product_model->discount;
            $productPrice = $product_model->price;
            $discountValue = ($discount / 100) * $productPrice;

            $orderDetails = OrderProductDetails::create([
                'product_id' => $productId,
                'order_id' => $order->id,
                'total_price' => ($product_model->price - $discountValue) * $quantity,
                'unit_price' => ($product_model->price - $discountValue),
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
        Cache::put('payment_source', $order->id);
        return response()->json($response['redirect_url']);
    }
}
