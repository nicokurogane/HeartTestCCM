$("#submitForm").submit(function(event){
    
    //evitamos que haga el submit normal
    event.preventDefault();
    
    
    // PASAMOS VALIDACIONES PARA QUE LA BASE DE DATOS NO  TENGA DATA SUCIA
    // CHECKBOX VACIOS
    if( !$("input[name='gender']").is(":checked") ){   
        return;
    }
    if( !$("input[name='hypertension']").is(":checked") ){   
        return;
    }
    if( !$("input[name='smoker']").is(":checked") ){   
        return;
    }
    if( !$("input[name='diabetes']").is(":checked") ){   
        return;
    }
    
    //EXTRAEMOS FORMULARIOS DE DEL PACIENTE
    var igenre = $("input[name='gender']:checked").val();
    var iage = $("#age").val();
    var ibloodPressure = $("#bloodpressure").val();
    var ihasHypertensionTreatment = $("input[name='hypertension']:checked").val();
    var iisSmoker = $("input[name='smoker']:checked").val();
    var ihasdiabetes = $("input[name='diabetes']:checked").val();
    var iheight = $("#height").val();
    var iweight = $("#weight").val();
    var iuserid = $("#userid").val();
    
    //tenemos que agregar la variable para retern correo;
    var iuseremail =  $("#useremail").val();
    
    
    
    if(iage == null || ibloodPressure == null || iheight == null || iweight == null){
        return;
    }
    
    console.log(  $("#age").val() );
    //REVISAMOS RANGOS DE LOS CAMPOS QUE LO REQUIERAN
    if ( $("#age").val() < 30 || $("#age").val() > 74){
        console.log("la edad esta fuera de los rangos permitidos");
        return;
    }
    
    if (ibloodPressure < 60 || ibloodPressure > 200){
        console.log("la edad esta fuera de los rangos permitidos");
        return;
    }
    
    
    // pasamos a procesar el formulario   
    $.ajax({
         data:   { "gender"        : igenre,
                   "age"           : iage,
                   "bloodpressure" : ibloodPressure,    
                   "hypertension"  : ihasHypertensionTreatment,
                   "smoker"        : iisSmoker  ,
                   "diabetes"      : ihasdiabetes,
                   "height"        : iheight,
                   "weight"        : iweight  
                 },
        url: '/ccmheart/cvdtest.php',
        type: 'post',
        success: function(data)
        {
            var pdfNameToSend;
            //dependiendo del factor de riesgo
            if(data.calculatedRisk <= 10 ){
                pdfNameToSend = "Resultados1.pdf";
                $("#pdflink").attr("href", "pdf/Resultados1.pdf");
                $("#showPatientWarning").text("RIESGO LEVE");
            }else if(data.calculatedRisk >10 &&  data.calculatedRisk <=20){
                pdfNameToSend = "Resultados2.pdf";
                $("#pdflink").attr("href", "pdf/Resultados2.pdf");
                $("#showPatientWarning").text("RIESGO MODERADO");
            }else if(data.calculatedRisk >20 ){
                pdfNameToSend = "Resultados3.pdf";
                $("#pdflink").attr("href", "pdf/Resultados3.pdf");
                $("#showPatientWarning").text("RIESGO ALTO");
            }            
            
            
            $("#heartAgeResult").text(data.heartAge);
            $("#calculatedRiskResult").text(data.calculatedRisk + "%");
            $("#showPatientRisk").text(data.calculatedRisk + "%");
            
            $("#optimalRiskResult").text(data.optimalRisk + "%");
            $("#normalRiskresult").text(data.normalRisk + "%");
            
            
            if(data.heartAge > 0){
                setTimeout(function(){
                    $("#myModal").modal('show');
                },1500);
            
                $("#btnRecomendation").removeAttr('disabled'); 
            
                sendemail(iuseremail, pdfNameToSend);   
            }            
		}
    
    });
    
        $.ajax({
            data:   { "gender"        : igenre,
                      "age"           : iage,
                      "bloodpressure" : ibloodPressure,    
                      "hypertension"  : ihasHypertensionTreatment,
                      "smoker"        : iisSmoker  ,
                      "diabetes"      : ihasdiabetes,
                      "height"        : iheight,
                      "weight"        : iweight,  
                      "userid"         : iuserid
                   },
            url: '/ccmheart/testanswerresult.php',
            type: 'post',
            success: function(data)
            {                    
		    }
    
        });

});

function sendemail(email, pdfname){

    
    $.ajax({
            data:   { "to"  : email,
                      "pdf" : pdfname,
                   },
            url: '/ccmheart/emailsender.php',
            type: 'post'    
        });    
}


