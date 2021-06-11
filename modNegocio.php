<html lang="es">
    <head>
        <title>CONTAB-TPV - MODIFICAR NEGOCIO</title>
        <meta name="author" content="Alberto Carrillo Cervera">
        <meta charset="UTF-8">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
    <h1>MODIFICAR NEGOCIOS</h1></br></br>
        <?php
            session_start();
            require 'metodos.php';
            $objConexion=new metodos();

            if(!isset($_POST["modificar"])){

                $negocio=$_GET["ngcio"];

                /*Consulta para sacar los datos del negocio a editar. Hemos pasado el idNegocio por URL de la página previa*/
                $consulta="
                    SELECT *
                    FROM negocios
                    WHERE idNegocio=".$negocio."
                ";

                $objConexion->realizarConsultas($consulta);

                $fila = $objConexion->extraerFilas();

                /*Formulario de edición de negocio. Mostramos como value de los input los datos anteriores a la modificación*/
                echo '
                        <form method="POST">
                            <fieldset class="row modgrl d-flex justify-content-center">
                                <input type="text" name="id" value="'.$fila["idNegocio"].'" hidden>
                                <label for="nNombre" class="col-5">Nombre:</label>
                                <input type="text" name="nNombre" value="'.$fila["nombre"].'" placeholder="Nombre nuevo" class="col-auto" maxlength="50" required>
                                   
                                <label for="nDireccion" class="col-5">Dirección:</label></br>
                                <input type="text" name="nDireccion" value="'.$fila["direccion"].'" placeholder="Dirección nueva" class="col-auto" maxlength="50" required>
                                
                                <label for="nCpostal" class="col-5">C.Postal:</label></br>
                                <input type="text" name="nCpostal" value="'.$fila["cpostal"].'"  placeholder="C.Postal nuevo" class="col-auto" maxlength="5" required >
                                
                                <label for="nTelefono" class="col-5">Teléfono:</label></br>
                                <input type="text" name="nTelefono" value="'.$fila["telefono"].'" placeholder="Teléfono nuevo" class="col-auto" maxlength="9" required>
                            </fieldset>
                            <div class="btmod">
                                <input type="submit" name="modificar" value="Modificar" class="col-1 justify-content-center">
                                <a href="mostNegocios.php"><input type="button" name="volver" value="Volver"></a>
                            </div>
                        </form>
                ';
            }else{

                /*Consulta para la modificación de los datos de la bbdd, introduciendo los recogidos en el formulario*/
                $consulta = "
                        UPDATE negocios SET nombre='".$_POST["nNombre"]."', direccion='".$_POST["nDireccion"]."', cpostal='".$_POST["nCpostal"]."', telefono='".$_POST["nTelefono"]."'
                        WHERE idNegocio=".$_POST["id"].";
                ";

                $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                if($objConexion->comprobar()>=0){/*Comprobamos con el método comprobar, y no con el comprobarSelect, porque no es un SELECT*/
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
                              window.location='mostNegocios.php'
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