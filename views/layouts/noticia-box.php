<div class="noticia-box">
    <h2><?php echo $noticia['titulo']; ?></h2>
    <div class="noticia-cuerpo-box">
        <?php 
            // Obtener el cuerpo de la noticia sin etiquetas HTML
            $cuerpo_sin_html = strip_tags($noticia['cuerpo']);

            // Limitar el texto del cuerpo a un número de palabras
            $palabras = explode(' ', $cuerpo_sin_html);
            $limite = 30; // Número de palabras límite
            $cuerpo_abreviado = implode(' ', array_slice($palabras, 0, $limite));
            echo '<p>' . $cuerpo_abreviado . '...</p>'; 
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

                            // Construir la URL para llevar al formulario de edición de la noticia por su ID
                            $url_editar = "editar-noticia?id=" . $noticia['id'];
                            // Mostrar los botones solo para el autor
                            echo '<a class="editar" href="' . $url_editar . '">Editar</a>';
                            echo '<a class="eliminar" data-id="' . $noticia['id'] . '" href="#">Eliminar</a>';
                        }
                    ?>
                </div>
            <?php } ?>
            <div>
                <a class="leer-mas" href="noticia?id=<?php echo $noticia['id']; ?>">Leer más</a>
            </div>
        </div>
    </div>
</div>