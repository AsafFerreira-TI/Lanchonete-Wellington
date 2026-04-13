@extends('layouts.app')
@include('partials.alerts')
@section('title', 'Sobre Nós')
@section('content')
    <div class="container">
        <h1 class="mb-4">Sobre a Lanchonete</h1>
        <div class="card">
            <div class="card-body">
                <p class="lead">
                    {{ $aboutus }}
                </p>
            </div>
        </div>
    </div>
@endsection
