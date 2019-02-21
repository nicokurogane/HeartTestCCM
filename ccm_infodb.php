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
        $username = "ccmphpuser";
        return $username;
    };
    
    function getContrasena()
    {
        $password = "ccmphpuser123";
        return $password;
    };
  
    function getBasedatos()
    {
        $database = "ccm_cvdtest";
        return $database;
    };

    
?>