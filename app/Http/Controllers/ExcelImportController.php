<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new ProductImport, $file);

        toastr()->success('Products Created Successfully !!', 'Success');
        return redirect()->route('admin.products.index');
    }


    public function importProductsFromXml(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $xmlData = file_get_contents($file);
            $xml = simplexml_load_string($xmlData);
            foreach ($xml->children() as $product) {
                $product_code = $product->code;
                $category_name = $product->category;
                $product_description = $product->description;


                $category = Category::firstOrCreate(['name' => $category_name, 'cover' => 'null']);

                $product_imported = Product::create([
                    'title' => $product_code,
                    'code' => $product_code,
                    'description' => $product_description,
                    'status' => 'draft',
                    'quantity' => 0,
                    'discount' => 0,
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
            toastr()->success('Done Added Product', 'Succesfully');
            return redirect()->route('admin.products.index');
        }
        return toastr()->success('No file uploaded!', 'Failed');
    }
}
