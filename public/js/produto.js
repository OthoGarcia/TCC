$(document).ready(function(){
  if ($("#tipo").val() == "0"){
    $("#peso").hide();
  }else{
    $("#peso").show();
  }
  $('select').on('change', function() {
    if ($("#tipo").val() == "0"){
      $("#peso").hide();
    }else{
      $("#peso").show();
    }
  });
});
