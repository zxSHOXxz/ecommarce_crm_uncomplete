<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

/**
 * @OA\Schema(
 *     schema="Prduct",
 *     title="Product",
 *     required={"id", "discount", "price","code", "status","quantity","description", "title"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Product ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         format="string",
 *         description="Product title"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         format="string",
 *         description="Product description"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer",
 *         format="int64",
 *         description="Product quantity"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         format="string",
 *         description="Product status"
 *     ),
 *     @OA\Property(
 *         property="discount",
 *         type="integer",
 *         format="int64",
 *         description="Product discount"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="integer",
 *         format="int64",
 *         description="Product price"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         format="int64",
 *         description="Product code"
 *     )
 * )
 */
class ApiProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }

    /**
     * @OA\Get(
     *     path="/api/products/get",
     *     summary="Get all products",
     *     description="Retrieve all products with their details and category",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="products",
     *                 type="arrayOfJson",
     *             )
     *         )
     *     ),
     * )
     */


    public function index()
    {
        // Retrieve products with their details and category
        $products = Product::where('status', 'published')
            ->with('product_details') // assuming the relationship name is productDetails
            ->with('category') // assuming the relationship name is category
            ->get();

        // Prepare formatted response
        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'code' => $product->code,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'discount' => $product->discount,
                'status' => $product->status,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'product_details' => [
                    'id' => $product->product_details->id,
                    'product_id' => $product->product_details->product_id,
                    'brochure' => $product->product_details->brochure,
                    'driver' => $product->product_details->driver,
                    'catalog' => $product->product_details->catalog,
                    'map' => $product->product_details->map,
                    'video' => $product->product_details->video,
                    'photo' => $product->product_details->photo,
                ],
            ];
        });

        // Return JSON response
        return response()->json([
            'products' => $formattedProducts,
        ], 200);
    }
}
