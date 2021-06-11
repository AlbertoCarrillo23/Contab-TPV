<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>CONTAB-TPV - REGISTRO</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
    <h1>CONTAB-TPV</h1>
        <?php
            require_once 'metodos.php';
            $objMetodos =new metodos();
            if(!isset($_POST["registrarme"])){/*Comprueba si el botón que se ha presionado en el inicio de sesión es el de registro*/
                echo/*Formulario de registro para nuevos usuarios*/
                '
                    <form action="" METHOD="POST" class="formreg">
                       <label for ="nombre">NOMBRE DE USUARIO</label></br>
                       <input type="text" name="nombre" placeholder="Nombre de usuario"/></br></br>
                       <label for ="password">CONTRASEÑA</label></br>
                       <input type="password" name="password" placeholder="Contraseña"/></br></br>
                       <label for ="password2">REPITA LA CONTRASEÑA</label></br>
                       <input type="password" name="password2" placeholder="Contraseña"/></br></br>
                       <label for ="email">CORREO ELECTRÓNICO</label></br>
                       <input type="email" name="correo" placeholder="Correo Electrónico"/></br></br>
                       <input type="submit" value="Registrarme" name="registrarme"/>
                   </form>
                ';
            }else{
                if($_POST["password"] != $_POST["password2"]){/*Comprueba si la contraseña y la repetición de esta son iguales*/
                    echo "
                        <script type='text/javascript'>
                            swal({
                              title: '¡Error!',
                              text: '¡Las contraseñas no coinciden!',
                              type: 'error',
                              showConfirmButton: false,
                              timer: 1000
                            },
                            function(){
                              window.location='registro.php'
                            });
                        </script>
                    ";
                }else{
                    if(empty($_POST["nombre"])){/*Comprueba si se ha dejado vacío el campo "nombre"*/
                        echo "
                        <script type='text/javascript'>
                            swal({
                              title: '¡Error!',
                              text: '¡Rellene el nombre de usuario, por favor!',
                              type: 'error',
                              showConfirmButton: false,
                              timer: 1000
                            },
                            function(){
                              window.location='registro.php'
                            });
                        </script>
                    ";
                    }else{
                        if(empty($_POST["password"])){/*Comprueba si se ha dejado vacío el campo "contraseña"*/
                            echo "
                                <script type='text/javascript'>
                                    swal({
                                      title: '¡Error!',
                                      text: '¡Introduzca la contraseña, por favor!',
                                      type: 'error',
                                      showConfirmButton: false,
                                      timer: 1000
                                    },
                                    function(){
                                      window.location='registro.php'
                                    });
                                </script>
                            ";
                        }else{
                            if(empty($_POST["password2"])){/*Comprueba si se ha dejado vacío el campo "repetir contraseña"*/
                                echo "
                                    <script type='text/javascript'>
                                        swal({
                                          title: '¡Error!',
                                          text: '¡Por favor, repita su contraseña!',
                                          type: 'error',
                                          showConfirmButton: false,
                                          timer: 1000
                                        },
                                        function(){
                                          window.location='registro.php'
                                        });
                                    </script>
                                ";
                            }else{
                                $encript=$objMetodos->encriptar($_POST["password"]);/*Encripta la contraseña*/
                                if(empty($_POST["correo"])){/*Comprueba si se ha dejado vacío el campo "correo"*/
                                    echo "
                                        <script type='text/javascript'>
                                            swal({
                                              title: '¡Error!',
                                              text: '¡Rellene el campo correo, por favor!',
                                              type: 'error',
                                              showConfirmButton: false,
                                              timer: 1000
                                            },
                                            function(){
                                              window.location='registro.php'
                                            });
                                        </script>
                                    ";
                                }else {
                                    /*Consulta que realiza la inserción de los datos en la bbdd*/
                                    $consulta =
                                        "
                                            INSERT INTO usuarios (nombre,correo,password)
                                            VALUES ('" . $_POST["nombre"] . "','" . $_POST["correo"] . "','" . $encript . "');
                                        ";
                                    $objMetodos->realizarConsultas($consulta);/*Ejecuta la consulta*/
                                    if ($objMetodos->comprobar() > 0) {
                                        /*Avisa de que se ha completado el registro*/
                                        echo "
                                            <script type='text/javascript'>
                                                swal({
                                                  title: '¡Éxito!',
                                                  text: '¡Registro completado!',
                                                  type: 'success',
                                                  showConfirmButton: false,
                                                  timer: 1000
                                                },
                                                function(){
                                                  window.location='inicioSesion.html'
                                                });
                                            </script>
                                        ";
                                    } else {
                                        if ($objMetodos->numeroError() == 1062) {/*Comprobación del número de error*/
                                            /*Avisa de que el correo introducido está repetido*/
                                            echo "
                                                <script type='text/javascript'>
                                                    swal({
                                                      title: '¡Error!',
                                                      text: '¡El correo introducido está repetido, introduzca otro!',
                                                      type: 'error',
                                                      showConfirmButton: false,
                                                      timer: 1000
                                                    },
                                                    function(){
                                                      window.location='registro.php'
                                                    });
                                                </script>
                                            ";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </body>
</html>
