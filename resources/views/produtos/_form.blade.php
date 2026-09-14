@php
    $isEdit = isset($produto);
@endphp

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $produto->nome ?? '') }}" maxlength="100" required>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="3" maxlength="500">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="preco" class="form-label">Preço</label>
    <input type="number" step="0.01" class="form-control @error ('preco') is-invalid @enderror" id="preco" name="preco" value="{{ old('preco', $produto->preco ?? '') }}" required>
    @error('preco')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>  

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoria</label>
    <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id">
        <option value="">Selecione uma categoria</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ old('categoria_id', $produto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nome }}
            </option>
        @endforeach
    </select>
    @error('categoria_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $produto->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="ativo">Ativo</label>
</div>

<div class="mb-3">
    <label for="imagem" class="form-label">Imagem</label>
    <input type="file" class="form-control @error('imagem') is-invalid @enderror" id="imagem" name="imagem">
    @error('imagem')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if ($isEdit && $produto->imagem)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Imagem do produto" class="img-thumbnail" style="max-width: 800px;">
        </div>
    @endif
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Atualizar' : 'Criar' }}</button>
    <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
</div>