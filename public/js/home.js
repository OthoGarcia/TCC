$(document).ready(function() {
   var ajax_call = function() {
      $.ajax({
       url: '/home/listaEstoque',
       type: "GET",
         cache: false,
       success: function(data){
          console.log(data);

       },
         error: function (e) {
             console.log("ERROR : ", e);
         }
      });
   };
   setInterval(ajax_call,10000);
});
