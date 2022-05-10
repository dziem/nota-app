@extends('layouts.app')

@section('title', 'Detail Restock')

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
                <h1>Detail Restock</h1>
                <a class="btn btn-secondary" href="{{ route('report.restock') }}"> Kembali</a>
            </div>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Nama Supplier:</strong>
                        <p>{{ $restock->name }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Waktu Restock:</strong>
                        <p>{{ date_format(date_create($restock->created_at), 'd M Y H:i:s') }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Daftar Barang:</strong>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="table-dark">
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($restock->details as $key => $value)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->quantity }}</td>
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
