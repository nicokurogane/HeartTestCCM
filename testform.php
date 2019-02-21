<?php
session_start();

?>
<html>
    <head>
        <meta name="viewport" content = "width=device-width, initial-scale=1">
        <meta http-equiv = "content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="img/4Hearts.png" sizes="16x16" />
        <link href="bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="https://fonts.googleapis.com/css?family=Nunito:600,700,700i,800,800i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
<body>
    
<div class="container">
    
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recomendaciones CCM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
          <div class="mt-2 mb-4">
               <img src="img/CCMHeartblue.svg" height="60px" width="60px">
          </div>
          Tu riesgo es de un <label id="showPatientRisk" class="form-question">10%</label>, lo consideramos que esta dentro de 
          <label id="showPatientWarning" class="form-question">RIESGO LEVE</label>, sin embargo queremos ofrecerte un documento con recomendaciones utiles para mejorar tu estado.
      </div>
      <div class="modal-footer">
        <a href="index.php" class="btn btn-secondary btn-reset">Reiniciar Prueba</a>
        <a id="pdflink" href="#" class="btn btn-descargar" target=_new>Descargar</a>
      </div>
    </div>
  </div>
</div><!-- final de modal -->
    
</div> 
    <!-- LOGO Y OTRAS COSAS  -->
    <header>
       <nav class="navbar navbar-default header-page">
         <div class="container-fluid">
             <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Brand" src="img/CCMLogoLogin.svg" class="brand"  width="170px" height="45px">
                </a>
            </div>
             
        </div>
      </nav>
    </header>
    
    

  <div class="row no-gutters">
    <div class="col-12 sub-header">
             Calcula tu riesgo cardiovascular 
    </div> 
  </div>    
    
    
  <div class="row  no-gutters">
     <!-- PANEL IZQUIERDO-->        
    <div class="col-md-8">    
        <div class="form-container">
       <form  id="submitForm" method="post">
            <input type="hidden" value="<?php echo $_SESSION['userId'];?>" id='userid'>
            <input type="hidden" value="<?php echo $_SESSION['userEmail'];?>" id='useremail'>
           
           <div class="row">
               <div class="col radioParent">
                <label class="form-question">¿Cuál es su género?</label><br>
                
                <div class="custom-control custom-radio custom-control-inline">
                       <input type="radio" class="custom-control-input" id="rgender1" name="gender" value="F">
                       <label class="custom-control-label" for="rgender1">Mujer</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="rgender2" name="gender" value="M">
                        <label class="custom-control-label" for="rgender2">Hombre</label>
                </div>      
                <br/>
                <span id="errorRadioGenero"></span>
              </div>
           </div>   

           <div class="row">
                <div class="col-sm-6">
                <label class="form-question">¿Cuál es su edad?</label><br>
                <input type="input" id="age" name="age" class="form-control input-textfield " placeholder="Escribe tu edad aquí">                           </div>     
                <div class="col-sm-6 second-col">
                   <label class="form-question">Estatura(en centimetros):</label><br>
                   <input type="text" id ="height" name="height" class="form-control input-textfield" 
                      placeholder="Escribe tu respuesta aquí">
                </div> 
           </div>
           
           <div class="row">
                <div class="col-sm-6">
                    <label class="form-question">Peso (en libras):</label><br>
                    <input type="text" id = "weight" name="weight" class="form-control input-textfield" 
                      placeholder="Escribe tu respuesta aquí">
                </div> 
                <div class="col-sm-6 second-col">
                   <div>
                     <label class="form-question"> Presión sanguinea sistólica</label> <br>
                     <input type="input" id="bloodpressure" name="bloodpressure"  placeholder="Escribe tu respuesta aquí"
                       class="form-control input-textfield">          
                   </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm btn-sbp-tootlip"  data-toggle="popover" data-placement="right"  
                                data-trigger="click hover focus"  
                                data-content="“El dato a ingresar son los primeros digitos que obtengas de la toma de presión, por ejemplo:
                                              de lo valores (120/80), ingresa 120”">¿Qué es esto?</button>
                    </div>
                </div>
           </div>

            <div class="row">                
                <div class="col radioParent">
                  <label class="form-question">¿Lleva tratamientos para hipertensión?</label><br>
                    <div class="custom-control custom-radio custom-control-inline">
                       <input type="radio" class="custom-control-input" id="rhypertension1" name="hypertension" value="1">
                       <label class="custom-control-label" for="rhypertension1">Si</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="rhypertension2" name="hypertension" value="0">
                        <label class="custom-control-label" for="rhypertension2">No</label>
                    </div>   
                    <br/>
                    <span id="errorRadiohypertension"></span>  
                </div> 
            </div>    
            
            <div class="row radio-row">
                <div class="col radioParent">
                <label class="form-question">¿Usted fuma actualmente?:</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                       <input type="radio" class="custom-control-input" id="rsmoker1" name="smoker" value="1">
                       <label class="custom-control-label" for="rsmoker1">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="rsmoker2" name="smoker" value="0">
                        <label class="custom-control-label" for="rsmoker2">No</label>
                </div>      
                <br/>
                <span id="errorRadioSmoker"></span>  
                </div>
            </div>    
            <div class="row radio-row">
                <div class="col  radioParent">
                <label class="form-question">¿Usted padece de diabetes?</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                       <input type="radio" class="custom-control-input" id="rdiabetes1" name="diabetes" value="1">
                       <label class="custom-control-label" for="rdiabetes1">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="rdiabetes2" name="diabetes" value="0">
                        <label class="custom-control-label" for="rdiabetes2">No</label>
                </div>      
                <br/>
                <span id="errorRadioDiabetes"></span>  
                </div>
            </div>      

           
           <div class="row no-gutters btn-calcular-container">
               <div class="col-sm-6 col-md-5">
                 <input type="submit" value="Calcular resultado" class="btn-calcular font-weight-bold" id="sendDataTest">   
               </div>
               <div class="col-sm-6 col-md-2 second-col">
                    <a href="index.php" class="btn btn-secondary btn-reset-test-form" data-toggle="popover" data-placement="top"  
                                data-trigger="click hover focus"  
                                data-content="Si presiona este botón volverá a la página inicial
                                 de nombre y correo para realizar nuevamente la evaluación.">Reiniciar Prueba</a>
               </div>
            </div>
           
           
           
        </form>
      </div><!--FIN DE FORM-->

        
    </div> 
      <!-- PANEL DERECHO-->
       <div class="col-md-4  div-info2" id="divTestResults">
           <div class="container div-results">       
               <span class="risk-title">RESULTADOS</span>
                <div class="div-results-title">    
                    <label > Tu corazón / edad vascular: </label>
                    <!-- <label> En base a los datos, la edad cronológica de tu corazón es: </label> -->
                    <label  id="heartAgeResult" class="patient-result-number">0</label>
               </div>
               <div class="risk-10-subtitle-spacing">    
                    <label>Riesgo a 10 años:</label>
               </div>
 
               <div class="patient-risk-divisor">
                    <svg width="27" height="26.7" class="patient-risk patient-risk-spacing">
                        <rect width="27" height="26" />
                    </svg>
                    <span>Tu riesgo:</span><label id="calculatedRiskResult" class="patient-result-number"> 0%</label>
               </div>
               <div class="patient-risk-divisor">
                    <svg width="27" height="26.7" class="patient-risk2 patient-risk-spacing">
                        <rect width="27" height="26" />
                    </svg>
                    <span>Normal:&nbsp;&nbsp;</span>  <label id = "normalRiskresult" class="patient-result-number"> 0% </label> 
               </div>
               <div class="patient-risk-divisor">
                    <svg width="27" height="26.7" class="patient-risk3 patient-risk-spacing">
                        <rect width="27" height="26" />
                    </svg>
                    <span>Óptimo:&nbsp;&nbsp;</span> <label id = "optimalRiskResult" class="patient-result-number"> 0%</label>
               </div>
           </div>
           <hr class="line-divisor">
           <div class="container">
               <div class="row">
                   <div class="col">
                      <span class="risk-title">RANGOS DE RIESGOS</span>
                   </div>
               </div>
               <div class="row risk-label-row">
                   <div class="col-1 pl-1 pr-2  pl-md-3 pr-md-3 "> <img src="img/circle-with-check-symbol.svg" height="26px" width="26px"> </div> 
                   <div class="col-11"><label class="risk-label-text-span">Riesgo LEVE: puntuaciones entre 0 a 10%</label></div>
               </div>
               <div class="row risk-label-row">
                   <div class="col-1 pl-1 pr-2  pl-md-3 pr-md-3"> <img src="img/round-error-symbol.svg" height="26px" width="26px"> </div> 
                   <div class="col-11"><label class="risk-label-text-span">Riesgo MODERADO: puntuaciones entre 10 a 20%</label></div>                   
               </div>
               <div class="row risk-label-row">
                   <div class="col-1 pl-1 pr-2  pl-md-3 pr-md-3"> <img src="img/cancel-button.svg" height="26px" width="26px"> </div> 
                   <div class="col-11"><label  class="risk-label-text-span">Riesgo ALTO: puntuaciones entre 20 a 30%</label></div>                   
               </div>
           </div>
           <hr class="line-divisor">
           <div class="container">
               <div class="row no-gutters explanation-paragraph">
                   <div class="col">
                       <p>Con esta prueba puedes estimar la probabilidad de desarrollar, en un plazo de 10 años, una angina inestable, 
                           un infarto agudo de miocardio o muerte de origen cardiovascular y obtener un estimado de la edad de tu corazón;
                           además recibirás recomendaciones acorde a tu nivel de riesgo.
                       </p>
                   </div>
               </div>
               <div class="row">
                   <div class="col">
                       <button type="button" id="btnRecomendation" class="btn btn-recomendaciones" 
                            data-toggle="modal" data-target="#myModal" disabled>
                        Ver recomendaciones</button>
                   </div>
               </div>
               <div class="row">
                   <div class="col">
                        <a href="http://www.centrocardiometabolico.com/haz-tu-cita"  target="_blank"
                           class="btn btn-hacer-citas ">Hacer cita</a>
                   </div>                
               </div>
           </div>
           
        </div>


    </div>    
    <!-- DIV DE  TELEFONO DE CONTACTO-->
    <div class="row no-gutters" >

        <!-- direccion -->
        <div class="col-12 col-md-9 div-info">
            <div class="container-fluid info-container">
            <img src="img/4Hearts.svg" height="43px" width="43px"><label class="label-info-title">Sobre Centro Cardiometabólico</label><br>
            <p class="label-info-content">Centro especializado en la prevención, detección y tratamiento integral de las enfermedades
               cardíacas, endócrinas y metabólicas. </p><br>
            <a href="https://www.facebook.com/CCMELSALVADOR/"><img src="img/if_Facebook.svg" class="fb-img"> </a>
            <a href="http://www.centrocardiometabolico.com/"> <img src="img/if_globe.svg" class="globe-img"></a>
            <label class="phone-contact">2213-9400 / 7862-6108</label>
                </div>
        </div>
        <div class="col-md-3 d-none d-md-block div-info">
           <img src="img/ccmmarkwater.svg" class="d-none d-md-block" height="198px" width="198px" style="object-fit: contain;"> 
        </div>
    </div>
<!-- fin de main container  -->
    
    
    <!-- SeCCION JS -->
    
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/form-animation.js" type="text/javascript"></script>
    <script src="js/data-processor.js" type="text/javascript"></script>
    <script src="js/jquery.mask-1.14.15.min.js" type="text/javascript"></script>
    <script src="js/jquery-validation-1.17.0/jquery.validate.min.js"></script>
    <script src="js/mask-and-validation-test.js" type="text/javascript"></script>
    <script src="bootstrap-4.1.3/js/popper.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
    <script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
    
</body>
</html>