@extends('layouts.app')

@section('title', 'Tambah Stok')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <h1>Tambah Stok</h1>
        <form action="{{ url('/stock/add') }}" autocomplete="off" method="POST">
            @csrf
            <restock-form :prices='@json($prices)'
            ></restock-form>
        </form>
    </div>
@stop
