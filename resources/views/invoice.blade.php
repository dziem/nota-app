@extends('layouts.app')

@section('title', 'Nota')

@section('sidebar')
    @parent
@stop

@section('content')
    <div class="row">
        <h1>Nota Baru</h1>
        <form action="{{ url('/invoice') }}" autocomplete="off" method="POST">
            @csrf
            <invoice-form :prices='@json($prices)'
            ></invoice-form>
        </form>
    </div>
@stop
