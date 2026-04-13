<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categoria_id' => Categoria::factory(),
            'nome' => $this->faker->unique()->words(2, true),
            'descricao' => $this->faker->sentence(12), // Descrição não pode ser opcional, pois é um campo obrigatório
            'preco' => $this->faker->randomFloat(2, 5, 60), // R$ 5,00 a R$ 60,00 (comentário feito para entendimento do código)
            'ativo' => $this->faker->boolean(90),
        ];
    }
}
