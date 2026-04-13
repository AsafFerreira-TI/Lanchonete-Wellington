@extends('layouts.app')
@section('title', 'Detalhes da Categoria')
@section('content')
    @include('partials.alerts')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $categoria->nome }}</h2>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9">{{ $categoria->nome }}</dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9">{{ $categoria->descricao ?: 'Nenhuma descrição fornecida.' }}</dd>

                <dt class="col-sm-3">Ativa</dt>
                <dd class="col-sm-9">
                    @if ($categoria->ativa)
                        <span class="badge text-bg-success">Sim</span>
                    @else
                        <span class="badge text-bg-secondary">Não</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Criada em</dt>
                <dd class="col-sm-9">{{ $categoria->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Atualizada em</dt>
                <dd class="col-sm-9">{{ $categoria->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@endsection