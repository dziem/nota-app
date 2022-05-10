@extends('layouts.app')

@section('title', 'Stok Barang')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h1>Daftar Stok Barang</h1>
                <a class="btn btn-primary" href="{{ route('stock.add') }}"> Tambah</a>
            </div>
        </div>
        <div class="col-lg-12 mt-3">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="table-dark">
                        <th>No</th>
                        <th>Merek</th>
                        <th>Total Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                    @php
                        $total = 0;
                        foreach ($value->details as $item) {
                            $total = $total + $item->stock;
                        }
                    @endphp
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $total }}</td>
                        <td><a class="btn btn-primary" href="{{ route('stock.detail',$value->id) }}">Detail</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $data->links() !!}
        </div>
    </div>
@stop
