
   function sub_total(id) {
      var quantidade = $('#quantidade'+id).val();
      var preco = $('#preco'+id).val();      
      $('#sub_total'+id).val(parseFloat(preco)*parseInt(quantidade));
   }

/*
$('#preco'+i).keyup(function() {
   var preco = this.value;
   var quantidade = $('#quantidade'+i).val();
   $('#sub_total'+i).val(parseFloat(preco)*parseInt(quantidade));
});
$('#quantidade'+i).keyup(function() {
   var quantidade = this.value;
   var preco = $('#preco'+i).val();
   $('#sub_total'+i).val(parseFloat(preco)*parseInt(quantidade));
});
*/
