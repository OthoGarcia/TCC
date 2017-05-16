$(document).ready(function() {
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
        $(this).val(ui.item.label);
     },select: function(event, ui) {
        $("#preco").val(ui.item.preco);
        $("#autocomplete").val(ui.item.id);
        $('#peso').focus();
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
