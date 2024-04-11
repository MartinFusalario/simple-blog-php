<?php
// Incluir el archivo del controlador
require_once __DIR__ . '/../controllers/news/get_news_by_id.php';

// Obtener el ID de la noticia (suponiendo que se pasa como parámetro GET)
$id_noticia = isset($_GET['id']) ? intval($_GET['id']) : 0; // Convertir a entero para mayor seguridad

if ($id_noticia > 0) {
    // Obtener todas las noticias del controlador
    $noticia = obtenerNoticiaPorID($id_noticia);
    
    $max_longitud_titulo = 40; // Número máximo de caracteres para el título

    // Obtener el título de la noticia
    $titulo = $noticia['titulo'];

    // Verificar la longitud del título y cortarlo si es necesario
    if (strlen($titulo) > $max_longitud_titulo) {
        $titulo = substr($titulo, 0, $max_longitud_titulo) . '...'; // Agregar puntos suspensivos al final del título cortado
    }
    
    // Incluir el archivo de diseño HTML con el título formateado
    include 'layouts/head-html.php';
} else {
    // Si no existe el ID de la noticia, redirigir a la página de error 404
    header("Location: /404");
}
?>
<main>
    <div class="noticia">
    <h2><?php echo $noticia['titulo']; ?></h2>
    <div class="noticia-cuerpo-box">
        <?php 
            echo $cuerpo = $noticia['cuerpo'];
        ?> 
    </div>
    <div class="info"> 
        <div>
            <span class="bold">Publicada el:</span>
            <?php echo $noticia['fecha']; ?>
            | 
            <span class="bold">Autor: </span>
            <a class="autor-link" href="noticias?autor=<?php echo $noticia['id_autor']; ?>"><?php echo $noticia['nombre_autor']; ?></a>
        </div>
        <div class="action-buttons">
            <?php if(isset($_SESSION['id_usuario'])) { ?>
                <div class="action-buttons">
                    <?php 
                        // Verificar si el usuario actual es el autor de la noticia
                        if ($noticia['id_autor'] == $_SESSION['id_usuario']) {
                            // Construir la URL del formulario de edición
                            $url_editar = "editar-noticia?id=" . $noticia['id'];
                            // Mostrar los botones solo para el autor
                            echo '<a class="editar" href="' . $url_editar . '">Editar</a>';
                            echo '<a class="eliminar" data-id="' . $noticia['id'] . '" href="#">Eliminar</a>';
                        }
                    ?>
                </div>
            <?php } ?>
            <?php 
                // Botón volver atrás
                echo '<a class="btn" href="javascript:history.back()">Volver atrás</a>';
            ?>
        </div>
    </div>
</div>
</main>
<?php include 'layouts/footer.php'; ?>
