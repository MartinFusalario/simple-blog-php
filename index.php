<?php
// Incluye el archivo de configuración
require_once 'config/datos_conexion.php';

// Incluye el archivo del router
require_once 'router/router.php';

// Obtiene la URL de la petición
$url = isset($_GET['url']) ? $_GET['url'] : '';

// Llama a la función router y pasa la URL
router($url);






