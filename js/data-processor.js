$("#submitForm").submit(function(event){
    
    //evitamos que haga el submit normal
    event.preventDefault();
    
    //EXTRAEMOS FORMULARIOS DE DEL PACIENTE
    var igenre = $("input[name='gender']:checked").val();
    var iage = $("#age").val();
    var ibloodPressure = $("#bloodpressure").val();
    var ihasHypertensionTreatment = $("input[name='hypertension']:checked").val();
    var iisSmoker = $("input[name='smoker']:checked").val();
    var ihasdiabetes = $("input[name='diabetes']:checked").val();
    var iheight = $("#height").val();
    var iweight = $("#weight").val();
    
    console.log("prueba de pasamos a post");
    
    
    $.ajax({
         data:   { "gender"        : igenre,
                   "age"           : iage,
                   "bloodpressure" : ibloodPressure,    
                   "hypertension"  :ihasHypertensionTreatment,
                   "smoker"        : iisSmoker  ,
                   "diabetes"      : ihasdiabetes,
                   "height"        : iheight,
                   "weight"        : iweight  
                 },
        url: '/ccmheart/cvdtest.php',
        type: 'post',
        success: function(data)
        {
		   console.log("mostramos datos: " + data.heartAge);
           $("#heartAgeResult").text(data.heartAge);
            $("#calculatedRiskResult").text(data.calculatedRisk + "%");
            $("#optimalRiskResult").text(data.optimalRisk + "%");
            $("#normalRiskresult").text(data.normalRisk + "%");
		}
    
    });
    
    
});



