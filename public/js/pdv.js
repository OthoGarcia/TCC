$(document).ready(function() {

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
      }
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
                 $('#pdv_form').submit();
              }
              response($.map(data, function (value, key) {
               return {
                   label: value.nome,
                   value: value.id,
                   preco: value.preco,
                   peso: value.peso
               }
              }));
           }
         });
    },focus: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox
        $(this).val(ui.item.value);
     },select: function(event, ui) {
        $("#preco").val(ui.item.preco);
        $("#autocomplete").val(ui.item.value);
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
