<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function customer(Request $request) {
        $items = [];
        $name = '';
        $start_date = date('Y-m-01');
        $end_date  = date('Y-m-t');
        $items = DB::table('transaction')
                    ->selectRaw('sum(transaction_detail.quantity) as total, lower(transaction.name) as lower_name')
                    ->join('transaction_detail', 'transaction.id', '=', 'transaction_detail.transaction_id')
                    ->whereNotNull('transaction.name');
        if ($request->exists('start_date') && $request->exists('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
        }
        if ($request->exists('name') && $request->name != null && $request->name != '') {
            $name = $request->name;
            $items->whereRaw("lower(transaction.name) like '%" . strtolower($name) . "%'");
        }
        $items = $items->whereBetween('transaction.created_at', [date($start_date), date($end_date)]);
        $items = $items->groupByRaw('lower(transaction.name)');
        $items = $items->orderByRaw('lower(transaction.name)')->paginate(25);
        return view('report.customer', compact('items', 'name', 'start_date', 'end_date'))
                ->with('i', (request()->input('page', 1) - 1) * 25);
    }

    public function item(Request $request) {
        $items = [];
        $start_date = date('Y-m-01');
        $end_date  = date('Y-m-t');
        $items = DB::table(DB::raw('(select name, quantity, profit, transaction_id, (price * quantity) as earning from transaction_detail) as transaction_detail'))
                    ->selectRaw('transaction_detail.name, sum(transaction_detail.quantity) as quantity, sum(transaction_detail.profit) as profit, sum(transaction_detail.earning) as earning')
                    ->join('transaction', 'transaction.id', '=', 'transaction_detail.transaction_id')
                    ->whereNotNull('transaction_detail.name');
        if ($request->exists('start_date') && $request->exists('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
        }
        $items = $items->whereBetween('transaction.created_at', [date($start_date), date($end_date)]);
        $items = $items->groupBy('transaction_detail.name');
        $items = $items->orderBy('transaction_detail.name')->get();
        return view('report.item', compact('items', 'start_date', 'end_date'));
    }

    public function restock(Request $request) {
        $items = [];
        $start_date = date('Y-m-01');
        $end_date  = date('Y-m-t');
        /*$items = DB::table('restock')
                    ->selectRaw('sum(restock_detail.quantity) as total, restock.created_at, restock.name, restock.id')
                    ->join('restock_detail', 'restock.id', '=', 'restock_detail.restock_id');*/
        if ($request->exists('start_date') && $request->exists('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
        }
        $items = DB::table('restock_detail')
                ->selectRaw('restock_detail.name, restock_detail.base_price, restock_detail.quantity, restock.created_at')
                ->join('restock', 'restock.id', '=', 'restock_detail.restock_id');
        $items = $items->whereBetween('restock.created_at', [date($start_date), date($end_date)]);
        //$items = $items->groupBy('restock.created_at')->groupBy('restock.name')->groupBy('restock.id');
        $items = $items->orderBy('restock.created_at', 'desc')->paginate(25);
        return view('report.restock', compact('items', 'start_date', 'end_date'))
                ->with('i', (request()->input('page', 1) - 1) * 25);
    }

    public function restockDetail($id) {
        $restock = Restock::find($id);
        return view('report.restock-detail', compact('restock'));
    }
}
