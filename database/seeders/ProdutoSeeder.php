<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fixas = [
            ['categoria_id' => 1, 'nome' => 'Coca-Cola', 'descricao' => 'Refrigerante de cola', 'preco' => 8.50, 'ativo' => true],
            ['categoria_id' => 1, 'nome' => 'Suco de Laranja', 'descricao' => 'Suco natural de laranja', 'preco' => 7.00, 'ativo' => true],
            ['categoria_id' => 2, 'nome' => 'X-Burger', 'descricao' => 'Hambúrguer com queijo', 'preco' => 15.00, 'ativo' => true],
            ['categoria_id' => 2, 'nome' => 'Porção de Batata Frita', 'descricao' => 'Batatas fritas crocantes', 'preco' => 12.00, 'ativo' => true],
            ['categoria_id' => 3, 'nome' => 'Brigadeiro', 'descricao' => 'Doce de chocolate tradicional', 'preco' => 5.00, 'ativo' => true],
        ];
        foreach($fixas as $p) {
            Produto::firstOrCreate(['nome' => $p['nome']], $p);
        }

        Produto::factory()->count(20)->create();
    }
}
