<?php
    session_start();
    require 'metodos.php';
    $objConexion=new metodos();

    if(isset($_GET["prv"])){
        $consulta="
                    DELETE 
                    FROM proveedores
                    WHERE idProveedor=".$_GET["prv"].";    
                ";
        $objConexion->realizarConsultas($consulta);
        echo "
                <script type='text/javascript'>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                </script>
                
            ";
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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="estilos.css" type="text/css" rel="stylesheet">
        <title>CONTAB-TPV - Mis proveedores</title>
    </head>
    <body>
        <h1>MIS PROVEEDORES</h1>
        <nav>
            <ul class="row justify-content-center">
                <li class="col-3"><a href="addProveedores.php">Añadir</a></li>
                <div class="col-1"></div>
                <li class="col-3"><a href="comprobarInicio.php">Volver</a></li>
            </ul>
        </nav>
            <?php
                if(isset($_GET["neg"])){
                    /*Consulta que saca los proveedores del negocio seleccionado en la página anterior*/
                    $consulta="
                        SELECT p.idProveedor AS 'idProveedor', p.nombre AS 'proveedor', p.telefono as 'tlfProveedor', p.idNegocio AS 'idNegocio', n.nombre AS 'negocio' 
                            FROM proveedores p INNER JOIN negocios n                    
                                ON p.idNegocio=n.idNegocio
                        WHERE p.idNegocio=".$_GET["neg"].";
                    ";

                    $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                    if($objConexion->comprobarSelect()>0) {
                        echo '<ol>';
                        /*Bucle para sacar tantos proveedores del negocio como filas de la tabla correspondan*/
                        while ($fila = $objConexion->extraerFilas()) {
                            /*Esta parte está tabulada de esta manera para que se aprecie bien la estructura*/
                            echo '</br>
                                    <hr size="5px">
                                        </br>
                                            <div class="row">
                                                <div class="col-3 centrar"><span class="mostrar">Nombre</span></br>'.$fila["proveedor"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Dirección</span></br>'.$fila["tlfProveedor"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Negocio</span></br>'.$fila["negocio"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Facturas</span></br><a href="mostFacturas.php?prv='.$fila["idProveedor"].'&ngc='.$fila["idNegocio"].'"><img src="imagenes/anadir.png" alt="Consultar facturas del proveedor"></a></div>
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
                        echo '</br></br><li class="col-3"><a href="comprobarInicio.php">Volver</a></li>';
                    }
                }else{
                    /*Consulta para sacar todos los proveedores de todos los negocios del usuario*/
                    $consulta="
                        SELECT p.idProveedor AS 'idProveedor', p.nombre AS 'proveedor', p.telefono as 'tlfProveedor', p.idNegocio AS 'idNegocio', n.nombre AS 'negocio', n.idUsuario AS 'usuario'
                            FROM proveedores p INNER JOIN negocios n                    
                                ON p.idNegocio=n.idNegocio
                        WHERE n.idUsuario=".$_SESSION["idUsuario"].";
                    ";

                    $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

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
                                                <div class="col-2 centrar"><span class="mostrar">Nombre</span></br>'.$fila["proveedor"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Dirección</span></br>'.$fila["tlfProveedor"].'</div>
                                                <div class="col-2 centrar"><span class="mostrar">Negocio</span></br>'.$fila["negocio"].'</div>
                                                <div class="col-3 centrar"><span class="mostrar">Facturas</span></br><a href="mostFacturas.php?prv='.$fila["idProveedor"].'&ngc='.$fila["idNegocio"].'"><img src="imagenes/anadir.png" alt="Consultar facturas del proveedor"></a></div>
                                                <div class="col-2 centrar"><span class="mostrar">Editar</span></br><a href="#" onclick="confirmar('.$fila["idProveedor"].')"><img src="imagenes/bin.png" alt="Borrar negocio"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="modProveedores.php?idProveedor='.$fila["idProveedor"].'&idNegocio='.$fila["idNegocio"].'"><img src="imagenes/modif.png" alt="Modificar proveedor"></a></div>
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
    function confirmar(proveedor) {
        Swal.fire({
            title: '¡Atención!',
            text: "¿seguro que desea borrar el negocio?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#31DB07',
            cancelButtonColor: '#FF0000',
            confirmButtonText: 'Borrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href="mostProveedores.php?prv="+proveedor;
            }
        })
    }
</script>
