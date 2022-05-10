<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\PriceDetail;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $data = Price::with('details')->orderBy('name')->paginate(20);

        return view('price.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function create()
    {
        return view('price.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'normal_price' => 'required',
            'bulk_price' => 'required'
        ]);

        $price = new Price();
        $price->name = $request->name;
        $price->normal_price = $request->normal_price;
        $price->bulk_price = $request->bulk_price;
        $price->bulk_price_too = $request->bulk_price_too;
        $price->special_price = $request->special_price;
        $price->save();
        foreach ($request->item as $item) {
            $detail = new PriceDetail();
            $detail->base_price = $item['price'];
            $detail->stock = 0;
            $detail->price_id = $price->id;
            $detail->created_at = date('Y-m-d H:i:s');
            $detail->updated_at = date('Y-m-d H:i:s');
            $detail->save();
        }

        return redirect()->route('price.index')
                        ->with('success','Berhasil input harga');
    }

    public function show(Price $price)
    {
        return view('price.show',compact('price'));
    }

    public function edit(Price $price)
    {
        return view('price.edit',compact('price'));
    }

    public function update(Request $request, Price $price)
    {
        $request->validate([
            'name' => 'required',
            'normal_price' => 'required',
            'bulk_price' => 'required'
        ]);

        $price->name = $request->name;
        $price->normal_price = $request->normal_price;
        $price->bulk_price = $request->bulk_price;
        $price->bulk_price_too = $request->bulk_price_too;
        $price->special_price = $request->special_price;
        $price->save();
        $delete = [];
        foreach ($request->item as $item) {
            $detail = new PriceDetail();
            if ($item['id'] != "0") {
                $detail = PriceDetail::find($item['id']);
                array_push($delete, $detail->id);
            }
            if ($item['id'] == "0" || $detail->base_price != $item['price']) {
                $detail->base_price = $item['price'];
                $detail->stock = 0;
                $detail->price_id = $price->id;
                if ($item['id'] != "0") {
                    $detail->created_at = date('Y-m-d H:i:s');
                }
                $detail->updated_at = date('Y-m-d H:i:s');
                $detail->save();
                array_push($delete, $detail->id);
            }
        }
        PriceDetail::where('price_id', $price->id)->whereNotIn('id', $delete)->delete();

        $price->update($request->all());

        return redirect()->route('price.index')
                        ->with('success','Harga berhasil diupdate');
    }

    public function destroy(Price $price)
    {
        $price->delete();

        return redirect()->route('price.index')
                        ->with('success','Harga berhasil dihapus');
    }
}
