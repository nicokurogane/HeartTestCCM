<?php
    
       require_once $_SERVER['DOCUMENT_ROOT']."/ccmheart/ccm_infodb.php";

    $host     = getServidor();
    $user     = getUsuario();
    $password = getContrasena();
    $database = getBasedatos();


    /*
        ESTE SCRIPT ES EL QUE PROCESA LA INFORMACI'ON DEL USUARIO PARA QUE SE PUEDA MOSTRAR 
        EL RESULTADO DE EDAD CARDIACA Y FACTOR DE RIESGO. 
        
        AL FINAL DEL PROCESAMIENTO, SE ENCARGA DE ENVIAR UN JSON CON LAS RESPUESTAS
    */

        // PROCESAMOS LA INFORMACION CUANDO LE DAMOS "CALCULAR"
        if ($_SERVER["REQUEST_METHOD"] != "POST"){
            exit;        
        }

        //valors de formularios iniciales
        $gender = "";
        $age = "";
        $bloodpressure = "";
        $hashypertensionteatment = "";
        $issmoker = "";
        $hasdiabetes = "";
        // cambio: se pide ahora altura y peso y de ahi se saca el indice de masa corporal

        $height = "";
        $weight = "";
        $bodymassindex = ""; 

        $patientCalculatedRisk = 0;//Este es el riesgo del paciente
        $patientCalculatedHeartAge = 0; // Este es la edad del corazon del paciente a mostrar

        $patientCalculatedOptimalRisk = 0;
        $patientCalculatedNormalRisk = 0;
    
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


        //Funcion para calcular la edad del corazon 
        // LOS FACTORES QUE UTILIZA AQUI SON LOS FACTORES DE ALGUIEN SIN TRATAMIENTO
        function calculateHeartAge( $gender,$bloodpressure,  $issmoker, $bodymassindex,$hasdiabetes,
                                     $factorAge, $factorbloodpressure, $factorsmoker, $factorbodymassindex, $factordiabetes,  $calculatedRiskFactor ){
            $CONST = 0;
            $CONST_LOG_CONSTI_DENO =0;
            $EXPO =  1/$factorAge;
            
            
            if($gender =='M'){
                $CONST = 23.9388;
                $CONST_LOG_CONSTI_DENO =  0.88431;
                
            }else{
               $CONST = 26.0145;
               $CONST_LOG_CONSTI_DENO = 0.94833;  
            }
                
           
          /*  $PRE_CONSTI_NUM_NUM =(  log($bloodpressure) * $factorbloodpressure ) + 
                                 (  $issmoker * $factorsmoker ) +
                                 ( log($bodymassindex) * $factorbodymassindex ) + 
                                 ( $hasdiabetes    * $factordiabetes );*/
             // cambio 1: cambiar factores de somker y diabetico a cero
            //  cambio 2: bloodpressure a constante de 125 y body mass index constante de  22.5
            $PRE_CONSTI_NUM_NUM =(  log(125) * $factorbloodpressure ) + 
                                 (  0 * $factorsmoker ) +
                                 ( log(22.5) * $factorbodymassindex ) + 
                                 ( 0    * $factordiabetes );
            
            $PRE_CONSTI_NUM_NUM = $PRE_CONSTI_NUM_NUM - $CONST;
            $PRE_CONSTI_NUM_NUM = (-1*$PRE_CONSTI_NUM_NUM)/$factorAge;
            $CONSTI_NUM =  exp($PRE_CONSTI_NUM_NUM );            
            // echo "CONSTI_NUM: ". $CONSTI_NUM;
            
            $CONSTI_DENO =  pow(  -1*(log($CONST_LOG_CONSTI_DENO)), (1/$factorAge)  );
            //echo "<br/>CONSTI_DENO: ".$CONSTI_DENO;
            
            $CONSTI_VALUE = $CONSTI_NUM/$CONSTI_DENO;
            //    echo "<br/>CONSTI: ". $CONSTI_VALUE; 
            //Fin de calculo DEL MULTIPLICANDO 1
            
            // OK echo " EXPO: ". $EXPO;
            
            //---------------------------------------------------------------------------
            $TERM  = pow(  -1*log(1-$calculatedRiskFactor )  ,  $EXPO ) ; 
            //Fin de calculo de MULTIPLICANDO 2
            //OK echo " TERM: ". $TERM;
            
            //$HEART_AGE = $TERM * $CONSTI_VALUE;
            return $TERM * $CONSTI_VALUE;
        }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Funcion para calcular el riesgo optimo dependiendo de la edad del paciente
        function calculateOptimalRisk($age, $factorAge, $factorSBP, $factorBMI, $factorRiskBase,  $factorMinusSumBX ){
            $OPTIMALSBP = log(110);
            $OPTIMALBMI = log(22);
            $OptimalResult = 0;
            
            $OptimalResultTemp = (log($age) * $factorAge) +
                             ($OPTIMALSBP * $factorSBP) +
                             ($OPTIMALBMI * $factorBMI) ;
            
            
            return  1 - pow($factorRiskBase, exp($OptimalResultTemp - $factorMinusSumBX) );
   
        }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Funcion para calcular el riesgo optimo dependiendo de la edad del paciente
        function calculateNormalRisk($age, $factorAge, $factorSBP, $factorBMI, $factorRiskBase,  $factorMinusSumBX ){
            $OPTIMALSBP = log(125);
            $OPTIMALBMI = log(22.5);
            $OptimalResult = 0;
            
            $OptimalResultTemp = (log($age) * $factorAge) +
                             ($OPTIMALSBP * $factorSBP) +
                             ($OPTIMALBMI * $factorBMI) ;
            
            
            return  1 - pow($factorRiskBase, exp($OptimalResultTemp - $factorMinusSumBX) );
   
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    
        $gender = $_POST['gender'];
        $age =  $_POST["age"];
        $bloodpressure = $_POST["bloodpressure"];
        $hashypertensionteatment = $_POST["hypertension"];
        $issmoker = $_POST["smoker"];
        $hasdiabetes = $_POST["diabetes"];        
        $height = $_POST["height"];
        $weight = $_POST["weight"];
        
        $bodymassindex = ($weight/2.2046) / pow($height/100,2);        
        
        //y mostramos el resultado  TODO PONERLO EN UNA VARIABLE QUE LUEGO SERA ESCRITO
        
        if($gender =='F'){
              $factorSumBetaX = calculateFactorSumBetaX($factorAgeF, $factorsmokerF, $factorbodymassindexF,    $factordiabetesF, $gender,  
                                $age,  $bloodpressure, $hashypertensionteatment, $issmoker, $bodymassindex,  $hasdiabetes);    
            
            //calculamos el riesgo del paciente
            $patientCalculatedRisk  =  calculateRiskFactor($factorRiskBaseExpF,$factorSumBetaX, $factorMinusSumBXF );
            
            //CALCULAMOS EDAD DE CORAZON
            $factorSBPNTF = 2.81291; // factor sin tratamiento de hipertension MASCULINO
            $patientCalculatedHeartAge = calculateHeartAge(  $gender,$bloodpressure,  $issmoker, $bodymassindex,$hasdiabetes,
                        $factorAgeF, $factorSBPNTF ,  $factorsmokerF,  $factorbodymassindexF, $factordiabetesF, $patientCalculatedRisk );
            
            //CALCULAMOS EL RIESGO OPTIMO QUE DEBERIA TENER EL PACIENTE
           $patientCalculatedOptimalRisk =  calculateOptimalRisk($age, $factorAgeF, $factorSBPNTF,
                                                                 $factorbodymassindexF, $factorRiskBaseExpF,  $factorMinusSumBXF);
            
        //CALCULAMOS RIESGO NORMAL    
           $patientCalculatedNormalRisk = calculateNormalRisk($age, $factorAgeF, $factorSBPNTF,
                                                                 $factorbodymassindexF, $factorRiskBaseExpF,  $factorMinusSumBXF);
            
        }else{
              $factorSumBetaX = calculateFactorSumBetaX($factorAgeM, $factorsmokerM, $factorbodymassindexM,    $factordiabetesM, $gender,  
                                $age,  $bloodpressure, $hashypertensionteatment, $issmoker, $bodymassindex,  $hasdiabetes);    
        
            //calculamos el riesgo del paciente
            $patientCalculatedRisk =  calculateRiskFactor($factorRiskBaseExpM,$factorSumBetaX, $factorMinusSumBXM ); 
            
             //CALCULAMOS EDAD DE CORAZON
            $factorSBPNTM = 1.85508; // factor sin tratamiento de hipertension MASCULINO
            $patientCalculatedHeartAge = calculateHeartAge(  $gender,$bloodpressure,  $issmoker, $bodymassindex,$hasdiabetes,
                        $factorAgeM, $factorSBPNTM ,  $factorsmokerM, $factorbodymassindexM, $factordiabetesM, $patientCalculatedRisk );
            
            //CALCULAMOS EL RIESGO OPTIMO QUE DEBERIA TENER EL PACIENTE
           $patientCalculatedOptimalRisk =  calculateOptimalRisk($age, $factorAgeM, $factorSBPNTM,
                                                                 $factorbodymassindexM, $factorRiskBaseExpM,  $factorMinusSumBXM);
          //calculamos riesgo normal         
           $patientCalculatedNormalRisk = calculateNormalRisk($age, $factorAgeM, $factorSBPNTM,
                                                                 $factorbodymassindexM, $factorRiskBaseExpM,  $factorMinusSumBXM);
      
        }
        
        $patientCalculatedHeartAge = round($patientCalculatedHeartAge,0,PHP_ROUND_HALF_UP);  
        $patientCalculatedRisk =  round( ($patientCalculatedRisk *100) ,2  );
        $patientCalculatedOptimalRisk = round( ($patientCalculatedOptimalRisk*100) ,2);
        $patientCalculatedNormalRisk = round( ($patientCalculatedNormalRisk)*100, 2);
        

        
        
        $patientResults = array('heartAge'       => $patientCalculatedHeartAge,
                                'calculatedRisk' => $patientCalculatedRisk,
                                'optimalRisk'    => $patientCalculatedOptimalRisk,
                                'normalRisk'     => $patientCalculatedNormalRisk);



    $dblink = mysqli_connect($host, $user, $password, $database);
       if(mysqli_connect_errno()) {
        echo "No se pudo conectar con la base de datos: Error: ".mysqli_connect_error();
        echo "<br/>";
        exit();
    }
                

    $updateSql = "UPDATE ccm_cvdtestanswer_data SET ccm_testanswerheartage = '".$patientCalculatedHeartAge."', 
                                                    ccm_testanswerrisk = ".$patientCalculatedRisk.", 
                                                    ccm_testansweroptimalrisk = ".$patientCalculatedOptimalRisk.",
                                                    ccm_testanswernormailrisk = ". $patientCalculatedNormalRisk."
                                                    WHERE ccm_answerid = ".$_POST["answerId"];

   if(mysqli_query($dblink, $updateSql)){
       echo "todo nice";
   }else{
       echo "error".mysqli_error($conn);
   } 
    mysqli_close($dblink);

   ?>