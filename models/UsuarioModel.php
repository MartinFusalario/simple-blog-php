<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include(__DIR__ . '/../models/ConexionDB.php');

class UsuarioModel {

    private $conexion;

    // Constructor
    public function __construct() {
        $this->conexion = ConexionDB::obtenerConexion();
    }

    public function registrarUsuario($nombre, $email, $contrasena) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $nombre = mysqli_real_escape_string($conexion, $nombre);
            $email = mysqli_real_escape_string($conexion, $email);
            $contrasena = mysqli_real_escape_string($conexion, $contrasena);

            $check_email = "SELECT * FROM usuario WHERE email = '$email'";
            $check_email_result = mysqli_query($conexion, $check_email);

            if(mysqli_num_rows($check_email_result) > 0){
                throw new Exception("El email introducido ya está en uso");
            } else {
                $user_query = "INSERT INTO usuario (nombre, email, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
                $user_query_run = mysqli_query($conexion, $user_query);

                if($user_query_run){
                    $_SESSION['message'] = "Usuario registrado correctamente";
                    return true;
                } else {
                    throw new Exception("Error al registrar el usuario");
                }
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al registrar usuario: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public function iniciarSesion($email, $contrasena) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $email = mysqli_real_escape_string($conexion, $email);
            $contrasena = mysqli_real_escape_string($conexion, $contrasena);

            $query = "SELECT * FROM usuario WHERE email='$email' AND contrasena='$contrasena'";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_assoc($resultado);
                $_SESSION['id_usuario'] = $fila['id'];
                $_SESSION['email'] = $email;
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['message'] = "Usuario autenticado correctamente || Bienvenido, " . $_SESSION['nombre'];
                return true; // Credenciales correctas
            } else {
                throw new Exception("Credenciales incorrectas");
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al iniciar sesión: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public function obtenerUsuarioPorEmail($email) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $email = mysqli_real_escape_string($conexion, $email);

            $query = "SELECT * FROM usuario WHERE email='$email'";
            $resultado = mysqli_query($conexion, $query);

            if (mysqli_num_rows($resultado) > 0) {
                return true; // Usuario encontrado
            } else {
                return false; // Usuario no encontrado
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al obtener usuario por email: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al obtener usuario por email";
            return false;
        }
    }
}
?>