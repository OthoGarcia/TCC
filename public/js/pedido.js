
   function Gerar_sub_total(id) {
      var quantidade = $('#quantidade'+id).val();
      var preco = $('#preco'+id).val();
      $('#sub_total'+id).val(parseFloat(preco)*parseInt(quantidade));
   }
   //modal de ADD produto repetido
     // Get the modal
     var modal = document.getElementById('myModal');

     // Get the button that opens the modal
     var btn = document.getElementById("myBtn");

     // Get the <span> element that closes the modal
     var span = document.getElementsByClassName("close")[0];

     // When the user clicks the button, open the modal
     $( document ).ready(function() {
         modal.style.display = "block";
     });

     // When the user clicks on <span> (x), close the modal
     span.onclick = function() {
         modal.style.display = "none";
     }

     // When the user clicks anywhere outside of the modal, close it
     window.onclick = function(event) {
         if (event.target == modal) {
             modal.style.display = "none";
         }
     }

     var modalP = document.getElementById('modalPagamento');

     // Get the <span> element that closes the modal
     var spanP = document.getElementsByClassName("close")[0];

     // When the user clicks the button, open the modal
     $( document ).ready(function() {
         modalP.style.display = "block";
     });

     // When the user clicks on <span> (x), close the modal
     spanP.onclick = function() {
         modalP.style.display = "none";
     }

     // When the user clicks anywhere outside of the modal, close it
     window.onclick = function(event) {
         if (event.target == modal) {
             modalP.style.display = "none";
         }
     }


     //adicionando campo de parcelas
     $('#vezes').keyup( function(){
        gerar_data();
     });
     $('#vezes').click( function(){
        gerar_data();
     });

     function gerar_data(){
        var i=0;
        while ($('#data'+i).length != 0) {
           $('#data'+i).remove();
           $('#div'+i).remove();
           $('#label'+i).remove();
           i++;
        }

        for (var i = 0; i < $('#vezes').val(); i++) {
           //criado a div
           $('<div class="form-group ">').attr('id',"div"+i).appendTo('#form_pagamento');
           $('<label id="label'+i+'" for="data[]" class="col-sm-2 control-label">Data Parcela '+i+'</label>').appendTo('#form_pagamento');
              $('<input />').attr('type', 'date')
              .attr('name', "data[]")
              .attr('id',"data"+i)
              .appendTo('#form_pagamento');
           $('</div">').appendTo('#form_pagamento');
        }
     }   
     $(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='form_pagamento']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      vezes: "required",
      data: "required"
    },
    // Specify validation error messages
    messages: {
      vezes: "Please enter your firstname",
      data: "Please enter your lastname"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});
