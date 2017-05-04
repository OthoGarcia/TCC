<h1>ODSISTEMAS</h1>
<h3>Pedido</h3>
<table>
   <tr>
      <th>Pedido</th>
      <th>Data</th>
      <th>Fornecedor</th>
      <th colspan="3" >descricao</th>
   </tr>
   <tr>
      <td>{{ $pedido->id }}</td>
      <td>{{ $pedido->updated_at}}</td>
      <td>{{ $pedido->descricao}}</td>
   </tr>
</table>
<hr>
<h3>Produtos</h3>
<table>
   <tr>
      <th>Codigo</th>
      <th>Produto</th>
      <th>Categoria</th>
      <th>Quantidade</th>
      <th>Preco</th>
      <th>Sub Total</th>
   </tr>
   @foreach ($produtos as $produto)
      <tr>
         <td>{{ $produto->id}}</td>
         <td>{{ $produto->nome}}</td>
         <td>{{ $produto->categoria->nome}}</td>
         <td>{{ $produto->pivot->quantidade }}</td>
         <td>{{ $produto->pivot->preco }}</td>
         <td>{{ $produto->pivot->sub_total }}</td>
      </tr>
   @endforeach
</table>
