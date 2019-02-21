<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/ccmheart/ccm_infodb.php";


   if ($_SERVER["REQUEST_METHOD"] == "POST"){    
   
    $host     = getServidor();
    $user     = getUsuario();
    $password = getContrasena();
    $database = getBasedatos();

       
    $dblink = mysqli_connect($host, $user, $password, $database);
    if(mysqli_connect_errno()) {
     echo "No se pudo conectar con la base de datos: Error: ".mysqli_connect_error();
     exit();
    }

    $nombreUsuario = $_POST['patientname'];
    $correoUsuario = $_POST['patientemail'];

     //verificamos que el usuario exista       
    //----------------------------------------------------------------------------------------------------------------------------------
       $sqlquery = "SELECT ccm_userid FROM ccm_user WHERE idccm_email = '".$correoUsuario."'";
       
       if ($result = mysqli_query($dblink, $sqlquery)) {
           $rowcount=mysqli_num_rows($result);
           
           if($rowcount == 1){ //hay un usuario ya creado
                 session_start();
                 while ($row = mysqli_fetch_row($result)) {
                        $_SESSION['userId'] =  $row[0];
                        $_SESSION['userEmail'] =  $correoUsuario;
                }
                 header("Location: conditions.php");
                 exit();
               
           }else if($rowcount == 0 ){ // lo mandamos a crear
               
               $sqlinsert = "INSERT INTO  ccm_user (ccm_userid, idccm_user_name, idccm_email) VALUES ('0', '".$nombreUsuario."', '".$correoUsuario."')";
              if ($dblink->query($sqlinsert) === TRUE) {
               //   echo "New record created successfully";            
                  //hacemos select nuevamente
                  session_start();  
                  if ($result2 = mysqli_query($dblink, $sqlquery)) {
                       while ($row = mysqli_fetch_row($result2)) {
                        $_SESSION['userId'] =  $row[0];
                        $_SESSION['userEmail'] =  $correoUsuario;
                       }
                  }
                  mysqli_free_result($result2);
                  mysqli_free_result($result);
                  mysqli_close($dblink);
                  header("Location: conditions.php");
                  
              } else {
                  echo "No se pudo crear el ususario: " . $sql . "<br>" . $dblink->error;
              }
          }
       }
        mysqli_free_result($result);
    mysqli_close($dblink);
        
    }// fin de verificacion de post 
?>
<html>
<head>
    <meta name="viewport" content = "width=device-width, initial-scale=1">
    <meta http-equiv = "content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito:600,700,700i,800,800i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/4Hearts.png" sizes="16x16" />
    <link href="bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    
    <link href="css/login.css" rel="stylesheet">
</head>    
<body>
    <header>
       <nav class="navbar navbar-default header-page">
         <div class="container-fluid">
             <div class="navbar-header">
                <a class="navbar-brand mx-auto" href="#" >
                    <img alt="Brand" src="img/CCMLogoLogin.svg" class="brand" height="45.3px" width="170.3px">
                </a>
            </div>
        </div>
      </nav>
    </header>
    
   
<div class="row no-gutters form-input-container">    
    <div class="col-lg-4  col-md-6  offset-md-2 offset-lg-2 offset-xl-2"  style="object-fit: contain;">
        <div class="row mx-auto form-input-data">
          <div class="col container-fluid">                  
              <div class="row justify-content-center">                
                  <span class="title-login">Calcula tu riesgo cardiovascular</span>            
               </div>
              <div class="row no-gutters">
                <div class="col">
                    <div class="subtitle-login">
                         
                    <p >¿Te gustaría conocer tu riesgo de tener una enfermedad cardiovascular? Con nuestra calculadora de riesgo puedes estimar la probabilidad de desarrollar una enfermedad, en un plazo de 10 años.
                        </p>
                    </div>
                </div>
              </div>
              <div class="row">
                  <div class="col">
                      <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-row">
                        <div class="col">
                        <input type="input" id="patientname" name="patientname" class="form-control input-textfield "
                               placeholder="Nombre Completo" >  
                        </div>
                        </div>
        
                        <div class="form-row" style="margin-top:15px;">
                        <div class="col">
                        <input type="input" id="patientemail" name="patientemail" class="form-control input-textfield"
                               placeholder="Correo Electrónico"  >  
                        </div>
                        </div>
                
                         <div class="form-row" style="margin-top:15px;">
                        <div class="col">
                        <input type="submit" value="Empezar" class=" form-control btn-calcular w-100" id="sendDataTest">
                        </div>
                        </div>
                          </form>
                </div> 

              </div>

          </div>

        </div><!-- fin de form -->   
    </div>

     <div class="col-lg-3 col-md-6 offset-lg-3   offset-xl-1  login-img-container">
       <img src="img/monitor.svg" class="d-none d-lg-block d-xl-block" width="400px" height="389px" style="object-fit: contain;">
     </div>
            
    </div>
    <!-- direccion -->
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


    <!----------------------------------------- SECCION DE SCRIPTS Y JS -------------------------------------------------------->
    
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/jquery.mask-1.14.15.min.js" type="text/javascript"></script>
    <script src="js/mask-and-validation.js" type="text/javascript"></script>
    <script src="js/jquery-validation-1.17.0/jquery.validate.min.js"></script>
    <script src="bootstrap-4.1.3/js/bootstrap.min.js"></script>
    
</body>
</html>