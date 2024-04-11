<?php

include_once '../../models/NoticiaModel.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['error_message'] = "Debes iniciar sesión para poder editar noticias";
    header("Location: /login.php");
    exit();
}

// Crear una instancia del modelo de noticias
$noticiaModel = new NoticiaModel($conexion);

// Acción para actualizar una noticia
if(isset($_POST['actualizar_noticia'])) {
    $idNoticia = $_POST['id_noticia'];
    $idUsuario = $_SESSION['id_usuario'];
    $titulo = $_POST['titulo'];
    $cuerpo = $_POST['noticia'];
    $fecha = $_POST['fecha'];

    if (empty($titulo) || empty($cuerpo) || empty($fecha)) {
        $_SESSION['error_message'] = "No puedes dejar campos vacíos";
        header("Location: /editar-noticia?id=$idNoticia");
        exit();
    }

    // Verificar si la noticia pertenece al usuario actual
    $noticia = $noticiaModel->obtenerNoticiaPorId($idNoticia);
    if ($noticia && $noticia['id_autor'] == $idUsuario) {
        $exito = $noticiaModel->actualizarNoticia($idNoticia, $titulo, $cuerpo, $fecha);
        if ($exito) {
            $_SESSION['message'] = "Noticia actualizada correctamente";
            header("Location: /noticia?id=$idNoticia");
            exit();
        } else {
            $_SESSION['error_message'] = "Error al actualizar la noticia";
            header("Location: /editar-noticia.php?id=$idNoticia");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "No tienes permiso para editar esa noticia";
        header("Location: /");
        exit();
    }
}
?>