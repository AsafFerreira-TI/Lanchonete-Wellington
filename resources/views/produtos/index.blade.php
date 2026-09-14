@extends('layouts.app')
@section('title', 'Produtos')
@section('content')
    @include('partials.alerts')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Produtos</h2>
        <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->nome }}</td>
                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                            <td>{{ $produto->categoria ? $produto->categoria->nome : 'Sem categoria' }}</td>
                            <td>
                                @if ($produto->imagem)
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Imagem do produto" class="img-thumbnail" style="max-width: 800px;">
                                @else
                                    Sem imagem
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('produtos.edit', ['produto' => $produto]) }}" class="btn btn-sm btn-warning">Editar</a>

                                <form action="{{ route('produtos.destroy', ['produto' => $produto]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $produtos->links() }}
    </div>
@endsection