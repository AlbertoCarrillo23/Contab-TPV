<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>CONTAB-TPV</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <?php
            require_once 'metodos.php';
            session_start();/*Creación de la sesión*/
            $objMetodos = new metodos();/*Creación del objeto para los métodos ya definidos*/

            if(isset($_SESSION["idUsuario"])){/*Si volvemos de una de las páginas de la aplicación, preguntaremos si existe el idUsuario en la sesión, y existirá*/
                /*----------Menú y página de inicio----------*/
                echo '
                    <h1>CONTAB-TPV</h1>
                    <nav>
                        <ul>
                            <li><a href="mostNegocios.php">Mis negocios</a></li>
                            <li><a href="mostProveedores.php">Mis proveedores</a></li>
                            <li><a href="mostPedidos.php">Mis pedidos</a></li>
                            <li><a href="mostFacturas.php">Mis facturas</a></li>
                            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
                        </ul>
                    </nav>
                    <div class="row container">
                        <h1>DATOS DEL USUARIO</h1>
                        <ol id="datosuser">
                            <div id="imguser" class="col-3"><img src="imagenes/user.png" alt="Usuario" id="userimg"></div>
                            <li class="col-9 ">IDENTIFICADOR DEL USUARIO: '.$_SESSION["idUsuario"].'</li>
                            <li class="col-9 ">NOMBRE DE USUARIO: '.$_SESSION["nombre"].'</li>
                            <li class="col-9 ">CORREO DEL USUARIO: '.$_SESSION["correo"].'</li>
                        </ol>
                    </div>
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
                /*----------Fin de menú y página de inicio----------*/
            }else{
                if(!empty($_POST["correo"]) && !empty($_POST["password"])){/*Si venimos de la página de inicio
                    de sesión, primero confirmaremos los campos necesarios, para despues mostrar el menú*/

                    /*Consulta para comprobar la contraseña encriptada*/
                    $consultapasswd=
                        "
                            SELECT password
                            FROM usuarios
                            WHERE correo='".$_POST["correo"]."';
                        ";
                    $objMetodos->realizarConsultas($consultapasswd);/*Ejecuta la consulta que extrae la contraseña de la bbdd*/

                    /*Comprobación de la realización de la consulta*/
                    if($objMetodos->comprobarSelect()>0){

                        $fila = $objMetodos->extraerFilas();
                        $hash = $fila["password"];

                        if($objMetodos->verificar($_POST["password"], $hash)){/*Verifica que la contraseña introducida es la correcta*/
                            /*Consulta para la verificación*/
                            $consulta =
                                "
                                    SELECT *
                                    FROM usuarios
                                    WHERE correo='" . $_POST["correo"] . "'&& password='" . $hash . "';
                                ";
                            $objMetodos->realizarConsultas($consulta);/*Realizar consulta*/

                            /*Comprobación de la realización de la consulta*/
                            if ($objMetodos->comprobarSelect() > 0) {
                                $fila = $objMetodos->extraerFilas();
                                /*Guarda los campos señalados en la sesión*/
                                $_SESSION["idUsuario"] = $fila["idUsuario"];
                                $_SESSION["nombre"] = $fila["nombre"];
                                $_SESSION["correo"] = $fila["correo"];

                                /*----------Menú y página de inicio----------*/
                                echo '
                                    <h1>CONTAB-TPV</h1>
                                    <nav>
                                        <ul>
                                            <li><a href="mostNegocios.php">Mis negocios</a></li>
                                            <li><a href="mostProveedores.php">Mis proveedores</a></li>
                                            <li><a href="mostPedidos.php">Mis pedidos</a></li>
                                            <li><a href="mostFacturas.php">Mis facturas</a></li>
                                            <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
                                        </ul>
                                    </nav>
                                    <div class="row container">
                                        <h1>DATOS DEL USUARIO</h1>
                                        <ol id="datosuser">
                                            <div id="imguser" class="col-3"><img src="imagenes/user.png" alt="Usuario" id="userimg"></div>
                                            <li class="col-9">IDENTIFICADOR DEL USUARIO: '.$_SESSION["idUsuario"].'</li>
                                            <li class="col-9">NOMBRE DE USUARIO: '.$_SESSION["nombre"].'</li>
                                            <li class="col-9">CORREO DEL USUARIO: '.$_SESSION["correo"].'</li>
                                        </ol>
                                    </div>
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
                                /*----------Fin de menú y página de inicio----------*/
                            }else{
                                /* Avisa de que no se encuentran los datos introducidos*/
                                echo "
                                    <script type='text/javascript'>
                                        swal({
                                          title: '¡Error!',
                                          text: '¡Regístrese por favor!',
                                          type: 'error',
                                          showConfirmButton: false,
                                          timer: 1000
                                        },
                                        function(){
                                          window.location='inicioSesion.html';
                                        });
                                    </script>
                                ";
                            }
                        }else{
                            /*Avisa de que la contraseña es incorrecta*/
                            echo "
                                <script type='text/javascript'>
                                    swal({
                                      title: '¡Error!',
                                      text: 'Contraseña incorrecta. Inténtelo de nuevo',
                                      type: 'error',
                                      showConfirmButton: false,
                                      timer: 1000
                                    },
                                    function(){
                                      window.location='inicioSesion.html';
                                    });
                                </script>
                            ";
                        }
                    }else{
                        /*Avisa de que el correo es incorrecto*/
                        echo "
                            <script type='text/javascript'>
                                swal({
                                  title: '¡Error!',
                                  text: 'Correo incorrecto. Inténtelo de nuevo',
                                  type: 'error',
                                  showConfirmButton: false,
                                  timer: 1000
                                },
                                function(){
                                  window.location='inicioSesion.html';
                                });
                            </script>
                        ";
                    }
                }else{
                    /*Avisa de que algún campo no ha sido rellenado*/
                    echo "
                        <script type='text/javascript'>
                            swal({
                              title: '¡Error!',
                              text: 'Por favor, rellene todos los campos',
                              type: 'error',
                              showConfirmButton: false,
                              timer: 1000
                            },
                            function(){
                              window.location='inicioSesion.html';
                            });
                        </script>
                    ";
                }
            }
        ?>
    </body>
</html>