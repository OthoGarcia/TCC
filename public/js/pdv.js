$(document).ready(function() {
   if($('#cupom').length){
      $('#pdv_form').submit(function(e){
      e.preventDefault();
      var form = $('#pdv_form')[0];
      var data = new FormData(form);
      $("#autocomplete").val("");
      $.ajax({
       url: '/pdv/salvar',
       type: "POST",
        data: data,
         enctype: 'multipart/form-data',
         processData: false,  // Important!
         contentType: false,
         cache: false,
       success: function(data){
          console.log(data);
          data = jQuery.parseJSON(data);
          if(data.peso != null){
             $("#autocomplete").val(data.cod_barras);
             $("#preco").val(data.preco);
             $("#div_peso").show();
             $('#peso').focus();
          }else{
             $("#div_peso").hide();
             $('#autocomplete').focus();
          }
          if($("#"+ data[0].cod_barras).length){
            $("#"+ data[0].cod_barras).closest('tr').remove();
            $("#n_"+ data[0].cod_barras).closest('tr').remove();
          }
          var quantidade;
          console.log(data[0].pivot.peso);
          if (data[0].pivot.peso == 0 || data[0].pivot.peso == null) {
             quantidade = data[0].pivot.quantidade;
          }else{
             quantidade = data[0].pivot.peso + 'g';
          }
          $( "#autocomplete" ).autocomplete('close');
          if ($('#cupom tr:first').find('tr').length) {
             $('#cupom tr:first').before(
               '<tr id=n_'+ data[0].cod_barras+' class="top">'+
                 ' <td colspan="3">'+ data[0].nome+'</td>'+
               '</tr>'+
            '<tr id='+ data[0].cod_barras+'>'+
              '<td >R$:'+ data[0].preco+' </td>'+
              '<td >'+ quantidade +'</td>'+
              '<td >R$: '+ data[0].pivot.sub_total+'</td>'+
            '</tr>'
           );

          }else {
             $('#cupom').append(
               '<tr id=n_'+ data[0].cod_barras+' class="top">'+
                 ' <td colspan="3">'+ data[0].nome+'</td>'+
               '</tr>'+
            '<tr id='+ data[0].cod_barras+'>'+
              '<td >R$:'+ data[0].preco+' </td>'+
              '<td >'+quantidade+'</td>'+
              '<td >R$: '+ data[0].pivot.sub_total+'</td>'+
            '</tr>'
           );
          }
           $("#cupom_subTotal").html(data[1].total);
           $("#total").val(data[1].total);
       },
         error: function (e) {
             $("#result").text(e.responseText);
             console.log("ERROR : ", e);
             $("#btnSubmit").prop("disabled", false);
         }
      });
   });
   }
   //atalhos para os botoes finalizar e deletar
   var pressedAlt = false; //variável de controle
	 $(document).keyup(function (e) {  //O evento Kyeup é acionado quando as teclas são soltas
	 	if(e.which == 18) pressedAlt=false; //Quando qualuer tecla for solta é preciso informar que Crtl não está pressionada
   });
	$(document).keydown(function (e) { //Quando uma tecla é pressionada
		if(e.which == 18) pressedAlt = true; //Informando que Crtl está acionado
      if ((e.which == 50|| e.keyCode == 50)&& pressedAlt == true) {
         $("#deletar")[0].click();
      }else if((e.which == 51|| e.keyCode == 51) && pressedAlt == true) { //Reconhecendo tecla Enter
			$("#finalizar").click();
      }
	});
   //colocando peso quando o produto pedir
   $('#autocomplete').focus();
   if($('#autocomplete').val() != ""){
      if (!submit()) {
         $("#div_peso").hide();
         $('#peso').focus();
      }else{
         $('#autocomplete').focus();
      }
   }else{
      $("#div_peso").hide();
   }
   $('#valor').change(function (e) {
      var value = parseFloat($('#valor').val()) - parseFloat($('#total').val());
      console.log(value.toFixed(2));
    $('#troco').val(value.toFixed(2));
   });
   $('#valor').keyup(function (e) {
      var value = parseFloat($('#valor').val()) - parseFloat($('#total').val());
    $('#troco').val(value.toFixed(2));
   });
   $('#pagar').click(function (e) {
      if($('#troco').val() < 0){
         e.preventDefault();
         alert("O troco não pode ser negativo");
      }else if ($('#troco').val() == "") {
         e.preventDefault();
         alert("O Campo Valor não pode estar vazio para este tipo de pagamento");
      }
   });
   //add total na tela de pagamento
   $( "#finalizar" ).click(function() {
      $( "#total_pagamento" ).val($("#total").val());
   });
});
var myvar;
$.ui.autocomplete.prototype.options.autoSelect = true;
$( "#autocomplete" ).autocomplete({
    source: function( request, response ) {
        $.ajax({
            dataType: "json",
            type : 'Get',
            url: '/autocomplete/' + $('#autocomplete').val(),
            success: function(data) {
              myvar = data;
              if (data.length == 1) {
                 $('#autocomplete').val(data[0].cod_barras);
                 $('#pdv_form').submit();
              }
              response($.map(data, function (value, key) {
               return {
                   label: value.nome,
                   value: value.id,
                   preco: value.preco,
                   peso: value.peso,
                   cod : value.cod_barras
               }
              }));
           }
         });
    },focus: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox
        $(this).val(ui.item.cod_barras);
     },select: function(event, ui) {
        $("#preco").val(ui.item.preco);
        $("#autocomplete").val(ui.item.cod_barras);
        $('#peso').focus();
        console.log(ui.item.preco);
        if (ui.item.peso == null) {
            $("#div_peso").hide();
            $('#pdv_form').submit();
        }else{
           $("#div_peso").show();
           $('#peso').focus();
        }
     }
});
$('#autocomplete').keypress(function (e) {
  if (e.which == 13) {
    $('#pdv_form').submit();
    return false;    //<---- Add this line
  }
});
$('#peso').keypress(function (e) {
  if (e.which == 13) {
    $('#pdv_form').submit();
    return false;    //<---- Add this line
  }
});
function submit(){
  var submter      = false;
  $.ajax({
      dataType: "json",
      type : 'Get',
      url: '/peso/' + $('#autocomplete').val(),
      success: function(data) {
        if(data.peso != null){
          if ($("#peso").val().length == 0) {
           $("#div_peso").show();
           $("#preco").val(data.preco);
           $('#peso').focus();
           console.log("1");
          }
          return false;
        }else {
          return true;
          console.log("2");
        }
     }
   });
}
