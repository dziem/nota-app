@extends('layouts.app')

@section('title', 'Laporan per Barang')

@section('sidebar')
    @parent
@stop

@php
    $i = 0;
    $totalEarning = 0;
    $totalProfit = 0;
@endphp

@section('content')
    <div class="row">
        <h1>Laporan per Barang</h1>
        <div class="col-lg-12 mt-3">
            <form method="GET" class="row align-items-end">
                <div class="col">
                    <label for="startDate">Tanggal Awal</label>
                    <input type="date" name="start_date" class="form-control mb-2 mr-sm-2" id="startDate" value="{{ $start_date }}">
                </div>
                <div class="col">
                    <label for="endDate">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control mb-2 mr-sm-2" id="endDate" value="{{ $end_date }}">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                </div>
            </form>
        </div>
        <div class="col-lg-12 mt-3">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="table-dark">
                        <th>No</th>
                        <th>Merek</th>
                        <th>Jumlah</th>
                        <th>Total Penjualan</th>
                        <th>Total Keuntungan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $value)
                    <tr>
                        @php
                            $totalEarning = $totalEarning + $value->earning;
                            $totalProfit = $totalProfit + $value->profit;
                        @endphp
                        <td>{{ ++$i }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->quantity }}</td>
                        <td>{{ rupiah($value->earning) }}</td>
                        <td>{{ rupiah($value->profit) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="text-end" colspan="3">Total</td>
                        <td>{{ rupiah($totalEarning) }}</td>
                        <td>{{ rupiah($totalProfit) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
