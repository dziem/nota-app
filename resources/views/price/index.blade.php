@extends('layouts.app')

@section('title', 'Harga Barang')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h1>Daftar Harga Barang</h1>
                <a class="btn btn-primary" href="{{ route('price.create') }}"> Tambah</a>
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
                        <th>Harga Beli</th>
                        <th>Harga Satuan</th>
                        <th>Harga Kodian (10 - 19)</th>
                        <th>Harga Kodian (>= 20)</th>
                        <th>Harga Eceran</th>
                        <th width="280px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $value)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ rupiah($value->details()->orderBy('updated_at', 'desc')->first()->base_price) }}</td>
                        <td>{{ rupiah($value->normal_price) }}</td>
                        <td>{{ rupiah($value->bulk_price) }}</td>
                        <td>{{ rupiah($value->bulk_price_too) }}</td>
                        <td>{{ rupiah($value->special_price) }}</td>
                        <td>
                            <form action="{{ route('price.destroy',$value->id) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('price.show',$value->id) }}">Detail</a>
                                <a class="btn btn-warning" href="{{ route('price.edit',$value->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $data->links() !!}
        </div>
    </div>
@stop
