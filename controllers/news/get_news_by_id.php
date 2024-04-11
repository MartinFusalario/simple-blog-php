<?php
require_once 'models/NoticiaModel.php';

function obtenerNoticiaPorID($id_noticia) {
    // Crear una instancia del modelo de noticias
    $noticiaModel = new NoticiaModel();
    
    // Obtener la noticia por su ID
    $noticia = $noticiaModel->obtenerNoticiaPorId($id_noticia);

    if (!$noticia) {
        // Si no se encuentra la noticia, redirigir a la página de error 404
        header("Location: /404");
        exit;
    }
    
    return $noticia;
}

?>