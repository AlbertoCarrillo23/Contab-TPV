<?php
    session_start();
    require 'metodos.php';
    $objConexion=new metodos();


    $consulta2="
        SELECT idProveedor, nombre
        FROM proveedores 
        WHERE idNegocio=".$_POST['x'].";
    ";

    $objConexion->realizarConsultas($consulta2);


    while($fila=$objConexion->extraerFilas()){
        echo"<option value=".$fila["idProveedor"].">".$fila["nombre"]."</option>";
    }

?>