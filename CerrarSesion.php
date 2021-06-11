<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <title>CONTAB-TPV - CERRAR SESIÓN</title>
        <script src=”https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js”></script>
        <script src=”https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js”></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <h1>Cerrar sesión</h1>
        <?php
            session_start();
            if (session_destroy()) {/*IF para destruir la sesión*/
                echo "
                    <script type='text/javascript'>
                        swal({
                          title: '¡Éxito!',
                          text: '¡Sesión cerrada!',
                          type: 'success',
                          showConfirmButton: false,
                          timer: 1000
                        },
                        function(){
                          window.location='inicioSesion.html'
                        });
                    </script>
                ";
            }else{
                echo "Error al cerrar la sesión";
            }
        ?>
    </body>
</html>