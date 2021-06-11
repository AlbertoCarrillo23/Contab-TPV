<?php
    require 'metodos.php';
    $objConexion=new metodos();

    $numeroFactura=$_GET["idfct"];
    $idnNegocio=$_GET["idngc"];
    $idnProveedor=$_GET["idprv"];
    $impFactura=$_GET["imp"];

    /*Librerías necesarias para genrear el excel automáticamente*/
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=Factura Nº".$numeroFactura.".xls");
?>
<table border="2px" border-color="black">
    <caption>Datos de la factura</caption>
    <tr>
        <th>Nº Factura</th>
        <th>Negocio</th>
        <th>Proveedor</th>
        <th>Total</th>
    </tr>
    <tr>
        <td><?php echo $numeroFactura ?></td>
        <td><?php echo $idnNegocio ?></td>
        <td><?php echo $idnProveedor ?></td>
        <td><?php echo $impFactura ?></td>
    </tr>
</table>