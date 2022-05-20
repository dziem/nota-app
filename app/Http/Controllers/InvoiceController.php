<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class InvoiceController extends Controller
{
    public function index() {
        $prices = Price::orderBy('name')->get();
        return view('invoice', compact('prices'));
    }

    public function submit(Request $request) {
        if ($request->send == 'print') {
            $this->print($request);
        }
        $this->saveData($request);
        return redirect('/invoice');
    }

    private function saveData(Request $request) {
        $transaction = new Transaction();
        $transaction->name = strtolower($request->name);
        $transaction->is_reseller = !isset($request->reseller);
        $transaction->created_at = date('Y-m-d H:i:s');
        $transaction->save();
        foreach ($request->item as $item) {
            if (isset($item['item_id'])) {
                $detail = new TransactionDetail();
                $detail->name = $item['name'];
                $detail->quantity = $item['qty'];
                $detail->price = $item['price'];
                $detail->transaction_id = $transaction->id;
                $prices = Price::find($item['item_id'])->details()->whereNotNull('stock')->where('stock', '!=' , 0)->orderBy('updated_at')->get();
                if ($prices->isNotEmpty()) {
                    $price = $prices[0];
                    if ($price->stock == null || $price->stock == 0) {
                        $price->stock = 0;
                    } else {
                        if (($price->stock - $item['qty']) >= 0) {
                            $price->stock = $price->stock - $item['qty'];
                            $detail->profit = ($item['price'] - $price->base_price) * $item['qty'];
                        } else {
                            $detail->quantity = $price->stock;
                            $detail->profit = ($item['price'] - $price->base_price) * $detail->quantity;
                            $leftover = $item['qty'] - $price->stock;
                            $detailToo = new TransactionDetail();
                            $detailToo->name = $item['name'];
                            $detailToo->quantity = $leftover;
                            $detailToo->price = $item['price'];
                            $detailToo->transaction_id = $transaction->id;
                            $price->stock = 0;
                            if (isset($prices[1])) {
                                $priceToo = $prices[1];
                                $priceToo->stock = $priceToo->stock - $leftover;
                                $priceToo->save();
                                $detailToo->profit = ($item['price'] - $priceToo->base_price) * $detailToo->quantity;
                                $detailToo->save();
                            }
                        }
                    }
                } else {
                    $price = Price::find($item['item_id'])->details()->orderBy('updated_at')->first();
                    $detail->profit = ($item['price'] - $price->base_price) * $item['qty'];
                }
                $detail->save();
                $price->save();
            }
        }
    }

    private function print(Request $request) {
        $store_name = 'BATIK HM AKMAL';
        $store_address = 'Distributor Batik UNGGUL JAYA';

        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        $printer->setStore("", $store_name, $store_address, $request->name == null ? "" : $request->name, "", "");
        //$printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        foreach ($request->item as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }

        if ($request->dp != null) {
            $printer->setDp($request->dp);
        }

        $printer->calculateGrandTotal();

        $printer->printReceipt();
    }
}
