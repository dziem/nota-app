@extends('layouts.app')

@section('title', 'Laporan per Pembeli')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <h1>Laporan per Pembeli</h1>
        <div class="col-lg-12 mt-3">
            <form method="GET" class="row align-items-end">
                <div class="col">
                    <label for="name">Nama</label>
                    <input type="text" name="name" class="form-control mb-2 mr-sm-2" id="name" value="{{ $name }}">
                </div>
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
                        <th>Nama</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $value)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ ucwords($value->lower_name) }}</td>
                        <td>{{ $value->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $items->links() !!}
        </div>
    </div>
@stop
