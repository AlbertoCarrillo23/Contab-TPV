<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <script src=”https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js”></script>
        <script src=”https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js”></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos.css">
        <title>CONTAB-TPV - Añadir negocio</title>
    </head>
    <body>
        <h1>Añadir negocio</h1>
        <?php
            session_start();
            require 'metodos.php';
            $objConexion=new metodos();

            $id=$_SESSION["idUsuario"];

            if(!isset($_POST["enviar"]))
            {
                /*Formulario para añadir negocio*/
                echo '
                    <form class="row addgrl" method="POST">
                        <label for="nombre" class="col-6">Nombre del negocio</label>
                        <input type="text" name="nombre" placeholder="Nombre del negocio" required class="col-6">
                        <label for="direccion" class="col-6">Dirección del negocio</label>
                        <input type="text" name="direccion" placeholder="Dirección del negocio" required class="col-6">
                        <label for="cpostal" class="col-6">Código postal</label>
                        <input type="text" name="cpostal" placeholder="Código postal" required class="col-6">
                        <label for="telefono" class="col-6">Teléfono</label>
                        <input type="text" name="telefono" placeholder="Teléfono" required class="col-6">
                        <div class="row justify-content-center">
                            <input type="submit" name="enviar" value="Añadir" class="col-3">
                            <a href="mostNegocios.php" class="col-4"><input type="button" value="Volver" class="col-12"></a>
                        </div>
                    </form>
                    
                ';
            } else {
                /*Consulta que lleva a cabo la insersión del negocio en la bbdd*/
                $consulta="INSERT INTO negocios (nombre,direccion,cpostal,telefono,idUsuario) VALUES ('".$_POST["nombre"]."','".$_POST["direccion"]."','".$_POST["cpostal"]."','".$_POST["telefono"]."',".$id.");";
                $objConexion->realizarConsultas($consulta);/*Realizar consulta*/

                /*Sweetalert para confirmar la inserción*/
                echo "
                    <script type='text/javascript'>
                        swal({
                          title: '¡Éxito!',
                          text: '¡Añadido!',
                          type: 'success',
                          showConfirmButton: false,
                          timer: 1000
                        },
                        function(){
                          window.location='mostNegocios.php'
                        });
                    </script>
                ";
            }
        ?>
    </body>
</html>
