$(document).ready(function(){
    
   $("#patientname").mask("A", {
	   translation: {
		  "A": { pattern:  /[a-zA-Z ]/, recursive: true }
	   }
   });
    

    
   $("#form").validate({
      rules: {
         patientname: {
            required: true
         },
         patientemail: {
             required: true,
             email: true
         }  
          
         },
         messages: {
            patientname: "Campo Requerido",
            patientemail: "Por favor escriba un correo valido" 
         }
     });
  
    
});