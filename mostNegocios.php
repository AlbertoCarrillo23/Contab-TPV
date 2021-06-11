<?php
    session_start();
    require 'metodos.php';
    $objConexion=new metodos();


    if(isset($_GET["ngc"])){
            $consulta="
                DELETE 
                FROM negocios
                WHERE idNegocio=".$_GET["ngc"].";    
            ";
        $objConexion->realizarConsultas($consulta);
    }
?>
<html>
    <head>
        <title>CONTAB-TPV - MIS NEGOCIOS</title>
        <meta name="author" content="Alberto Carrillo Cervera">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="estilos.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h1>MIS NEGOCIOS</h1>
        <nav>
            <ul class="row justify-content-center">
                <li class="col-3"><a href="addNegocio.php">Añadir</a></li>
                <div class="col-1"></div>
                <li class="col-3"><a href="comprobarInicio.php">Volver</a></li>
            </ul>
        </nav>
        <?php
            //Sacamos todos los negocios pertenecientes al "idUsuario" almacenado en la sesión
            $consulta="SELECT * FROM negocios WHERE idUsuario=".$_SESSION["idUsuario"].";";
            $objConexion->realizarConsultas($consulta);

            //Creamos la estructura que tendrá la aplicación a la hora de mostrar los negocios del usuario
            /*Comprobación de la realización de la consulta*/
            if($objConexion->comprobarSelect()>0) {
                echo '<ol>';
                //Bucle para sacar tantos negocios como filas de la tabla correspondan
                while ($fila = $objConexion->extraerFilas()) {
                    //Esta parte está tabulada de esta manera para que se aprecie bien la estructura
                    echo '</br>
                                <hr size="5px">
                                    </br>
                                        <div class="row">
                                            <div class="col-2 centrar"><span class="mostrar">Nombre</span></br>'.$fila["nombre"].'</div>
                                            <div class="col-2 centrar"><span class="mostrar">Dirección</span></br>'.$fila["direccion"].'</div>
                                            <div class="col-2 centrar"><span class="mostrar">C. Postal</span></br>'.$fila["cpostal"].'</div>
                                            <div class="col-2 centrar"><span class="mostrar">Teléfono</span></br>'.$fila["telefono"].'</div>
                                            <div class="col-2 centrar"><span class="mostrar">Proveedores</span></br><a href="mostProveedores.php?neg='.$fila["idNegocio"].'"><img src="imagenes/carrito.png" alt="Consultar proveedores"></a></div>
                                            <div class="col-2 centrar"><span class="mostrar">Editar</span></br><a href="#" onclick="confirmar('.$fila["idNegocio"].')"><img src="imagenes/bin.png" alt="Borrar negocio"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="modNegocio.php?ngcio='.$fila["idNegocio"].'"><img src="imagenes/modif.png" alt="Modificar negocio"></a></div>
                                        </div>
                                    </br>
                                <hr size="5px">
                          </br>
                    ';
                }
                echo '</ol>
                    
                ';

            }else{
                echo 'No se han encontrado negocios para su usuario';
            }
        ?>
    </body>
</html>


<script type="text/javascript">
    function confirmar(negocio) {
        Swal.fire({
            title: '¡Atención!',
            text: "¿Seguro que desea borrar el negocio?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#31DB07',
            cancelButtonColor: '#FF0000',
            confirmButtonText: 'Borrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                    window.location.href="mostNegocios.php?ngc="+negocio;
            }
        })
    }
</script>

