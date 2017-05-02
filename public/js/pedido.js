
   function Gerar_sub_total(id) {
      var quantidade = $('#quantidade'+id).val();
      var preco = $('#preco'+id).val();
      $('#sub_total'+id).val(parseFloat(preco)*parseInt(quantidade));
   }
