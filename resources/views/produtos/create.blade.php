@extends('layouts.app')
@section('title', 'Criar Produto')
@section('content')
    <h2 class="mb-3">Criar Produto</h2>
    <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('produtos._form')
    </form>
@endsection