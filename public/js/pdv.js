$.ui.autocomplete.prototype.options.autoSelect = true;
$( "#autocomplete" ).autocomplete({
    source: function( request, response ) {
        $.ajax({
            dataType: "json",
            type : 'Get',
            url: '/autocomplete/' + $('#autocomplete').val(),
            success: function(data) {
              response($.map(data, function (value, key) {
               return {
                   label: value.nome,
                   value: value.id,
                   preco: value.preco
               }
              }));
           },error: function(data) {
                alert('error');
            }
         });
    },focus: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox
        $(this).val(ui.item.label);
     },select: function(event, ui) {
        $("#preco").val(ui.item.preco);
     }
});
$('#autocomplete').keypress(function (e) {
  if (e.which == 13) {
    $('#pdv_form').submit();
    return false;    //<---- Add this line
  }
});
