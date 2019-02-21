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
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:600,700,700i,800,800i" rel="stylesheet">
    <link href="css/conditions.css" rel="stylesheet">
</head>   
<body>
    
    <header>
       <nav class="navbar navbar-default header-page">
         <div class="container-fluid">
             <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Brand" src="img/CCMLogoLogin.svg" class="brand" height="45.3px" width="170.3px">
                </a>
            </div>
        </div>
      </nav>
    </header>

    <div class="row no-gutters margin-nav-bar">
        <div class="col">
           <div class="card condition-box mx-auto " >
               <div class="mx-auto condition-label-title ">
               <span class="card-title">Terminos y condiciones</span>   
               </div>
            <div class="card-body">
            
            <p class="card-text">1. Queremos felicitarte por tomar la decisión de evaluar tu riesgo a padecer una enfermedad cardiovascular, con esta prueba sabrás tu probabilidad a 10 años de padecer una enfermedad del corazón.<br/><br/>

2. Esta herramienta te será útil si tu edad esta entre los 30 y 74 años<br/><br/>

3. Cada uno de los parámetros evaluados suman o restan riesgo a tu puntaje final, es imperativo contestar todas y cada una de las preguntas de forma fiel.<br/><br/>

4. Esta evaluación no pretende sustituir el diagnóstico médico, le recomendamos consultar los datos obtenidos con su médico de cabecera.</p>
 
                
            <div class="row">
                <div class="col-sm-6 col-md-9 checkbox-container mt-md-3">
                    
                    <label class="checkbox-label"><input id="conditionCheckbox"type="checkbox" value="">
                        Acepto terminos y condiciones</label>
               
                </div>
                <div class="col-sm-6 col-md-3 text-center accept-btn-container mt-md-3">
                    <div class="accept-btn-container">
                     <button id="myBtn" class="btn btn-primary btn-accept-ccm font-weight-bold" disabled>Continuar</button>
                        </div>
                </div>
            </div> <!-- FIN DE LA DIVISION DE CHECKBOX Y BUTTON -->   
            </div>
            </div>
            
        </div>
    </div>
    
    
    <!-- DIV DE  TELEFONO DE CONTACTO-->
    <div class="row no-gutters" >
        <!-- direccion -->
        <div class="col div-info">
            <div class="container-fluid info-container">
            <img src="img/4Hearts.svg" height="43px" width="43px"><label class="label-info-title">Sobre Centro Cardiometabólico</label><br>
            <p class="label-info-content">Centro especializado en la prevención, detección y tratamiento integral de las enfermedades
               cardíacas, endócrinas y metabólicas. </p><br>
            <a href="https://www.facebook.com/CCMELSALVADOR/"><img src="img/if_Facebook.svg" class="fb-img"> </a>
            <a href="http://www.centrocardiometabolico.com/"> <img src="img/if_globe.svg" class="globe-img"></a>
            <label class="phone-contact">2213-9400 / 7862-6108</label>
                </div>
        </div>
    </div>
    
    <script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script>
    var btn = document.getElementById('myBtn');
      btn.addEventListener('click', function() {
      document.location.href = 'testform.php';
    });
  </script>
    <script>$(function() {
    $('#conditionCheckbox').click(function() {
        if ($(this).is(':checked')) {
            $('#myBtn').removeAttr('disabled');            
        } else {
            $('#myBtn').attr('disabled', 'disabled');
        }
    });
});
    </script>
</body>
</html>