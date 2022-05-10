@extends('layouts.app')

@section('title', 'Laporan Restock')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <h1>Laporan Restock</h1>
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
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $value)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ date_format(date_create($value->created_at), 'd M Y H:i:s') }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->quantity }}</td>
                        <td>{{ rupiah($value->base_price) }}</td>
                        <td>{{ rupiah($value->base_price * $value->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
