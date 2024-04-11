<?php
    require_once __DIR__ . '/../controllers/news/get_all_news.php';
    require_once __DIR__ . '/../controllers/news/get_news_by_author.php';

    // Obtener el ID del autor si se proporciona en la URL
    $id_autor = isset($_GET['autor']) ? intval($_GET['autor']) : 0;
    $orden = isset($_GET['orden']) ? $_GET['orden'] : 'fecha_desc';

    // Función para verificar si una opción debe estar seleccionada
    function isSelected($valor_actual, $valor_seleccionado) {
        return $valor_actual === $valor_seleccionado ? 'selected' : '';
    }


    if ($id_autor > 0) {
        // Si se proporciona un ID de autor, obtener el nombre del autor y las noticias del autor por orden específico
        $nombre_autor = obtenerNombreAutor($id_autor);
        $noticias = obtenerNoticiasPorAutor($id_autor, $orden);
    } else {
        $noticias = obtenerAllNoticias($orden);
    }

    // Título de la página
    $titulo = "Noticias | Tu web de noticias de actualidad";
    include 'layouts/head-html.php';

?>
<main>
    <div class="top-page">
        <?php if ($id_autor > 0) { ?>
            <h1>Noticias de <?php echo $nombre_autor; ?></h1>
        <?php } else { ?>
            <h1>Noticias sobre Gaming y Software</h1>
        <?php } ?>
        <!-- Selector de orden -->
        <form id="ordenar-noticias" action="" method="GET">
            <label for="orden">Ordenar por:</label>
            <select name="orden" id="orden">
                <option value="fecha_desc" <?php echo isSelected('fecha_desc', $orden); ?>>Más recientes primero</option>
                <option value="fecha_asc" <?php echo isSelected('fecha_asc', $orden); ?>>Más antiguas primero</option>
                <option value="titulo_asc" <?php echo isSelected('titulo_asc', $orden); ?>>Título A-Z</option>
                <option value="titulo_desc" <?php echo isSelected('titulo_desc', $orden); ?>>Título Z-A</option>
                <option value="autor_asc" <?php echo isSelected('autor_asc', $orden); ?>>Autor A-Z</option>
                <option value="autor_desc" <?php echo isSelected('autor_desc', $orden); ?>>Autor Z-A</option>
            </select>
            <?php
                // Verificar si el parámetro 'autor' está presente en la URL
                $autor = isset($_GET['autor']) ? $_GET['autor'] : '';

                // Agregar el campo oculto solo si el parámetro 'autor' está presente
                if (!empty($autor)) {
                    echo '<input type="hidden" name="autor" value="' . htmlspecialchars($autor) . '">';
                }
            ?>
        </form>
    </div>
    <div class="noticias">
        <?php if (empty($noticias)) { ?>
            <p>No se encontraron noticias.</p>
        <?php } ?>
        <?php foreach ($noticias as $noticia) { ?>
            <?php include 'layouts/noticia-box.php'; ?>
        <?php } ?>
    </div>
    
        
    <div <?php if (!isset($_SESSION['id_usuario'])) { 
        echo 'class=""';
    } else {
        echo 'class="footer-news"';
    }
    ?>>
        <?php if(isset($_SESSION['id_usuario'])) { ?>
            <div>
                <a class="btn" href="crear-noticia">Crear noticia</a>
            </div>
        <?php } ?>
        <!-- Paginación -->
        <div class="pagination">
            <?php
                require_once __DIR__ . '/../controllers/news/get_all_news.php';
                require_once __DIR__ . '/../controllers/news/get_news_by_author.php';

                // Obtener el ID del autor si se proporciona
                $id_autor = isset($_GET['autor']) ? intval($_GET['autor']) : 0;

                if ($id_autor > 0) {
                    $noticias = obtenerCantidadNoticiasPorAutor($id_autor);
                } else {
                    $noticias = obtenerCantidadNoticias();
                }
                

                $total_paginas = ceil($noticias / 5);

                // Obtener el número de página actual
                $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                // Mostrar enlaces de paginación
                // Obtener la URL actual y eliminar el parámetro 'pagina' si existe
                $current_url = strtok($_SERVER["REQUEST_URI"], '?');

                // Construir la URL base con los parámetros actuales
                $base_url = $current_url . '?';

                // Obtener los parámetros de la URL actual
                $params = $_GET;

                // Eliminar el parámetro 'pagina' si existe para que no se duplique en la paginación
                unset($params['pagina']);

                // Construir la URL completa con los parámetros actuales y agregar 'pagina' en cada enlace de paginación
                for ($i = 1; $i <= $total_paginas; $i++) {
                    // Agregar 'pagina' al array de parámetros
                    $params['pagina'] = $i;

                    // Construir la URL completa con los parámetros actualizados
                    $url = $base_url . http_build_query($params);

                    // Agregar una clase diferente para resaltar la página actual
                    $clase_btn = ($i == $pagina_actual) ? 'page-btn active' : 'page-btn';
                    echo '<a class="' . $clase_btn . '" href="' . $url . '">' . $i . '</a>';
                }
            ?>
        </div>
    </div>
</main>
<script>
    // Enviar el formulario al cambiar la opción de orden
    document.getElementById('orden').addEventListener('change', function() {
        document.getElementById('ordenar-noticias').submit();
    });
</script>
<?php include 'layouts/footer.php'; ?>
