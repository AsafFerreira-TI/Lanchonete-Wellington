@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Entrar</h1>

    <form action="{{ route('login') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
</div>
@endsection