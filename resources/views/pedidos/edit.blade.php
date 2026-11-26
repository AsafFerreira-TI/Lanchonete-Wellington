@extends('layouts.app')
@section('title', 'Editar Pedido')
@section('content')
    @include('partials.alerts')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pedido #{{ $pedido->id }}</h2>
        <a class="btn btn-outline-secondary" href="{{ route('pedidos.index') }}">Voltar</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold">Adicionar item</h5>
                    <form id="formAddItem">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Produto</label>
                            <select name="produto_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($produtos as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->nome }} (R$ {{ number_format($prod->preco,2,',','.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" value="1" min="1" max="99" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Adicionar (AJAX)</button>
                    </form>

                    <script>
                        window.PW3 = {
                            pedidoId: {{ $pedido->id }},
                            urlAdd: "{{ route('pedidos.itens.storeJson', $pedido) }}",
                            urlDelBase: "{{ url('pedidos/'.$pedido->id.'/itens-json') }}"
                        };
                    </script>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold">Itens do pedido</h5>

                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th class="text-end">Qtd</th>
                                <th class="text-end">Unit.</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="itensBody">
                            @foreach($pedido->itens as $item)
                                <tr id="item-{{ $item->id }}">
                                    <td>{{ $item->produto->nome }}</td>
                                    <td class="text-end">{{ $item->quantidade }}</td>
                                    <td class="text-end">R$ {{ number_format($item->preco_unitario,2,',','.') }}</td>
                                    <td class="text-end">R$ {{ number_format($item->subtotal,2,',','.') }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-danger" data-remove="{{ $item->id }}">Remover</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <div class="fw-bold">Total: <span id="pedidoTotal">R$ {{ number_format($pedido->total,2,',','.') }}</span></div>
                        
                    </table>

                    <div class="d-flex justify-content-end">
                        <div class="fw-bold">Total: R$ {{ number_format($pedido->total,2,',','.') }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function csrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
        
        function moneyBR(value) {
            return (value ?? 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        function showToast(title, body) {
            const el = document.getElementById('pw3Toast');
            document.getElementById('pw3ToastTitle').textContent = title;
            document.getElementById('pw3ToastBody').textContent = body;
            const toast = bootstrap.Toast.getOrCreateInstance(el, { delay: 2500 });
            toast.show();
        }

        function upsertRow(item) {
            const tbody = document.getElementById('itensBody');
            let row = document.getElementById('item-' + item.id);

            const html = `
                <tr id="item-${item.id}">
                    <td>${item.produto.nome}</td>
                    <td class="text-end">${item.quantidade}</td>
                    <td class="text-end">${moneyBR(item.preco_unitario)}</td>
                    <td class="text-end">${moneyBR(item.subtotal)}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-danger" data-remove="${item.id}">Remover</button>
                    </td>
                </tr>`;

            if (row) {
                row.outerHTML = html;
            } else {
                tbody.insertAdjacentHTML('beforeend', html);
            }
        }


        function removeRow(itemId) {
            const row = document.getElementById('item-' + itemId);
            if (row) row.remove();
        }
        
        function setTotal(total) {
            document.getElementById('pedidoTotal').textContent = moneyBR(total);
        }

        document.getElementById('formAddItem').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.currentTarget;
            const fd = new FormData(form);

            try {
                const resp = await fetch(window.PW3.urlAdd, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json'
                    },
                    body: fd
                });

                const data = await resp.json();

                if (!resp.ok) {
                    // 422 validação vem com errors
                    const msg = data.message || 'Erro ao adicionar item.';
                    showToast('Erro', msg);
                    console.error(data);
                    return;
                }

                upsertRow(data.item);
                setTotal(data.pedido.total);
                showToast('Sucesso', data.message);

                // reset rápido
                form.quantidade.value = 1;  
                form.produto_id.value = '';

            } catch (err) {
                console.error(err);
                showToast('Erro', 'Falha de conexão. Verifique servidor e console.');
            }
        });

        // Delegação de evento para botões remover
        document.getElementById('itensBody').addEventListener('click', async (e) => {
            const btn = e.target.closest('[data-remove]');
            if (!btn) return;

            const itemId = btn.getAttribute('data-remove');
            if (!confirm('Remover este item?')) return;

            try {
                const resp = await fetch(`${window.PW3.urlDelBase}/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json'
                    }
                });

                const data = await resp.json();

                if (!resp.ok) {
                    showToast('Erro', data.message || 'Erro ao remover.');
                    console.error(data);
                    return;
                }

                removeRow(data.removed_item_id);
                setTotal(data.pedido.total);
                showToast('Sucesso', data.message);

            } catch (err) {
                console.error(err);
                showToast('Erro', 'Falha de conexão.');
            }   
        });
    </script>

    <div class="card mt-3">
  <div class="card-body">
    <h5 class="fw-bold">Entrega</h5>

    <div class="row g-2">
      <div class="col-md-4">
        <label class="form-label">CEP</label>
        <input id="cep" class="form-control" placeholder="00000-000">
        <div class="form-text">Digite o CEP e clique em Buscar.</div>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button id="btnBuscarCep" class="btn btn-outline-secondary w-100" type="button">Buscar</button>
      </div>

      <div class="col-md-6">
        <label class="form-label">Logradouro</label>
        <input id="logradouro" class="form-control">
      </div>

      <div class="col-md-4">
        <label class="form-label">Bairro</label>
        <input id="bairro" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Cidade</label>
        <input id="cidade" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">UF</label>
        <input id="uf" class="form-control" maxlength="2">
      </div>
    </div>
  </div>
</div>

<script>
  window.PW3CEP = {
    urlBase: "{{ url('/cep') }}" // GET /cep/{cep}
  };

  function showToast(title, body) {
  const el = document.getElementById('pw3Toast');
  document.getElementById('pw3ToastTitle').textContent = title;
  document.getElementById('pw3ToastBody').textContent = body;
  const toast = bootstrap.Toast.getOrCreateInstance(el, { delay: 2500 });
  toast.show();
}

function onlyDigits(v){
  return (v || '').replace(/\D/g, '');
}

document.getElementById('btnBuscarCep')?.addEventListener('click', async () => {
  const cepEl = document.getElementById('cep');
  const cep = onlyDigits(cepEl.value);

  try {
    const resp = await fetch(`${window.PW3CEP.urlBase}/${cep}`, {
      headers: { 'Accept': 'application/json' }
    });

    const data = await resp.json();

    if (!resp.ok) {
      showToast('Erro', data.message || 'Falha ao consultar CEP.');
      return;
    }

    document.getElementById('logradouro').value = data.logradouro || '';
    document.getElementById('bairro').value = data.bairro || '';
    document.getElementById('cidade').value = data.localidade || '';
    document.getElementById('uf').value = data.uf || '';

    showToast('Sucesso', data.message);
  } catch (e) {
    console.error(e);
    showToast('Erro', 'Falha de conexão. Verifique servidor e internet.');
  }
});
</script>
@endsection