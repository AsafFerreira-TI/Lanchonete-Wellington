@extends('layouts.app')
@include('partials.alerts')
@section('title', 'Contato')
@section('content')
    <div class="container">
        <h1 class="mb-4">Contato</h1>
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Digite seu email">
        </div>
        <div class="form-group mb-3">
            <label for="mensagem">Mensagem:</label>
            <textarea class="form-control" id="mensagem" rows="5" placeholder="Digite sua mensagem"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
@endsection 