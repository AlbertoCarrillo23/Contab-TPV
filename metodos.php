<?php
include 'conexion.php';
    class metodos {
        public $mysqli;
        public $resultado;

        function __construct(){/*Método que establece la conexión a la base de datos crea el objeto mysqli*/
            $this->mysqli= new mysqli(servidor,usuario,password,basedatos);
        }

        function numeroError(){/*Método para el número de error*/
            return $this->mysqli->errno;
        }

        function realizarConsultas($sql){/*Método que ejecuta las consultas*/
            $this->resultado=$this->mysqli->query($sql);
        }

        function comprobarSelect(){/*Método que comprueba la ejecución de la consulta*/
            return $this->resultado->num_rows;
        }

        function comprobar(){/*Método que comprueba las filas afectadas*/
            return $this->mysqli->affected_rows;
        }

        function extraerFilas(){/*Método que extrae filas de la bbd*/
            return $this->resultado->fetch_array();
        }

        function encriptar($password){/*Método que encripta la contraseña*/
            return password_hash("$password", PASSWORD_DEFAULT);
        }

        function verificar($password, $hash){/*Método que verifica la encriptación de contraseña*/
            return password_verify("$password", $hash);
        }

        function cerrarConexion(){/*Método que cierra la conexion*/
            $this->mysqli->close();
        }
    }
?>

<!--ha mostrado esto-->