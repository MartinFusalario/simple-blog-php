<?php
include_once '../../models/NoticiaModel.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['error_message'] = "Debes iniciar sesión para poder eliminar noticias";
    header("Location: /");
    exit();
}


// Crear una instancia del modelo de noticias
$noticiaModel = new NoticiaModel();


// Acción para eliminar una noticia
if(isset($_POST['confirmar_eliminar'])) {
    $idNoticia = $_POST['id_noticia'];
    $idUsuario = $_SESSION['id_usuario'];

    if (!$idNoticia) {
        $_SESSION['error_message'] = "No se proporcionó una ID de noticia para eliminar";
        header("Location: /");
        exit();
    }

    // Verificar si la noticia pertenece al usuario actual
    $noticia = $noticiaModel->obtenerNoticiaPorId($idNoticia);
    if ($noticia && $noticia['id_autor'] == $idUsuario) {
        $exito = $noticiaModel->eliminarNoticia($idNoticia);
        if ($exito) {
            $_SESSION['message'] = "Noticia eliminada correctamente";
            header("Location: /");
            exit();
        } else {
            $_SESSION['error_message'] = "Error al eliminar la noticia";
            header("Location: /");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "No tienes permiso para eliminar esta noticia";
        header("Location: /");
        exit();
    }
}


?>