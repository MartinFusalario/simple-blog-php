<?php

include_once '../../models/NoticiaModel.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['email'])) {
    $_SESSION['error_message'] = "Debes iniciar sesión para crear noticias";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Crear una instancia del modelo de noticias
$noticiaModel = new NoticiaModel();

// Acción para crear una noticia
if(isset($_POST['crear_noticia'])) {
    $idUsuario = $_SESSION['id_usuario'];
    $titulo = $_POST['titulo'];
    $cuerpo = $_POST['noticia'];
    $fecha = $_POST['fecha'];

    // Guardamos en cookies los datos del formulario
    setcookie('titulo', $titulo, time() + 3600, '/');
    setcookie('cuerpo', $cuerpo, time() + 3600, '/');
    setcookie('fecha', $fecha, time() + 3600, '/');

    if (empty($titulo) || empty($cuerpo) || empty($fecha)) {
        $_SESSION['error_message'] = "Debes completar todos los campos";
        header("Location: /crear-noticia");
        exit();
    }

    if (strlen($titulo) <=10 ) {
        $_SESSION['error_message'] = "El título de la noticia debe tener al menos 10 caracteres";
        header("Location: /crear-noticia");
        exit();
    }

    if (strlen($cuerpo) <= 50) {
        $_SESSION['error_message'] = "El cuerpo de la noticia debe tener al menos 50 caracteres";
        header("Location: /crear-noticia");
        exit();
    }


    $exito = $noticiaModel->crearNoticia($idUsuario, $titulo, $cuerpo, $fecha);
    if ($exito) {
        $_SESSION['message'] = "Noticia creada correctamente";
        header("Location: /");

        // Eliminamos las cookies
        setcookie('titulo', '', time() - 3600, '/');
        setcookie('cuerpo', '', time() - 3600, '/');
        setcookie('fecha', '', time() - 3600, '/');
        
        exit();
    } else {
        $_SESSION['error_message'] = "Error al crear la noticia";
        header("Location: /crear-noticia");
        exit();
    }
}
?>