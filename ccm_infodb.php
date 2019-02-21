<?php
    // devuelve los parametros a utilizar para la conexion con el servidor


    function getServidor()
    {
       // $server = "localhost";
         $server = "127.0.0.1";
        return $server;
    };
    
    function getUsuario()
    {
        $username = "ccmphp_local";
        return $username;
    };
    
    function getContrasena()
    {
        $password = "ccmphp_local_pass";
        return $password;
    };
  
    function getBasedatos()
    {
        $database = "ccm_cvd_local";
        return $database;
    };

    
?>
