<?php

namespace App\Http\Controllers;

use App\Models\Invoice as InvoiceModel;
use App\Models\Product;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;

class InvoiceController extends Controller
{
    public function createPdfInvoice($id)
    {
        $invoice_original = InvoiceModel::findOrFail($id);

        $client = new Party([
            'name'          => 'Qeed',
            'phone'         => '+390437573188',
            'email'         => 'sales@qeed.it',
        ]);
        $status = $invoice_original->order->status;
        $customer = new Party([
            'name'          => $invoice_original->customer->name,
            'address'       => $invoice_original->customer->shiping_data,
            'custom_fields' => [
                'order number' => '> ' . $invoice_original->order->id . ' <',
            ],
        ]);
        $items = [];
        foreach ($invoice_original->order->products as $product) {
            $product_item = Product::findOrFail($product->product_id);
            $product__discount = $invoice_original->customer->customer_discount > 0 ? $invoice_original->customer->customer_discount : $product_item->discount;
            // $discountValue = ($product__discount / 100) * $product->unit_price;
            $item = InvoiceItem::make($product_item->title)
                ->description($product_item->description)
                ->pricePerUnit($product_item->price)
                ->quantity($product->quantity)
                ->discountByPercent($product__discount);
            array_push($items, $item);
        }

        $notes = [
            'Qeed Invoice',
            'Please save this copy for invoice',
            'Good Luck',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Qeed Invoice')
            // ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            ->status($status == 'faild' ? __('invoices::invoice.due') : __('invoices::invoice.paid'))
            ->sequence($invoice_original->id)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->date($invoice_original->order->created_at)
            ->dateFormat('m/d/Y')
            ->payUntilDays(0)
            ->currencyCode('EUR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->taxRate(18)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return redirect($link);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function createPDF(Invoice $invoice)
    {
        // // Create a new Laravel Daily Invoice
        // $invoice = new LaravelDailyInvoice();

        // // Add buyer
        // $buyer = new Buyer([
        //     'name'          => $invoice->customer->name,
        //     'custom_fields' => [
        //         'email' => $invoice->customer->email,
        //     ],
        // ]);
        // $invoice->buyer($buyer);

        // // Add items
        // foreach ($invoice->orders as $order) {
        //     $item = (new InvoiceItem())->title($order->name)->pricePerUnit($order->price);
        //     $invoice->addItem($item);
        // }

        // // Save the invoice to a PDF file
        // $invoice->save('public/storage/invoices');

        // return response()->download(public_path('storage/invoices/' . $invoice->getFilename()));

        $customer = new Buyer([
            'name'          => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
            ],
        ]);

        $item = InvoiceItem::make('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item);

        return $invoice->stream();
    }
}
