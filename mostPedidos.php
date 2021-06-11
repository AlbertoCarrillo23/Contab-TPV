<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Carrillo Cervera">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <title>CONTAB-TPV - MOSTRAR PEDIDOS</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <h1>MOSTRAR PEDIDOS</h1>
        <nav>
            <ul class="row justify-content-center">
                <li class="col-3"><a href="addPedidos.php">Añadir</a></li>
                <div class="col-1"></div>
                <li class="col-3"><a href="comprobarInicio.php">Volver</a></li>
            </ul>
        </nav>
        <?php
            require_once 'metodos.php';
            session_start();
            $objConexion = new metodos();

            if(!isset($_POST["enviar"])) {
//                $consulta = "
//                    SELECT *
//                    FROM pedidos
//                    WHERE idUsuario=" . $_SESSION["idUsuario"] . " and idNegocio=" . $_POST["idNegocio"] . ";
//                ";
            echo '¡PRÓXIMAMENTE!';

            }else{
                echo 'hola';
                echo '<li class="col-3"><a href="comprobarInicio.php">Volver</a></li>
                    <div class="footer">
                        <footer class="row">
                            <div class="col-6 justify-content-center">
                                <div class="logopie"><img src="imagenes/logo.png" alt="Logo en pie de página"></div>
                            </div>
                            <div class="col-6">
                                <div class="col-12 textopie">
                                    <h4><a href="mailto:contabtpv@gmail.com?Subject=Interesado%en%la%APP">Contáctanos</a></h4>
                                    <p>
                                        C/Jovellanos, 37B</br>
                                        San Vicente de Alcántara, 06500</br>
                                        Badajoz,(Extremadura)</br>
                                        contabtpv@gmail.com</br>
                                        Tlf: 698741235
                                    </p>
                                </div>
                            </div>
                        </footer>
                    </div>
                ';
            }

        ?>
    </body>
</html>