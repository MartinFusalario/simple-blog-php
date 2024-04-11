<?php

function router($url) {
    // Si la URL está vacía o no se proporciona, redirige al archivo 'main.php'
    if(empty($url)) {
        include 'views/main.php';
    } else {
        // Analiza la URL y redirige según la ruta
        switch ($url) {
            case 'registrarse':
                include 'views/registrarse.php';
                break;
            case 'main':
                include 'views/main.php';
                break;
            case 'crear-noticia':
                include 'views/crear-noticia.php';
                break;
            case 'noticia':
                include 'views/noticia.php';
                break;
            case 'noticias':
                include 'views/noticias.php';
                break;
            case 'editar-noticia':
                include 'views/editar-noticia.php';
                break;
            default:
                // Si la ruta no coincide con ninguna de las anteriores, redirige a la página de error 404
                include 'views/404.php';
                break;
        }
    } 
}