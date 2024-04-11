<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Models\OrderProductDetails;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Nafezly\Payments\Classes\PayPalPayment;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;

class BackendOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:orders-create', ['only' => ['create', 'store', 'uploadFileXml']]);
        $this->middleware('can:orders-read',   ['only' => ['show', 'index', 'export', 'xml']]);
        $this->middleware('can:orders-update',   ['only' => ['edit', 'update']]);
        $this->middleware('can:orders-delete',   ['only' => ['delete']]);
    }

    public function customer_orders()
    {
        if (auth('customer')->user() != null) {
            $orders = Order::where('id', auth('customer')->id())->get();
        } else {
            $orders = Order::all();
        }
        return view('admin.orders.index', compact('orders'));
    }

    public function index()
    {
        $orders = Order::paginate(15);
        return view('admin.orders.index', compact('orders'));
    }


    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.csv');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status', 'published')->get();
        $customers = Customer::all();
        return view('admin.orders.create', compact('products', 'customers'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'customer_id' => 'required|integer',
            'status' => 'nullable|string',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer',
        ]);

        // Check product stock availability before creating order
        $insufficientStock = false;
        $productsWithInsufficientStock = []; // Optional: Track products with insufficient stock
        $productQuantities = []; // Map product ID to requested quantity

        foreach ($request->products as $product) {
            $productId = $product['id'];
            $requestedQuantity = $product['quantity'];

            $product = Product::findOrFail($productId); // Fetch product using `findOrFail`

            // Check stock and accumulate quantities
            if (isset($productQuantities[$productId])) {
                $productQuantities[$productId] += $requestedQuantity;
            } else {
                $productQuantities[$productId] = $requestedQuantity;
            }

            if ($product->quantity < $productQuantities[$productId]) {
                $insufficientStock = true;
                $productsWithInsufficientStock[] = $productId; // Optional: Add to tracking array
                break; // Stop iterating if any product has insufficient stock
            }
        }

        if ($insufficientStock) {
            // Handle insufficient stock case
            $errorMessage = "Insufficient stock for products: " . implode(', ', $productsWithInsufficientStock);
            return response()->json(['error' => $errorMessage], 422); // Unprocessable Entity
        }

        // Create order with validated data (assuming pending status)
        $order = Order::create([
            'customer_id' => $validatedData['customer_id'],
            'total_amount' => 0, // Calculate total_amount later
            'status' => $validatedData['status'] ?? 'pending',
        ]);

        // Calculate total_amount and create order details
        $total_amount = 0;
        foreach ($productQuantities as $productId => $quantity) {
            $product_model = Product::findOrFail($productId);

            // Update product quantity (locking is recommended in high-traffic environment)
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

        // Update order with calculated total_amount
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

        return redirect($response['redirect_url']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $productOrderDetails = $order->products;
        return view('admin.orders.show', compact('productOrderDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'status' => 'required',
        ]);
        $order->update([
            'status' => $validatedData['status']
        ]);
        toastr()->success('Order updated successfully.', 'successfully');
        return redirect()->route('admin.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Find the order by ID
        $order = Order::findOrFail($id);

        // Check if the order has already been deleted
        if ($order->deleted_at !== null) {
            return response()->json(['error' => 'Order already deleted.'], 404);
        }

        // Get order details
        $orderDetails = OrderProductDetails::where('order_id', $id)->get();

        // Restore product quantities
        foreach ($orderDetails as $detail) {
            $product = Product::findOrFail($detail->product_id);
            $product->increment('quantity', $detail->quantity);
        }

        // Delete order details
        OrderProductDetails::where('order_id', $id)->delete();

        // Delete the order
        $order->delete();
        toastr()->success('Order deleted successfully.', 'successfully');
        return redirect()->route('admin.orders.index');
    }
}
