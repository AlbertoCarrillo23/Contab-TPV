<?php
session_start();
require 'metodos.php';
$objConexion=new metodos();

if(isset($_GET["fact"])){
    $consulta="
                DELETE 
                FROM facturas
                WHERE idFactura=".$_GET["fact"].";    
            ";
    $objConexion->realizarConsultas($consulta);
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="estilos.css" type="text/css" rel="stylesheet">
        <title>CONTAB-TPV - Mostrar facturas</title>
    </head>
    <body>
        <?php
            echo '
                <h1>MIS FACTURAS</h1>
            <nav>
                <ul class="row justify-content-center">
                    <li class="col-3"><a href="addFacturas.php">Añadir</a></li>
                    <div class="col-1"></div>
                    <li class="col-3"><a href="comprobarInicio.php">Volver</a></li>
                </ul>
            </nav>
                
            ';


            if(isset($_GET["prv"])){

                /*Consulta para mostrar las facturas del proveedor que hayamos seleccionado en la página anterior*/
                $consulta="
                        SELECT f.idFactura AS 'numFactura', f.idNegocio AS 'negocio', f.idProveedor AS 'proveedor', f.importe AS 'importe', p.idUsuario AS 'usuario', p.nombre AS 'nombrePrv', p.idProveedor AS 'idProveedor', p.idNegocio AS 'idNegocio', n.idNegocio,n.nombre AS 'nombreNeg'
                        FROM facturas f INNER JOIN proveedores p                    
                            ON f.idProveedor=p.idProveedor
                            INNER JOIN negocios n
                                ON f.idNegocio=n.idNegocio
                        WHERE f.idProveedor=".$_GET["prv"]." and f.idNegocio=".$_GET["ngc"].";
                    ";

                $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                if($objConexion->comprobarSelect()>0) {
                    echo '<ol>';
                    /*Bucle para sacar tantas facturas del proveedor como filas de la tabla correspondan*/
                    while ($fila = $objConexion->extraerFilas()) {
                        /*Esta parte está tabulada de esta manera para que se aprecie bien la estructura*/

                        echo '</br>
                                <hr size="5px">
                                    </br>
                                        <div class="row">
                                            <div class="col-2 centrar"><span class="mostrar">Nº Factura</span></br>'.$fila["numFactura"].'</div>
                                            <div class="col-3 centrar"><span class="mostrar">Negocio</span></br>'.$fila["nombreNeg"].'</div>
                                            <div class="col-2 centrar"><span class="mostrar">Proveedor</span></br>'.$fila["nombrePrv"].'</div>
                                            <div class="col-3 centrar"><span class="mostrar">Importe</span></br>'.$fila["importe"].'</div>
                                            <div class="col-2 centrar"><span class="mostrar">Editar</span></br><a href="#" onclick="confirmar('.$fila["numFactura"].')"><img src="imagenes/bin.png" alt="Borrar factura"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="modFacturas.php?idfct='.$fila["numFactura"].'&idngc='.$fila["negocio"].'&idprv='.$fila["proveedor"].'"><img src="imagenes/modif.png" alt="Modificar factura"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="genExcel.php?idfct='.$fila["numFactura"].'&idngc='.$fila["nombreNeg"].'&idprv='.$fila["nombrePrv"].'&imp='.$fila["importe"].'"><img src="imagenes/factura.png" alt="Generar factura en Excel"></a></div>
                                        </div>
                                    </br>
                                <hr size="5px">
                              </br>
                              
                            ';
                    }
                    echo '</ol>
                        <div class="footer">
                            <footer class="row">
                                <div class="col-6 justify-content-center">
                                    <div class="logopie"><img src="imagenes/logo.png" alt="Logo en pie de página"></div>
                                </div>
                                <div class="col-6">
                                    <div class="col-12 textopie">
                                        <h4>Contáctanos</h4>
                                        <p>
                                            C/Jovellanos, 37B</br>
                                            San Vicente de Alcántara, 06500</br>
                                            Badajoz,(Extremadura)</br>
                                            <a href="mailto:contabtpv@gmail.com?Subject=Interesado%en%la%APP">contabtpv@gmail.com</a></br>
                                            Tlf: 698741235
                                        </p>
                                    </div>
                                </div>
                            </footer>
                        </div>   
                    ';
                }else{
                    echo 'No se han encontrado facturas para este proveedor';
                }
            }else{
                /*Consulta para sacar todas las facturas*/
                $consulta="
                            SELECT f.idFactura AS 'numFactura', f.idNegocio AS 'negocio', f.idProveedor AS 'proveedor', f.importe AS 'importe', p.idUsuario AS 'usuario', p.nombre AS 'nombrePrv', p.idProveedor AS 'idProveedor', p.idNegocio AS 'idNegocio', n.idNegocio,n.nombre AS 'nombreNeg'
                                FROM facturas f INNER JOIN proveedores p                    
                                    ON f.idProveedor=p.idProveedor
                                    INNER JOIN negocios n
                                        ON f.idNegocio=n.idNegocio
                            WHERE p.idUsuario=".$_SESSION["idUsuario"].";
                        ";

                $objConexion->realizarConsultas($consulta);

                $fila = $objConexion->extraerFilas();

                /*Comprobación de la realización de la consulta*/
                if($objConexion->comprobarSelect()>0){
                    echo '<ol>';
                    /*Bucle para sacar tantos proveedores del negocio como filas de la tabla correspondan*/
                    while ($fila = $objConexion->extraerFilas()) {
                        /*Esta parte está tabulada de esta manera para que se aprecie bien la estructura*/
                        echo '</br>
                                    <hr size="5px">
                                        </br>
                                            <div class="row">
                                                <div class="col-2 centrar"><span class="mostrar">Nº Factura</span></br>'.$fila["numFactura"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Negocio</span></br>'.$fila["nombreNeg"].'</div>
                                                <div class="col-2 centrar"><span class="mostrar">Proveedor</span></br>'.$fila["nombrePrv"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Importe</span></br>'.$fila["importe"].'</div>
                                                <div class="col-2 centrar"><span class="mostrar">Editar</span></br><a href="#" onclick="confirmar('.$fila["numFactura"].')"><img src="imagenes/bin.png" alt="Borrar factura"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="modFacturas.php?idfct='.$fila["numFactura"].'&idngc='.$fila["negocio"].'&idprv='.$fila["proveedor"].'"><img src="imagenes/modif.png" alt="Modificar factura"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="genExcel.php?idfct='.$fila["numFactura"].'&idngc='.$fila["nombreNeg"].'&idprv='.$fila["nombrePrv"].'&imp='.$fila["importe"].'"><img src="imagenes/factura.png" alt="Generar factura en Excel"></a></div>
                                            </div>
                                        </br>
                                    <hr size="5px">
                              </br>
                            ';
                    }
                    echo '</ol>
                        <div class="footer">
                            <footer class="row">
                                <div class="col-6 justify-content-center">
                                    <div class="logopie"><img src="imagenes/logo.png" alt="Logo en pie de página"></div>
                                </div>
                                <div class="col-6">
                                    <div class="col-12 textopie">
                                        <h4>Contáctanos</h4>
                                        <p>
                                            C/Jovellanos, 37B</br>
                                            San Vicente de Alcántara, 06500</br>
                                            Badajoz,(Extremadura)</br>
                                            <a href="mailto:contabtpv@gmail.com?Subject=Interesado%en%la%APP">contabtpv@gmail.com</a></br>
                                            Tlf: 698741235
                                        </p>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    ';
                }else{
                    echo 'No se han encontrado proveedores para este negocio';
                }
            }
        ?>
    </body>
</html>

<script type="text/javascript">
    function confirmar(factura) {
        Swal.fire({
            title: '¡Atención!',
            text: "¿Seguro que desea borrar esta factura?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#31DB07',
            cancelButtonColor: '#FF0000',
            confirmButtonText: 'Borrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href="mostFacturas.php?fact="+factura;
            }
        })
    }
</script>


