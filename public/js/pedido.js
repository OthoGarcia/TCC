$(document).ready(function(){
   $('#preco').keyup(function() {
      var preco = this.value;
      var quantidade = $('#quantidade').val();
      $('#sub_total').val(parseFloat(preco)*parseInt(quantidade));
   });
   $('#quantidade').keyup(function() {
      var quantidade = this.value;
      var preco = $('#preco').val();
      $('#sub_total').val(parseFloat(preco)*parseInt(quantidade));
   });
});
