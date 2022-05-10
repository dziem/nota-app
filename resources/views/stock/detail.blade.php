@extends('layouts.app')

@section('title', 'Detail Stock')

@section('sidebar')
    @parent
@stop

@php
    $i = 0;
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h1>Detail Stock</h1>
                <a class="btn btn-secondary" href="{{ route('stock.index') }}"> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Nama Barang:</strong>
                        <p>{{ $price->name }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Daftar Stock:</strong>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="table-dark">
                                    <th>No</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($price->details as $key => $value)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ rupiah($value->base_price) }}</td>
                                    <td>{{ $value->stock }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
