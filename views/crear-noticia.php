<?php
    session_start();
    // Si el usuario no ha iniciado sesión, redirige a la página de inicio
    if(!isset($_SESSION['email'])){
        $_SESSION['error_message'] = "Debes iniciar sesión para crear nuevas noticias";
        header('Location: /');
        exit(0);
    }

    // Cargamos las cookies con los datos del formulario por si el usuario recarga la página o hay un error en el envío o validación de datos
    $titulo_noticia = isset($_COOKIE['titulo']) ? $_COOKIE['titulo'] : '';
    $cuerpo = isset($_COOKIE['cuerpo']) ? $_COOKIE['cuerpo'] : '';
    $fecha = isset($_COOKIE['fecha']) ? $_COOKIE['fecha'] : '';
    


    // Título de la página para el head
    $titulo = "Nueva Noticia | Actual News";
    // Incluir el archivo de diseño HTML con el título formateado
    include 'layouts/head-html.php';
?>

<main>
    <div class="page">
        <h1>Crear nueva noticia</h1>
        <form class="form-noticias" action="controllers/news/create_news.php" method="POST">
            <div>
                <input class="input-noticias" type="text" id="titulo" name="titulo" required placeholder="Título" value="<?php echo $titulo_noticia; ?>">
            </div>
            <div>
                <textarea class="input-noticias" id="editor" name="noticia" required placeholder="Escribe la noticia">
                    <?php echo $cuerpo; ?>
                </textarea>
            </div>
            <div class="fecha-publicacion">
                <label for="fecha">Fecha de publicación:</label>
                <input type="date" id="datePickerId" name="fecha" value="<?php echo $fecha; ?>">
            </div>
            <div>
                <button type="submit" name="crear_noticia">Postear</button>
            </div>
        </form>
    </div>
</main>
<?php
    include 'layouts/footer.php';
?>

<script src="tinymce/tinymce.min.js"></script>
<script>
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