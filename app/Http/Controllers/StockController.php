<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Restock;
use App\Models\RestockDetail;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $data = Price::orderBy('name')->paginate(20);

        return view('stock.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function add() {
        $prices = Price::orderBy('name')->get();
        return view('stock.add', compact('prices'));
    }

    public function detail($id) {
        $price = Price::find($id);
        return view('stock.detail', compact('price'));
    }

    public function submit(Request $request) {
        $this->saveData($request);
        return redirect('/stock')->with('success', 'Berhasil tambah stok');
    }

    private function saveData(Request $request) {
        $restock = new Restock();
        $restock->name = $request->name;
        $restock->created_at = date('Y-m-d H:i:s');
        $restock->save();
        foreach ($request->item as $item) {
            $detail = new RestockDetail();
            $detail->name = $item['name'];
            $detail->quantity = $item['qty'];
            $detail->restock_id = $restock->id;
            $detail->save();
            $price = Price::find($item['item_id'])->details()->orderBy('updated_at', 'desc')->first();
            if ($price->stock == null) {
                $price->stock = $item['qty'];
            } else {
                $price->stock = $price->stock + $item['qty'];
            }
            $price->save();
            $detail->base_price = $price->base_price;
            $detail->save();
        }
    }
}
