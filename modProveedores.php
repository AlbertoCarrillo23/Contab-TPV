<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <title>ORGANIZADOR DE MATERIAL - BUSCAR CATEGORÍA</title>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <h1>Modificar Proveedor</h1>
        <?php
            require_once 'metodos.php';
            session_start();
            $objConexion =new metodos();

            if(!isset($_POST["modificar"])) {

                /*Sacamos los ids en variables*/
                $proveedor = $_GET["idProveedor"];
                $negocio = $_GET["idNegocio"];

                /*Consulta para sacar los proveedores del negocio seleccionado en la página anterior*/
                $consulta = "
                    SELECT *
                    FROM proveedores
                    WHERE idProveedor=" . $proveedor . " and idNegocio=" . $negocio . "
                ";

                $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                $fila = $objConexion->extraerFilas();

                /*Formulario para modificar proveedores*/
                echo '
                    <form method="POST">
                        <fieldset class="row modgrl d-flex justify-content-center">
                            <input type="text" name="idP" value="' . $fila["idProveedor"] . '" hidden>
                            <input type="text" name="idN" value="' . $fila["idNegocio"] . '" hidden>
                            
                            <label for="nNombre">Nombre:</label>
                            <input type="text" name="nNombre" value="' . $fila["nombre"] . '" placeholder="Nombre nuevo" maxlength="50" required>
                            
                            <label for="nTelefono">Teléfono:</label>
                            <input type="text" name="nTelefono" value="' . $fila["telefono"] . '" placeholder="Teléfono nuevo" maxlength="9" required>
                        </fieldset>
                        <div class="btmod">
                            <input type="submit" name="modificar" value="Modificar" class="col-1 justify-content-center">
                            <a href="mostProveedores.php"><input type="button" name="volver" value="Volver"></a>
                        </div>
                    </form>
                ';
            }else{

                /*Consulta para actualizar los datos dentro de la bbdd*/
                $consulta = "
                    UPDATE proveedores SET nombre='".$_POST["nNombre"]."', telefono='".$_POST["nTelefono"]."'
                    WHERE idProveedor=".$_POST["idP"]." and idNegocio=".$_POST["idN"].";
                ";

                $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                /*Comprobación de la realización de la consulta*/
                if($objConexion->comprobar()>=0){
                    /*Sweetalert que confirma la actualización*/
                    echo "
                        <script type='text/javascript'>
                            swal({
                              title: '¡Éxito!',
                              text: '¡Actualado!',
                              type: 'success',
                              showConfirmButton: false,
                              timer: 1000
                            },
                            function(){
                              window.location='mostProveedores.php'
                            });
                        </script>
                    ";
                }else{
                    /*Sweetalert que deniega la actualización*/
                    echo "
                        <script type='text/javascript'>
                            swal({
                              title: '¡Error!',
                              text: 'Actualización errónea',
                              type: 'error',
                              showConfirmButton: false,
                              timer: 1000
                            },
                            function(){
                              window.location='mostProveedores.php'
                            });
                        </script>
                    ";
                }
            }
        ?>
    </body>
</html>