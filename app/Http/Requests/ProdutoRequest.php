<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $produtoId = $this->route('produto')?->id;

        return [
            'nome' => [
                'required', 
                'string', 
                'max:100', 
                Rule::unique('produtos', 'nome')->ignore($produtoId)
            ],
            'preco' => 'required|numeric|min:0.01',
            'categoria_id' => 'required|exists:categorias,id',
            'descricao' => [
                'nullable',
                'string',
                'max:500',
            ],
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ativo' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do produto.',
            'nome.max' => 'O nome do produto deve ter no máximo :max caracteres.',
            'nome.unique' => 'Já existe um produto com esse nome.',
            'preco.required' => 'Informe o preço do produto.',
            'preco.numeric' => 'O preço do produto deve ser um número válido.',
            'preco.min' => 'O preço do produto deve ser um valor positivo.',
            'categoria_id.required' => 'Informe a categoria do produto.',
            'categoria_id.exists' => 'A categoria informada não existe.',
            'ativo.boolean' => 'O campo ativo deve ser um valor booleano.',
            'descricao.max' => 'A descrição do produto deve ter no máximo :max caracteres',
            'imagem.image' => 'A imagem deve ser um arquivo de imagem válido.',
            'imagem.mimes' => 'A imagem deve ser um dos seguintes tipos: jpeg, png, jpg, webp.',
            'imagem.max' => 'A imagem não pode exceder 2MB.',
        ];
    }
    
}
