<?php
require_once 'models/NoticiaModel.php';

// Definición de la función para obtener todas las noticias
function obtenerAllNoticias($orden) {
    // Crear una instancia del modelo de noticias
    $noticiaModel = new NoticiaModel();
    
    // Definir la cantidad de noticias por página y obtener la página actual
    $noticias_por_pagina = 5; // Por ejemplo, mostrar 10 noticias por página
    $pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1; // Obtener la página actual, 1 si no se especifica
    
    // Obtener las noticias para la página actual
    $noticias = $noticiaModel->obtenerNoticiasPaginadas($pagina_actual, $noticias_por_pagina, $orden);
    
    return $noticias;
}

// Definición de la función para obtener la cantidad de noticias
function obtenerCantidadNoticias() {
    // Crear una instancia del modelo de noticias
    $noticiaModel = new NoticiaModel();
    
    // Obtener la cantidad total de noticias
    $cantidad = $noticiaModel->contarNoticias();
    
    return $cantidad;
}
?>