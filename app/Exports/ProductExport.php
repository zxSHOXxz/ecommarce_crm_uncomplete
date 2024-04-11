<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport  implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * @return Collection
     */
    public function collection()
    {
        $products = Product::all();

        $exportData = [];

        foreach ($products as $product) {
            $exportData[] = [
                'Code' => $product->code,
                'Category' => $product->category->name,
                'Description' => $product->description,
            ];
        }

        return collect($exportData);
    }
    public function headings(): array
    {
        return [
            'Code',
            'Category',
            'Description',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFFF00']]]
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 550,
        ];
    }
}
