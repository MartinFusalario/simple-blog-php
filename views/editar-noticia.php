<?php
    require_once 'controllers/news/get_news_by_id.php';

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['id_usuario'])) {
        $_SESSION['error_message'] = "Debes iniciar sesión para editar noticias";
        header('Location: /'); // Redirigir al usuario a la página de inicio de sesión
        exit();
    }

    // Obtener el ID de la noticia a editar
    $id_noticia = isset($_GET['id']) ? intval($_GET['id']) : 0; // Convertir a entero para mayor seguridad

    // Verificar si se proporcionó un ID de noticia para editar
    if (!$id_noticia) {
        $_SESSION['error_message'] = "No se proporcionó una ID de noticia para editar";
        header('Location: /'); // Redirigir al usuario a la página de inicio
        exit();
    }

    // Obtener la noticia por su ID
    $noticia = obtenerNoticiaPorID($id_noticia);

    // Verificar si se encontró la noticia y si el usuario actual es el autor de la noticia
    if (!$noticia || $noticia['id_autor'] != $_SESSION['id_usuario']) {
        $_SESSION['error_message'] = "No tienes permiso para editar esta noticia";
        header('Location: /'); // Redirigir al usuario a la página de inicio
        exit();
    }



    // Título de la página
    $titulo_pagina = "Editar Noticia | Actual News";
    include 'layouts/head-html.php';
?>

<main>
    <div class="page">
        <h1>Editar noticia</h1>
        <?php
            $titulo = $noticia['titulo'];
            echo '<p class="editar-titulo">' . $titulo . '</p>';
        ?>
        <form class="form-noticias" action="controllers/news/patch_news.php" method="POST">
            <!-- Campo oculto para pasar el id_noticia al formulario -->
            <input type="hidden" name="id_noticia" value="<?php echo $noticia['id'] ?>">
            <div>
                <input class="input-noticias" type="text" id="titulo" name="titulo" required placeholder="Título" value="<?php echo $noticia['titulo']; ?>">
            </div>
            <div>
                <textarea class="input-noticias" id="editor" name="noticia" required placeholder="Escribe la noticia"><?php echo $noticia['cuerpo']; ?></textarea>
            </div>
            <div class="fecha-publicacion">
                <label for="fecha">Fecha de publicación:</label>
                <input type="date" id="datePickerId" name="fecha" value="<?php echo $noticia['fecha'] ?>">
            </div>
            <div class="action-buttons">
                <button type="submit" name="actualizar_noticia">Guardar Cambios</button>
                <a class="cancelar" href="/">Cancelar</a>
            </div>
        </form>
    </div>
</main>

<?php
include 'layouts/footer.php';
?>

<script src="tinymce/tinymce.min.js"></script>
<script>
    // Inicializar el editor de texto enriquecido TinyMCE WYSIWYG
    tinymce.init({
        selector: '#editor',
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
        toolbar_mode: 'floating',
    });

    // Obtener el elemento del selector de fecha
    const datePickerId = document.getElementById('datePickerId');
    datePickerId.max = new Date().toISOString().split("T")[0];
</script>