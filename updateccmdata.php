<?php 

   require_once $_SERVER['DOCUMENT_ROOT']."/ccmheart/ccm_infodb.php";

    $host     = getServidor();
    $user     = getUsuario();
    $password = getContrasena();
    $database = getBasedatos();


    $dblink = mysqli_connect($host, $user, $password, $database);
    if(mysqli_connect_errno()) {
      echo "No se pudo conectar con la base de datos: Error: ".mysqli_connect_error();
        echo "<br/>";
     exit();
    }

?>
<hmtl>
    <head>
        <meta name="viewport" content = "width=device-width, initial-scale=1">
        <meta http-equiv = "content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    </head>
<body>   


<?php
    //primero extraemos los datos


$sqlquery = "SELECT * FROM ccm_cvdtestanswer_data LIMIT 0,100";
echo $sqlquery."<br/>";

if ($result = mysqli_query($dblink, $sqlquery)) {

    /* fetch associative array */
    
    echo "cuenta de rows: ". $rowcount=mysqli_num_rows($result)."<br/>";
    

    $contador = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        echo  "<span id= \"answerid".$contador."\"> ".$row["ccm_answerid"]."</span> ".
            "<span id= \"gender".$contador."\">".$row["ccm_testanswergender"]."</span> ".
            "<span id= \"age".$contador."\">".$row["ccm_testanswerage"]."</span> ".
            "<span id= \"sbp".$contador."\">".$row["ccm_testanswerSBP"]."</span> ".
            "<span id= \"hypertension".$contador."\">".$row["ccm_testanswerhypertension"]."</span> ".
            "<span id= \"smoker".$contador."\">".$row["ccm_testanswersmoker"]."</span>  ".
            "<span id= \"diabetes".$contador."\">".$row["ccm_testanswerdiabetes"]."</span> ".
            "<span id= \"height".$contador."\">".$row["ccm_testanswerheight"]."</span>  ".
            "<span id= \"weight".$contador."\">".$row["ccm_testanswerweight"]."</span>  ";
        
        echo "   <input type=\"button\" id=".$contador." class=\"senddata\" value=\"Generar data\" />";
        
        echo "<br/><br/>";        
        $contador +=1;
    }
    


  mysqli_free_result($result);
}
echo "fin de script";
mysqli_close($dblink);

?>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script>
        $( document ).ready(function() {
            
            $(".senddata").click(function(event){
                var idClicked = event.target.id;
                
                var answerId = $("#answerid"+idClicked).text(); //asi extraemos los id
                var gender = $("#gender"+idClicked).text(); //asi extraemos los id
                var age = $("#age"+idClicked).text(); //asi extraemos los id
                var sbp = $("#sbp"+idClicked).text(); //asi extraemos los id
                var hypertension = $("#hypertension"+idClicked).text(); //asi extraemos los id
                var smoker = $("#smoker"+idClicked).text(); //asi extraemos los id
                var diabetes = $("#diabetes"+idClicked).text(); //asi extraemos los id
                var height = $("#height"+idClicked).text(); //asi extraemos los id
                var weight = $("#weight"+idClicked).text(); //asi extraemos los id
                
     //           alert("ID CLICKEADO: " + answerId+" "+ gender+" "+age+" "+sbp+" "+hypertension+" "+smoker+" "+diabetes+" "+height+" "+weight);
          
      $.ajax({
         data:   { 
                   "answerId"      : answerId,
                   "gender"        : gender,
                   "age"           : age,
                   "bloodpressure" : sbp,    
                   "hypertension"  : hypertension,
                   "smoker"        : smoker  ,
                   "diabetes"      : diabetes,
                   "height"        : height,
                   "weight"        : weight  
                 },
        url: '/ccmheart/cvdtest2.php',
        type: 'post',
          success: function(data)
            {    
                alert(data);
		    }            
                });            
           
                   });
        });
    </script>
</body> 
</hmtl>
    
    
    
    
    