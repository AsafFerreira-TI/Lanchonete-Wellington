@extends('layouts.app')
@section('title', 'Nova Categoria')
@section('content')
    <h2 class="mb-3">Nova Categoria</h2>
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf

        @include('categorias._form')

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Criar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection