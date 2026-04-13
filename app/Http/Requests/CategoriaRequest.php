<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaRequest extends FormRequest
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
        // Se estiver editando, o model vem pela rota (Route Model Binding)
        $categoriaId = $this->route('categoria')?->id;
        return [
            'nome' => [
                'required', 
                'string', 
                'max:100', 
                Rule::unique('categorias', 'nome')->ignore($categoriaId)
            ],
            'descricao' => 'nullable|string|max:500',
            'ativa' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome da categoria.',
            'nome.max' => 'O nome da categoria deve ter no máximo :max caracteres.',
            'nome.unique' => 'Já existe uma categoria com esse nome.',
            'descricao.max' => 'A descrição deve ter no máximo :max caracteres.',
        ];
    }
}
