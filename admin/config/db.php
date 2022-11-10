<?php
    $host="localhost";
    $bd="bd_peluqueria";
    $usuario="root";
    $contrasena="";
   
    
        $conexion=mysqli_connect($host,$usuario,$contrasena,$bd);
        $conexion2=new PDO("mysql:host=$host;dbname=$bd" ,$usuario,$contrasena);
    ?>