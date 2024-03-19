<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class OrdersExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * @return Collection
     */
    public function collection()
    {
        $orders = Order::all();

        $exportData = [];

        foreach ($orders as $order) {
            $products = '';
            foreach ($order->products as $productDetail) {
                $products .= Str::upper($productDetail->product->title) . ': ' . $productDetail->quantity . ', ';
            }
            $products = rtrim($products, ', ');

            $exportData[] = [
                'Order ID' => $order->id,
                'Customer Name' => $order->customer->name,
                'Total Amount' => $order->total_amount,
                'Products' => $products,
                'Status' => $order->status,
            ];
        }

        return collect($exportData);
    }
    public function headings(): array
    {
        return [
            'Order id',
            'Customer name',
            'Total Amount',
            'Products',
            'Status',
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
            'C' => 25,
            'D' => 25,
            'E' => 25,
        ];
    }
}
