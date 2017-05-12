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
                   value: value.id
               }
              }));
            },
            error: function(data) {
                alert('error');
            }
        });
    }
});
$('#autocomplete').keypress(function (e) {
  if (e.which == 13) {
    $('#pdv_form').submit();
    return false;    //<---- Add this line
  }
});
