<?php
        //valors de formularios iniciales
        $gender = "";
        $age = "";
        $bloodpressure = "";
        $hashypertensionteatment = "";
        $issmoker = "";
        $hasdiabetes = "";
        $bodymassindex = ""; 

        $patientCalculatedRisk = 0;//Este es el riesgo del paciente
    
//factores para el hombre
        //RIESGO: 1-0.88431exp(ΣßX – 23.9388) 
        $factorAgeM = 3.11296;
               $factorsmokerM = 0.70953;        
        $factorbodymassindexM = 0.79277;
        $factordiabetesM = 0.5316;   
        $factorRiskBaseExpM = 0.88431;
        $factorMinusSumBXM = 23.9388;

//factores para la mujer         
//RIESGO: 1-0.94833exp(ΣßX – 26.0145) 
        $factorAgeF = 2.72107;        
        $factorsmokerF = 0.61868;         
        $factorbodymassindexF = 0.51125;
        $factordiabetesF = 0.77763;   
        $factorRiskBaseExpF = 0.94833;
        $factorMinusSumBXF = 26.0145;

     
        $factorSumBetaX= 0; 

//funciones para calculo de factor de riesgo: 

        function calculateFactorSumBetaX($factorAge, $factorsmoker, $factorbodymassindex, $factordiabetes, $gender,
                                         $age, $bloodpressure, $hashypertensionteatment, $issmoker, $bodymassindex, $hasdiabetes  ){
           
            $factorbloodpressureresolved = 0; // factor YA DETERMINADO SIN O CON TRATAMIENTO
            $factorbloodpressureNTM = 1.85508; // factor sin tratamiento de hipertension MASCULINO
            $factorbloodpressureTM = 1.92672; // factor con tratamiento de hipertension MASCULINO
            
            $factorbloodpressureNTF = 2.81291; // factor sin tratamiento de hipertension FEMENINO
            $factorbloodpressureTF = 2.88267; // factor con tratamiento de hipertension FEMENINO    
            
            
            if($gender =='F'){
                 if($hashypertensionteatment == 1)
                    $factorbloodpressureresolved = log($bloodpressure) *  $factorbloodpressureTF;
                 else
                    $factorbloodpressureresolved = log($bloodpressure) *  $factorbloodpressureNTF;  
            }
            else{
                 if($hashypertensionteatment == 1)
                    $factorbloodpressureresolved = log($bloodpressure) *  $factorbloodpressureTM;
                 else
                    $factorbloodpressureresolved = log($bloodpressure) * $factorbloodpressureNTM;  
            }           
            
            
        return  ( ($factorAge * log($age) ) +
                $factorbloodpressureresolved +
                ($factorsmoker * $issmoker) +
                ($factorbodymassindex * log($bodymassindex) ) +
                ($factordiabetes * $hasdiabetes) );
        } //  fin de calculateFactorSumBetaX    


        function calculateRiskFactor($factorRiskBaseExp,$factorSumBetaX, $factorMinusSumBX ){            
           return  1 - pow ($factorRiskBaseExp,  exp($factorSumBetaX  - $factorMinusSumBX ) );
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    // PROCESAMOS LA INFORMACION CUANDO LE DAMOS "CALCULAR"
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
        $gender = $_POST['gender'];
        $age =  $_POST["age"];
        $bloodpressure = $_POST["bloodpressure"];
        $hashypertensionteatment = $_POST["hypertension"];
        $issmoker = $_POST["smoker"];
        $hasdiabetes = $_POST["diabetes"];
        $bodymassindex = $_POST["bodymassindex"];

        
        //y mostramos el resultado  TODO PONERLO EN UNA VARIABLE QUE LUEGO SERA ESCRITO
        
        if($gender =='F'){
              $factorSumBetaX = calculateFactorSumBetaX($factorAgeF, $factorsmokerF, $factorbodymassindexF,    $factordiabetesF, $gender,  
                                                  $age,        $bloodpressure, $hashypertensionteatment, $issmoker, $bodymassindex,
                                                  $hasdiabetes);    
            
            $patientCalculatedRisk  =  calculateRiskFactor($factorRiskBaseExpF,$factorSumBetaX, $factorMinusSumBXF ) * 100;
            
        }else{
              $factorSumBetaX = calculateFactorSumBetaX($factorAgeM, $factorsmokerM, $factorbodymassindexM,    $factordiabetesM, $gender,  
                                                  $age,        $bloodpressure, $hashypertensionteatment, $issmoker, $bodymassindex,
                                                  $hasdiabetes);    
            
            
            $patientCalculatedRisk =  calculateRiskFactor($factorRiskBaseExpM,$factorSumBetaX, $factorMinusSumBXM ) * 100; 
        }
        
    } ?>

<html>
    <head>
        <meta name="viewport" content = "width=device-width, initial-scale=1">
        <meta http-equiv = "content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="img/4Hearts.png" sizes="16x16" />
        <link href="bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet" media="screen">
         <link href="css/main.css" rel="stylesheet">
    </head>
<body>
    <!-- LOGO Y OTRAS COSAS  -->
    <header>
       <nav class="navbar navbar-default header-page">
         <div class="container-fluid">
             <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Brand" src="img/LogoCCM.png">
                </a>
            </div>
             <div >
                 <button type="button" class="btn btn-default btn-calcular">Hacer cita</button>
             </div>
        </div>
      </nav>
    </header>
    
    
    <!-- MAIN CONTAINER -->
<div class="container-fluid">
  <div class="row no-gutters">
     <!-- PANEL IZQUIERDO-->        
    <div class="col-8">
            <div class="sub-header">
             Enfermedad Cardiovascular (Riesgo a 10 años)
            </div> 
 
            
        <div class="form-container">
        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <span>
            <label class="form-question">¿Cuál es su genero?</label><br>
            <input type="radio"  id="gender" name="gender" value="F" class="radio-button"> <label for="gender">Mujer </label>
            <input type="radio"  id="gender" name="gender" value="M" checked><label for="gender">Hombre</label><br>
            </span>   
            
            <br/>
            <div>
            <label class="form-question">¿Cuál es su edad?</label><br>
            <input type="input" name="age" class="form-control input-textfield" value = "30">            
            </div>
            
            <br/>
            <span>
                <label class="form-question"> Presión sangínia sistólica</label> <br>
            <input type="input" name="bloodpressure"  placeholder="mmHg" class="form-control input-textfield" value="125">            
            </span>
            
            <br/>
            <span>
                <label class="form-question">¿Lleva algún tratamiento para la hipertensión?</label><br>
            <input type="radio" name="hypertension" value="1" checked>Si
            <input type="radio" name="hypertension" value="0">No<br>
            </span>    
            
            <br/>
            <span>
                <label class="form-question">¿Usted fuma actualmente?:</label><br>
            <input type="radio" name="smoker" value="1" checked>Si
            <input type="radio" name="smoker" value="0">No<br>
            </span>    
            
            <br/>
            <span>
                <label class="form-question">¿Usted padece de diabetes?</label><br>
            <input type="radio" name="diabetes" value="1" checked>Si
            <input type="radio" name="diabetes" value="0">No<br>
            </span>    
            
            <br/>
            <span>
                <label class="form-question">Índice de masa corporal</label><br>
            <input type="text" id = "bodymassindex" name="bodymassindex" class="form-control input-textfield" value="22.5"><br>
            </span> 
            
            <br/>
            <input type="submit" value="Calcular" class="btn-calcular">
            </div><!--FIN DE FORM-->
        </form>
    </div>
        
    <!-- PANEL DERECHO -->
        <div class="col-4">
            <img src="img/RightBanner.jpg" class="img-fluid imgrb">
        </div>
  </div> <!-- fin de div row -->    
    
    <!-- DIV DE RESULTADOS Y TELEFONO DE CONTACTO-->
    <div class="row">
        <div class="col-8 div-results">
            <label> Tu corazon / edad vascular: </label><br>
            <div class="row">    
                <div class="col-10">
                <div class="progress">
                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" 
                            aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                        <div class="progress-bar-title">Tu riesgo</div>                
                </div>
                </div>
                <div class="col-2">
                <label class="progress-label"><?php echo round($patientCalculatedRisk,2) ."%"; ?></label>
                </div>
            </div>
            
            
            <div class="row">    
                <div class="col-10">
                <div class="progress">
                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" 
                            aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                        <div class="progress-bar-title">Normal</div>                
                </div>
                </div>
                <div class="col-2">
                <label class="progress-label">0%</label>
                </div>
            </div>
            
            
            <div class="row">    
                <div class="col-10">
                <div class="progress">
                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" 
                            aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                        <div class="progress-bar-title">Optimo</div>                
                </div>
                </div>
                <div class="col-2">
                <label class="progress-label">0%</label>
                </div>
            </div>
            
        </div>
        <!-- direccion -->
        <div class="col-4 div-info">
            <img src="img/4Hearts.png"><label class="label-info-title">Sobre Centro Cardiometabólico</label><br>
            <p class="label-info-content">Centro especializado en la prevención, detección y tratamiento integral de las enfermedades
               cardíacas, endócrinas y metabólicas. </p><br><br>
            <img src="img/if_Facebook.svg" class="fb-img">    
            <img src="img/if_globe.svg" class="globe-img">
            <label class="phone-contact">2213-9400 / 7862-6108</label>
        </div>
    </div>
    
</div><!-- fin de main container        
    
    <!-- SeCCION DE SCRIPTS Y JS -->
    <script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    
</body>
</html>