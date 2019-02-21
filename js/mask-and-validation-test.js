$(document).ready(function(){
    
  $("#age").mask('00'); 
    $("#height").mask('000'); 
  //    $("#weight").mask('000.00');
    $("#bloodpressure").mask('000');
    

    
   $("#submitForm").validate({
      rules: {
          gender:{
            required: true
          },
          age: {
            required: true,
            range: [30, 74]  
          },
          height:{
              required: true
          },
          weight:{
              required: true
          },
          bloodpressure:{
              required: true,
              range:[60,200]
          },
          hypertension:{
              required: true
          },
          smoker:{
              required: true
          }
          ,diabetes:{
              required: true
          },
      },
      messages: {
            gender: "Género requerido",
            age:{
               required: "Edad Requerida",
               range: "Ingrese una edad entre 30 y 74 años"    
            } ,
            height: "Altura Requerida",
            weight: "Peso Requerido",
            bloodpressure: {
                 required: "Presión sanguinea sistólica requerida",
                 range: "La presión sanguinea sistólica debe ser 60 y 200"
            },
            hypertension: "Necesitamos saber si lleva algún tratamiento", 
            smoker: "Necesitamos saber si usted fuma",
            diabetes: "Necesitamos saber si padece de diabetes"
      },
       errorPlacement: function(error, element){
           if ( element.is(":radio") ) 
            {
              //  error.appendTo( element.parent('.radioParent') );// los radio buttons de este proyecto vienen dentro de un div
                                                                 // lo que permite agregar el error dentro de dicho div        
                if(element.attr("name") == "gender"){                
                      error.appendTo("#errorRadioGenero");
                }
                if(element.attr("name") == "hypertension"){                
                      error.appendTo("#errorRadiohypertension");
                }
                if(element.attr("name") == "smoker"){
                      error.appendTo("#errorRadioSmoker");
                }
                if(element.attr("name") == "diabetes"){
                      error.appendTo("#errorRadioDiabetes");
                }            
            
            }
            else 
            { // This is the default behavior 
                error.insertAfter( element );
            }
       }
    });
  
    
});