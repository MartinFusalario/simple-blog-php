<?php
require_once  'models/NoticiaModel.php';

function obtenerNoticiasPorAutor($id_autor, $orden) {
    // Crear una instancia del modelo de noticias
    $noticiaModel = new NoticiaModel();
    
    // Definir la cantidad de noticias por página y obtener la página actual
    $noticias_por_pagina = 5;
    $pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1; // Obtener la página actual, 1 si no se especifica
    
    // Obtener las noticias para la página actual
    $noticias = $noticiaModel->obtenerNoticiasPorAutor($id_autor, $pagina_actual, $noticias_por_pagina, $orden);
    
    return $noticias;
}

function obtenerCantidadNoticiasPorAutor($id_autor) {
    // Crear una instancia del modelo de noticias
    $noticiaModel = new NoticiaModel();
    
    // Obtener la cantidad de noticias por autor
    $cantidad = $noticiaModel->obtenerCantidadNoticiasPorAutor($id_autor);
    
    return $cantidad;
}

function obtenerNombreAutor($id_autor) {
    // Crear una instancia del modelo de noticias
    $noticiaModel = new NoticiaModel();
    
    // Obtener el nombre del autor
    $nombre_autor = $noticiaModel->obtenerNombreAutor($id_autor);
    
    return $nombre_autor;
}
?>