@extends('layouts.app')

@section('title', 'Detail Barang')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h1>Detail Barang</h1>
                <a class="btn btn-secondary" href="{{ route('price.index') }}"> Kembali</a>
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
                <base-price-view :prices='@json($price->details)'></base-price-view>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Harga Satuan (1 - 9):</strong>
                        <p>{{ rupiah($price->normal_price) }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Harga Kodian (10 - 19):</strong>
                        <p>{{ rupiah($price->bulk_price) }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Harga Kodian (>= 20):</strong>
                        <p>{{ rupiah($price->bulk_price_too) }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Harga Eceran:</strong>
                        <p>{{ rupiah($price->special_price) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
