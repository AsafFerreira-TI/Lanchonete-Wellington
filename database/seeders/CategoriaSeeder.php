<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fixas = [
            ['nome' => 'Bebidas', 'descricao' => 'Sucos, refrigerantes e água', 'ativa' => true],
            ['nome' => 'Lanches', 'descricao' => 'Sanduíches e porções', 'ativa' => true],
            ['nome' => 'Doces', 'descricao' => 'Sobremesas e guloseimas', 'ativa' => true],
        ];

        foreach($fixas as $c) {
            Categoria::firstOrCreate(['nome' => $c['nome']], $c);
        }

        Categoria::factory()->count(5)->create();
    }
}
