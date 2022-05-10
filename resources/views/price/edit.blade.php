@extends('layouts.app')

@section('title', 'Edit Barang')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h1>Edit Barang</h1>
                <a class="btn btn-secondary" href="{{ route('price.index') }}"> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 margin-tb">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Terjadi kesalah input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('price.update',$price->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Nama Barang:</strong>
                            <input type="text" name="name" value="{{ $price->name }}" class="form-control" placeholder="Nama Barang">
                        </div>
                    </div>
                    <base-price :prices='@json($price->details)'></base-price>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Harga Satuan (1 - 9):</strong>
                            <input type="number" min="0" name="normal_price" value="{{ $price->normal_price }}" class="form-control" placeholder="Harga Satuan">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Harga Kodian (10 - 19)):</strong>
                            <input type="number" min="0" name="bulk_price" value="{{ $price->bulk_price }}" class="form-control" placeholder="Harga Kodian (10 - 19)">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Harga Kodian (>= 20):</strong>
                            <input type="number" min="0" name="bulk_price_too" value="{{ $price->bulk_price_too }}" class="form-control" placeholder="Harga Kodian (>= 20)">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Harga Eceran:</strong>
                            <input type="number" min="0" name="special_price" value="{{ $price->special_price }}" class="form-control" placeholder="Harga Eceran">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
