<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/ccmheart/ccm_infodb.php";
 
  // PROCESAMOS LA INFORMACION CUANDO LE DAMOS "CALCULAR"
  if ($_SERVER["REQUEST_METHOD"] != "POST"){
    exit();        
  }

    $host     = getServidor();
    $user     = getUsuario();
    $password = getContrasena();
    $database = getBasedatos();

    $dblink = mysqli_connect($host, $user, $password, $database);
    if(mysqli_connect_errno()) {
    // echo "No se pudo conectar con la base de datos: Error: ".mysqli_connect_error();
     exit();
    }

 
  $gender = $_POST['gender'];
  $age =  $_POST["age"];
  $bloodpressure = $_POST["bloodpressure"];
  $hashypertensionteatment = $_POST["hypertension"];
  $issmoker = $_POST["smoker"];
  $hasdiabetes = $_POST["diabetes"];        
  $height = $_POST["height"];
  $weight = $_POST["weight"];
  $userid = $_POST['userid'];    

$res = true;

  if(  $gender == null ||
  $age == null ||
  $bloodpressure == null ||
  $hashypertensionteatment == null ||
  $issmoker == null ||
  $hasdiabetes == null ||
  $height == null ||
  $weight == null ||
  $userid == null){
      
    $res = false;  
      
  }else{

  $fechainsert = date('Y-m-d H:i:s');  
      
  $sql = "INSERT INTO ccm_cvdtestanswer ( ccm_answerid ,  ccm_testanswergender ,  ccm_testanswerage ,  ccm_testanswerSBP ,  ccm_testanswerhypertension ,  ccm_testanswersmoker ,  ccm_testanswerdiabetes ,  ccm_testanswerheight ,  ccm_testanswerweight ,  ccm_testanswerdate ,  ccm_user_ccm_userid ) VALUES ('0', '". $gender."','".$age."', '".$bloodpressure."', '".$hashypertensionteatment."', '".$issmoker."', '".$hasdiabetes."', '".$height."', '".$weight."', '".$fechainsert."','".$userid ."')";

      if ($dblink->query($sql) === TRUE) {
        $res = true;  
//echo "New record created successfully";
      } else {
       // echo "Error: " . $sql . "<br>" . $dblink$->error;
        $res = false;
      }$dblink->close();                                           
      
  } 
                                       
    if($res){
       echo "Registro creado exitosamente";
    }else
       echo "Ocurrio un error, intentelo mas tarde";   
  
?>