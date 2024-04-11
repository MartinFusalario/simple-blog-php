<?php

class ConexionDB {
    private static $conexion;

    public static function obtenerConexion() {
        if (!self::$conexion) {
            include_once(__DIR__ . '/../config/datos_conexion.php');

            try {
                self::$conexion = new mysqli(HOST, USER, PASSWORD, DATABASE);
                if (self::$conexion->connect_error) {
                    throw new Exception("Error de conexión: " . self::$conexion->connect_error);
                }
                // Establecer el conjunto de caracteres utf8mb4
                self::$conexion->set_charset("utf8mb4");
            } catch (Exception $e) {
                // Manejo de la excepción
                error_log("Error de conexión: " . $e->getMessage(), 3, "/ruta/a/tu/archivo_de_log.log");
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }

    // Método para cerrar la conexión por si necesitamos hacerlo explícitamente (aunque no es necesario en la mayoría de los casos ya que PHP lo hace automáticamente al finalizar el script)
    public static function cerrarConexion() {
        if (self::$conexion) {
            self::$conexion->close();
        }
    }
}

?>