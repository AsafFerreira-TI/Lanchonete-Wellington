<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Produto;

class ItemPedidoController extends Controller
{
    public function storeJson(Request $request, Pedido $pedido){
        $dados = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1|max:99',
        ]); // os dados (id do produto e quantidade), e seus tipos definidos;

        $produto = Produto::findOrFail($dados['produto_id']); // $produto deve ser igual aos dados da classe Produto

        $preco = $produto->preco; // $preco acessa o preço do objeto conceitual produto
        $subtotal = $preco * $dados['quantidade']; // o subtotal de cada item é determinado pela quantidade do produto adicionado ao carrinho.

        $item = ItemPedido::where('pedido_id', $pedido->id)->where('produto_id', $produto->id)->first(); // o item deve ser correspondente ao que já foi registrado em ItemPedido, correspondente ao id do produto

        if($item) { // se o item existir...
            $item->quantidade += $dados['quantidade']; //a quantidade do item recebe incrementadamente a quantidade determinada na variável $dados
            $item->preco_unitario = $preco; // a variável preco_unitario da instância item recebe o preco da classe Produto. 
            $item->subtotal = $item->quantidade * $preco; // subtotal é igual à quantidade multiplicada pelo preco de um item;
            $item->save(); // isso aqui preciso explicar?
        } else { // se não...
            ItemPedido::create([
                'pedido_id' => $pedido->id,
                'produto_id' => $produto->id,
                'quantidade' => $dados['quantidade'],
                'preco_unitario' => $preco,
                'subtotal' => $subtotal,
            ]);
        }

        // Recalcular total
        $pedido->total = itemPedido::where('pedido_id', $pedido->id)->sum('subtotal');
        $pedido->save();
        
        return response()->json([
            'message' => 'Item adicionado!',
            'pedido' => [
                'id' => $pedido->id,
                'total' => (float) $pedido->total,
            ],

            'item' => [
                'id' => $item->id,
                'produto' => [
                    'id' => $item->produto->id,
                    'nome' => $item->produto->nome,
                ],
                'quantidade' => (int) $item->quantidade,
                'preco_unitario' => (float) $item->preco_unitario,
                'subtotal' => (float) $item->subtotal,
            ]
        ], 200);
    }

    public function destroyJson(Pedido $pedido, ItemPedido $itemPedido){
        // Garante que o tem pertence ao pedido
        abort_unless($itemPedido->pedido_id === $pedido->id, 404);
        $itemPedido->delete();

        $pedido->total = ItemPedido::where('pedido_id', $pedido->id)->sum('subtotal');
        $pedido->save();
        
        return response()->json([
            'message' => 'Item removido!',
            'pedido' => [
                'id' => $pedido->id,
                'total' => (float) $pedido-> total,
            ],
            'removed_item_id' => (int) $itemPedido->id,
        ], 200);
    }
}
