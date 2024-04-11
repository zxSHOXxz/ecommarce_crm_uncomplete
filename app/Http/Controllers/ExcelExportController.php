<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Product;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;

class ExcelExportController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductExport, 'products.csv');
    }

    public function product_xml_export()
    {
        $products = Product::all();
        try {

            $xml = new XMLWriter();

            $xml->openURI('file.xml');

            $xml->startDocument('1.0');
            $xml->startElement('ListOrder');
            $xml->setIndent(4);
            $i = 1;
            foreach ($products as $s) {
                $xml->startElement('Product' . $i);
                $xml->writeElement('code', $s->code);
                $xml->writeElement('category', $s->category->name);
                $xml->writeElement('description', $s->description);
                $xml->endElement();
                $i++;
            }
            $xml->endElement();

            $xml->endDocument();

            $xml->flush();
            $headers = [
                'Content-Type' => 'application/xml',
            ];
            return response()->download('file.xml', 'products.xml', $headers);
        } catch (Exception $e) {
            return toastr()->success($e, 'Error');;
        }
    }
}
