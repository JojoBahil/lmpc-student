$(function() {
      
   var $cbox = $('input[name="chkAddress"]');
   $cbox.change(function(){
        var checked = $cbox.prop('checked');
        if(checked){
            $('#txt_prestreet').val($("#txt_perstreet").val());
            $('#txt_prebrgy').val($("#txt_perbrgy").val()); 
            $('#txt_precity').val($("#txt_percity").val()); 
            $('#txt_preprovince').val($("#txt_perprovince").val()); 
            $('#txt_prezip').val($("#txt_perzip").val());  
        }
        
   });

   
  });