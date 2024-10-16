<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProductDetails;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Http\Request;

class BackendProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:products-create', ['only' => ['create', 'store']]);
        $this->middleware('can:products-read',   ['only' => ['show', 'index']]);
        $this->middleware('can:products-update',   ['only' => ['edit', 'update']]);
        $this->middleware('can:products-delete',   ['only' => ['delete']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'quantity' => 'required',
            'discount' => 'required',
            'price' => 'required',
            'code' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'brochure' => 'required',
            'driver' => 'required',
            'catalog' => 'required',
            'map' => 'required',
            'video' => 'required',
            'photo' => 'required',
        ]);

        $product = Product::create([
            'title' => $request->title,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'price' => $request->price,
            'code' => $request->code,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        $product_details = ProductDetails::create([
            'product_id' => $product->id,
            'brochure' => $request->brochure,
            'driver' => $request->driver,
            'catalog' => $request->catalog,
            'map' => $request->map,
            'video' => $request->video,
        ]);

        if ($request->hasFile('main_photo')) {
            $photo = $product_details->addMedia($request->main_photo)->toMediaCollection('main_photo');
            $product_details->update(['main_photo' => $photo->id . '/' . $photo->file_name]);
        }


        if ($request->hasfile('photo')) {
            $photos = [];
            foreach ($request->file('photo') as $photo) {
                $photo = $product_details->addMedia($photo)->toMediaCollection('photo');
                $photos[] = $photo->id . '/' . $photo->file_name;
            }
            $product_details->update(['photo' => json_encode($photos)]);
        }


        toastr()->success('Done Added Product', 'Succesfully');
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Validate request data
        $request->validate([
            'title' => 'required',
            'quantity' => 'required',
            'discount' => 'required',
            'price' => 'required',
            'code' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'brochure' => 'nullable',  // Allow optional update
            'driver' => 'nullable',  // Allow optional update
            'catalog' => 'nullable',  // Allow optional update
            'map' => 'nullable',  // Allow optional update
            'video' => 'nullable',  // Allow optional update
            'photo' => 'nullable',   // Allow optional update
        ]);

        // Update product details
        $product->update([
            'title' => $request->title,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'price' => $request->price,
            'code' => $request->code,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        // Handle product details update (if applicable)
        $productDetails = $product->product_details;  // Check if details exist

        if ($productDetails) {
            $productDetails->update([
                'brochure' => $request->brochure,
                'driver' => $request->driver,
                'catalog' => $request->catalog,
                'map' => $request->map,
                'video' => $request->video,
            ]);
        } else {
            // Optionally create new details if they don't exist
            $productDetails = ProductDetails::create([
                'product_id' => $product->id,
                'brochure' => $request->brochure,
                'driver' => $request->driver,
                'catalog' => $request->catalog,
                'map' => $request->map,
                'video' => $request->video,
            ]);
        }

        if ($request->hasFile('main_photo')) {
            $photo = $productDetails->addMedia($request->main_photo)->toMediaCollection('main_photo');
            $productDetails->update(['main_photo' => $photo->id . '/' . $photo->file_name]);
        }


        if ($request->hasfile('photo')) {
            $photos = [];
            foreach ($request->file('photo') as $photo) {
                $photo = $productDetails->addMedia($photo)->toMediaCollection('photo');
                $photos[] = $photo->id . '/' . $photo->file_name;
            }
            $productDetails->update(['photo' => json_encode($photos)]);
        }

        toastr()->success('Product Updated Successfully!', 'Success');
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $orders = OrderProductDetails::where('product_id', $product->id)->get();
        foreach ($orders as $order_product_details) {
            $order = Order::findOrFail($order_product_details->order_id);
            $order->update('status', 'faild');
        }
        $product_details = ProductDetails::where('product_id', $product->id)->first();
        $product_details->delete();
        $product->delete();
        toastr()->success('product deleted successfully', 'The operation is successful');
        return redirect()->route('admin.products.index');
    }
}
