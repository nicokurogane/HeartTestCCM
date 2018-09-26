

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
  <div class="row no-gutters">
     <!-- PANEL IZQUIERDO-->        
    <div class="col-8">
            <div class="sub-header">
             Enfermedad Cardiovascular (Riesgo a 10 años)
            </div> 
 
            
        <div class="form-container">
       <form  id="submitForm" method="post">
            <span>
            <label class="form-question">¿Cuál es su genero?</label><br>
            <input type="radio"  id="gender" name="gender" value="F" class="radio-button"> <label for="gender">Mujer </label>
            <input type="radio"  id="gender" name="gender" value="M"><label for="gender">Hombre</label><br>
            </span>   
            
            <br/>
            <div>
            <label class="form-question">¿Cuál es su edad?</label><br>
            <input type="input" id="age" name="age" class="form-control input-textfield" placeholder="Escribe tu edad aquí">            
            </div>
            
            <br/>
            <span>
                <label class="form-question"> Presión sangínia sistólica</label> <br>
            <input type="input" id="bloodpressure" name="bloodpressure"  placeholder="Escribe tu respuesta aquí"
                   class="form-control input-textfield">            
            </span>
            
            <br/>
            <span>
                <label class="form-question">¿Lleva algún tratamiento para la hipertensión?</label><br>
            <input type="radio" name="hypertension" value="1">Si
            <input type="radio" name="hypertension" value="0">No<br>
            </span>    
            
            <br/>
            <span>
                <label class="form-question">¿Usted fuma actualmente?:</label><br>
            <input type="radio" name="smoker" value="1">Si
            <input type="radio" name="smoker" value="0">No<br>
            </span>    
            
            <br/>
            <span>
                <label class="form-question">¿Usted padece de diabetes?</label><br>
            <input type="radio" name="diabetes" value="1" >Si
            <input type="radio" name="diabetes" value="0" >No<br>
            </span>    
            
<!--            
            <br/>
            <span>
                <label class="form-question">Índice de masa corporal</label><br>
            <input type="text" id = "bodymassindex" name="bodymassindex" class="form-control input-textfield" ><br>
            </span> 
-->           
           <br/>
            <span>
                <label class="form-question">Estatura(en centimetros):</label><br>
            <input type="text" id ="height" name="height" class="form-control input-textfield" placeholder="Escribe tu respuesta aquí"><br>
            </span> 
           
           
            <span>
                <label class="form-question">Peso (en libras):</label><br>
            <input type="text" id = "weight" name="weight" class="form-control input-textfield" placeholder="Escribe tu respuesta aquí">
             <br>
            </span> 
            

            <input type="submit" value="Calcular" class="btn-calcular" id="sendDataTest">
            </div><!--FIN DE FORM-->
        </form>
    </div>


    </div>    <!--finde div clo-8-->
        <!-- PANEL DERECHO -->  
    <div class="col-4">        
<!--
            <img src="img/RightBanner.jpg" class="img-fluid"/>
-->        
    </div>
     </div>    
    <!-- DIV DE RESULTADOS Y TELEFONO DE CONTACTO-->
    <div class="row"  id="divTestResults">
       <div class="col-7 div-results">
        <div class="container">
        <label> Tu corazon / edad vascular:&nbsp; </label>
            <label id="heartAgeResult">0</label><br>
            <div class="row">    
                <div class="col-10">
                <div class="progress">
                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" 
                            aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                        <div class="progress-bar-title">Tu riesgo</div>                
                </div>
                </div>
                <div class="col-2">
                <label id="calculatedRiskResult" class="progress-label"> 0%</label>
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
                <label id = "normalRiskresult" class="progress-label"> 0% </label>
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
                <label id = "optimalRiskResult" class="progress-label"> 0%</label>
                </div>
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
<!-- fin de main container  -->

    
    <!-- SeCCION DE SCRIPTS Y JS -->
    <script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/form-animation.js" type="text/javascript"></script>
    <script src="js/data-processor.js" type="text/javascript"></script>
    
</body>
</html>