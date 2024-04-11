<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include(__DIR__ . '/../models/ConexionDB.php');

class NoticiaModel {
    private $conexion;

    // Constructor
    public function __construct() {
        $this->conexion = ConexionDB::obtenerConexion();
    }

    // Función para crear una nueva noticia
    public function crearNoticia($idUsuario, $titulo, $cuerpo, $fecha) {
        try {
            $titulo = mysqli_real_escape_string($this->conexion, $titulo);
            $cuerpo = mysqli_real_escape_string($this->conexion, $cuerpo);

            $query = "INSERT INTO noticia (id_autor, titulo, cuerpo, fecha) VALUES ('$idUsuario','$titulo', '$cuerpo', '$fecha')";
            return mysqli_query($this->conexion, $query);
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al crear la noticia: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al crear la noticia";
            return false;
        }
    }

    // Función para obtener todas las noticias con paginación y en orden descendente
    public function obtenerNoticiasPaginadas($pagina, $noticias_por_pagina, $orden) {
        try {
            // Calcular el desplazamiento para la consulta SQL
            $offset = ($pagina - 1) * $noticias_por_pagina;

            $orden_sql = "n.fecha DESC"; // Orden por defecto

            // Verificar el tipo de orden recibido y ajustar la consulta SQL en consecuencia
            switch ($orden) {
                case 'fecha_asc':
                    $orden_sql = "n.fecha ASC";
                    break;
                case 'fecha_desc':
                    $orden_sql = "n.fecha DESC";
                    break;
                case 'titulo_asc':
                    $orden_sql = "n.titulo ASC";
                    break;
                case 'titulo_desc':
                    $orden_sql = "n.titulo DESC";
                    break;
                case 'autor_asc':
                    $orden_sql = "u.nombre ASC";
                    break;
                case 'autor_desc':
                    $orden_sql = "u.nombre DESC";
                    break;
                default:
                    $orden_sql = "n.fecha DESC"; // Por defecto, orden por fecha DESC
                    break;
            }

            // Construir la consulta SQL con el orden especificado
            $query = "SELECT n.*, u.nombre AS nombre_autor 
                    FROM noticia n 
                    INNER JOIN usuario u ON n.id_autor = u.id
                    ORDER BY $orden_sql
                    LIMIT $noticias_por_pagina OFFSET $offset";

            // Ejecutar la consulta
            $resultados = mysqli_query($this->conexion, $query);

            // Verificar si hay resultados
            if ($resultados) {
                $noticias = array();
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    $noticias[] = $fila;
                }
                return $noticias;
            } else {
                // Si no hay resultados, devolver un array vacío
                return array();
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al obtener noticias paginadas: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al obtener noticias paginadas";
            return false;
        }
    }

    // Función para obtener todas las noticias de un autor en orden descendente por ID de noticias
    public function obtenerNoticiasPorAutor($id_autor, $pagina_actual, $noticias_por_pagina, $orden) {
        try {
            // Establecer la conexión a la base de datos
            $conexion = ConexionDB::obtenerConexion();

            // Escapar el ID del autor para evitar inyección SQL
            $id_autor = mysqli_real_escape_string($conexion, $id_autor);

            // Calcular el índice del primer registro para la página actual
            $indice_inicio = ($pagina_actual - 1) * $noticias_por_pagina;

            $orden_sql = "n.fecha DESC";  // Orden por defecto

            // Verificar el tipo de orden recibido y ajustar la consulta SQL en consecuencia
            switch ($orden) {
                case 'fecha_asc':
                    $orden_sql = "n.fecha ASC";
                    break;
                case 'fecha_desc':
                    $orden_sql = "n.fecha DESC";
                    break;
                case 'titulo_asc':
                    $orden_sql = "n.titulo ASC";
                    break;
                case 'titulo_desc':
                    $orden_sql = "n.titulo DESC";
                    break;
                case 'autor_asc':
                    $orden_sql = "u.nombre ASC";
                    break;
                case 'autor_desc':
                    $orden_sql = "u.nombre DESC";
                    break;
                default:
                    $orden_sql = "n.fecha DESC"; // Por defecto, orden por fecha DESC
                    break;
            }

            // Consulta SQL para obtener las noticias del autor paginadas y ordenadas
            $query = "SELECT n.*, u.nombre AS nombre_autor 
                FROM noticia n 
                INNER JOIN usuario u ON n.id_autor = u.id 
                WHERE n.id_autor = '$id_autor' 
                ORDER BY $orden_sql 
                LIMIT $indice_inicio, $noticias_por_pagina";

            // Ejecutar la consulta
            $resultados = mysqli_query($conexion, $query);

            // Verificar si se encontraron noticias
            if ($resultados) {
                // Array para almacenar las noticias
                $noticias = array();

                // Recorrer los resultados y almacenar las noticias en el array
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    $noticias[] = $fila;
                }

                // Devolver el array de noticias
                return $noticias;
            } else {
                // Si no se encontraron noticias, devolver un array vacío
                return array();
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al obtener noticias por autor: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al obtener noticias por autor";
            return false;
        }
    }
// Función para obtener la cantidad de noticias de un autor (para la paginación)
    public function obtenerCantidadNoticiasPorAutor($id_autor) {
        try {
            // Establecer la conexión a la base de datos
            $conexion = ConexionDB::obtenerConexion();

            // Escapar el ID del autor para evitar inyección SQL
            $id_autor = mysqli_real_escape_string($conexion, $id_autor);

            // Consulta SQL para obtener la cantidad de noticias del autor
            $query = "SELECT COUNT(*) AS total FROM noticia WHERE id_autor = '$id_autor'";

            // Ejecutar la consulta
            $resultado = mysqli_query($conexion, $query);

            // Verificar si se encontró la cantidad de noticias
            if ($resultado) {
                // Obtener la fila con el total de noticias
                $fila = mysqli_fetch_assoc($resultado);

                // Devolver el total de noticias
                return $fila['total'];
            } else {
                // Si la consulta falla, devolver 0
                return 0;
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al obtener cantidad de noticias por autor: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al obtener cantidad de noticias por autor";
            return false;
        }
    }

    // Función para contar el número total de noticias (para la paginación)
    public function contarNoticias() {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $query = "SELECT COUNT(*) AS total FROM noticia";
            $resultado = mysqli_query($conexion, $query);

            if ($resultado) {
                $fila = mysqli_fetch_assoc($resultado);
                return $fila['total'];
            } else {
                // Si la consulta falla, devolver 0
                return 0;
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            echo "Error al contar noticias: " . $e->getMessage();
            error_log("Error al contar noticias: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al contar noticias";
            return false;
        }
    }

    // Función para obtener el nombre del autor de una noticia
    public function obtenerNombreAutor($id_autor) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $id_autor = mysqli_real_escape_string($this->conexion, $id_autor);
            $query = "SELECT nombre FROM usuario WHERE id='$id_autor'";
            $resultado = mysqli_query($this->conexion, $query);
            $fila = mysqli_fetch_assoc($resultado);
            return $fila['nombre'];
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al obtener nombre del autor: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al obtener nombre del autor";
            return false;
        }
    }

    // Función para obtener una noticia por su ID
    public function obtenerNoticiaPorId($id) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $id = mysqli_real_escape_string($this->conexion, $id);
            $query = "SELECT noticia.*, usuario.nombre AS nombre_autor 
                    FROM noticia 
                    JOIN usuario ON noticia.id_autor = usuario.id 
                    WHERE noticia.id = '$id'";
            $resultado = mysqli_query($this->conexion, $query);
            return mysqli_fetch_assoc($resultado);
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al obtener noticia por ID: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al obtener noticia por ID";
            return false;
        }
    }

    // Función para actualizar una noticia
    public function actualizarNoticia($id, $titulo, $cuerpo, $fecha) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $id = mysqli_real_escape_string($this->conexion, $id);
            $titulo = mysqli_real_escape_string($this->conexion, $titulo);
            $cuerpo = mysqli_real_escape_string($this->conexion, $cuerpo);

            $query = "UPDATE noticia SET titulo='$titulo', cuerpo='$cuerpo', fecha='$fecha' WHERE id='$id'";
            return mysqli_query($this->conexion, $query);
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al actualizar noticia: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al actualizar noticia";
            return false;
        }
    }

    // Función para eliminar una noticia
    public function eliminarNoticia($id) {
        try {
            $conexion = ConexionDB::obtenerConexion();

            $id = mysqli_real_escape_string($this->conexion, $id);
            $query = "DELETE FROM noticia WHERE id='$id'";
            return mysqli_query($this->conexion, $query);
        } catch (Exception $e) {
            // Manejo de excepciones
            error_log("Error al eliminar noticia: " . $e->getMessage(), 3, "logs/error.log");
            $_SESSION['error_message'] = "Error al eliminar noticia";
            return false;
        }
    }
}
?>