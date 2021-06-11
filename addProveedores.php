<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <title>CONTAB-TPV - AÑADIR PROVEEDORES</title>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <h1>Añadir proveedor</h1>
        <?php
            require_once 'metodos.php';
            session_start();
            $objConexion =new metodos();

            if(!isset($_POST["enviar"])){
                /*Formulario para añadir proveedores*/
                echo '
                    <form class="row addgrl" method="POST">
                        <label for="nombre" class="col-6">Nombre del proveedor</label>
                        <input type="text" name="nombre" placeholder="Nombre del proveedor" required class="col-6">
                        <label for="direccion" class="col-6">Teléfono del proveedor</label>
                        <input type="text" name="telefono" placeholder="Teléfono del proveedor" required class="col-6">
                        <label for="cpostal" class="col-6">Negocio</label>
                ';

                /*Consulta para sacar los negocios, para introducirlos en el siguiente alert*/
                $consulta="
                        SELECT *
                        FROM negocios 
                        WHERE idUsuario=".$_SESSION["idUsuario"].";
                    ";

                $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                /*Comprobación de la realización de la consulta*/
                if($objConexion->comprobarSelect()>0) {
                    /*Bucle para sacar los negocios del usuario con sesión activa*/
                    echo '<select name="ngcs" class="col-6">';
                            while($fila=$objConexion->extraerFilas()){
                                echo'<option value="'.$fila["idNegocio"].'">'.$fila["nombre"].'</option>';
                            }
                    echo '</select>';
                }else{
                    echo 'No se han encontrado negocios';
                }
                echo '
                        <div class="row justify-content-center">
                            <input type="submit" name="enviar" value="Añadir" class="col-3">
                            <a href="mostNegocios.php" class="col-4"><input type="button" value="Volver" class="col-12"></a>
                        </div>
                    </form>
                ';
            }else{
                /*Consulta para insertar los datos del formulario en la bbdd*/
                $consulta2="
                    INSERT INTO proveedores (nombre,telefono,idUsuario,idNegocio) VALUES ('".$_POST["nombre"]."','".$_POST["telefono"]."',".$_SESSION["idUsuario"].",'".$_POST["ngcs"]."');
                ";

                $objConexion->realizarConsultas($consulta2);/*Realizar consulta*/

                /*Sweetalert para confirmar la inserción*/
                echo "
                    <script type='text/javascript'>
                        swal({
                          title: '¡Éxito!',
                          text: '¡Proveedor añadido!',
                          type: 'error',
                          showConfirmButton: false,
                          timer: 1000
                        },
                        function(){
                          window.location='mostProveedores.php';
                        });
                    </script>
                ";

            }
        ?>
    </body>
</html>

