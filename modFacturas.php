<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <title>CONTAB-TPV - MODIFICAR FACTURAS</title>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
    <h1>Modificar facturas</h1>
        <?php
            require_once 'metodos.php';
            session_start();
            $objConexion =new metodos();

            $idntFactura=$_GET["idfct"];

            /*Consulta para sacar el id de la factura */
            $consultaid="
                SELECT *
                FROM facturas
                WHERE idFactura=".$idntFactura."
            ";

            $objConexion->realizarConsultas($consultaid);/*Realizar consulta*/

            $fila = $objConexion->extraerFilas();/*Extraer campos de la consulta en una celda de array cada uno*/

            if(!isset($_POST["enviar"])){
                echo '
                        <form class="row addgrl" method="post">
                            <input type="text" name="id" value="'.$fila["idFactura"].'" hidden>
                            <label for="ngcs" class="col-6">Nombre del negocio:</label>
                            
                    ';

                /*Consulta para sacar los negocios del usuario de la sesión*/
                $consulta1="
                                SELECT *
                                FROM negocios 
                                WHERE idUsuario=".$_SESSION["idUsuario"].";
                            ";

                $objConexion->realizarConsultas($consulta1);/*Realizar consulta*/

                /*Comprobación de la realización de la consulta*/

                /*Bucle para sacar los negocios del usuario con sesión activa*/
                echo '<select id="ngcs" name="ngcs" class="col-6" required>
                          <option value="ninguno">Seleccione un negocio</option>
    
                                        
                                ';
                /*Select que muestra los negocios pertenecientes al usuario con sesión activa*/
                while($fila=$objConexion->extraerFilas()){
                    echo'<option value="'.$fila["idNegocio"].'">'.$fila["nombre"].'</option>';
                }
                echo '</select>';

                echo'
                    <label for="prvs" class="col-6">Nombre del proveedor:</label>
                    <select id="prvs" name="prvs" class="col-6" required>
                                        
                                ';
                        /*Ajax que envía a una página intermedia el negocio elegido para traer de ella los proveedores de este, de manera dinámica*/
                        echo '
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    recargarLista();
            
                                    $("#ngcs").change(function() {
                                        recargarLista();
                                    });
                                })
                            </script>
                            <script type="text/javascript">
                                function recargarLista() {
                                    $.ajax({
                                        type: "POST",/*Por el método POST lleva DATA a la página URL*/
                                        url: "addFacturas2.php",
                                        data: "x=" + $("#ngcs").val(),
                                        success:function(r) {
                                            $("#prvs").html(r);
                                        }
                                    });
                                }
                            </script>
                        </select>
                        <label for="importe" class="col-6">Importe de la factura</label>
                        <input type="number" name="importe" step="0.01" min="0" class="col-6">
                        <div class="row justify-content-center">
                            <input type="submit" name="enviar" value="Modificar" class="col-3">
                            <a href="mostFacturas.php" class="col-4"><input type="button" value="Volver" class="col-12"></a>
                        </div>
                    </form>
                ';
        } else {

                /*Consulta para la modificación de los datos de la bbdd, introduciendo los recogidos en el formulario*/
                $consulta="
                UPDATE facturas SET idNegocio=".$_POST["ngcs"].", idProveedor=".$_POST["prvs"].", importe=".$_POST["importe"]."
                WHERE idFactura=".$_POST["id"]."
            ";

            $objConexion->realizarConsultas($consulta);

            if ($objConexion->comprobar()>=0){/*Comprobamos con el método comprobar, y no con el comprobarSelect, porque no es un SELECT*/
                /*Confirma la modificación*/
                echo "
                    <script type='text/javascript'>
                        swal({
                          title: '¡Éxito!',
                          text: '¡Actualizado!',
                          type: 'success',
                          showConfirmButton: false,
                          timer: 1000
                        },
                        function(){
                          window.location='mostFacturas.php'
                        });
                    </script>
                ";

            }else{
                /*Deniega la modificación*/
                echo "
                    <script type='text/javascript'>
                        swal({
                          title: '¡Error!',
                          text: '¡Actualización errónea!',
                          type: 'error',
                          showConfirmButton: false,
                          timer: 1000
                        },
                        function(){
                          window.location='mostNegocios.php'
                        });
                    </script>
                ";
            }

        }
        ?>
    </body>
</html>

