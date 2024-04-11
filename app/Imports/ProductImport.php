<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $headerRow = $collection->shift();
        $products = $collection;
        foreach ($products as $product) {
            $product_code = $product[0];
            $category_name = $product[1];
            $product_description = $product[2];

            $category = Category::firstOrCreate(['name' => $category_name, 'cover' => 'null']);

            $product_imported = Product::create([
                'title' => $product_code,
                'code' => $product_code,
                'description' => $product_description,
                'status' => 'draft',
                'quantity' => 0,
                'price' => 0,
                'category_id' => $category->id,
            ]);
            $product_details = ProductDetails::create([
                'product_id' => $product_imported->id,
                'photo' => 'null',
                'video' => 'null',
                'map' => 'null',
                'catalog' => 'null',
                'driver' => 'null',
                'brochure' => 'null',
            ]);
        }
    }
}
