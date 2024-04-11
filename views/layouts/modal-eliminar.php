<div id="modal-eliminar" class="modal">
  <div class="modal-content">
    <span id="close">&times;</span>
    <h2>Eliminar noticia</h2>
    <hr>
    <p>¿Estás seguro de que deseas eliminar esta noticia? <span>Es una acción irrecuperable.</span></p>
    <div class="modal-buttons">
      <form id="form-eliminar"action="controllers/news/delete_news.php" method="POST">
        <!-- Campo oculto para pasar el id_noticia al formulario y eliminar la noticia correspondiente por el ID seleccionado -->
        <input type="hidden" name="id_noticia" value="<?php echo $noticia['id']; ?>">
        <button class="confirmar-eliminar" type="submit" name="confirmar_eliminar">Sí, eliminar</button>
        <button id="btn-cancelar-eliminar" type="button">Cancelar</button>
      </form>
    </div>
  </div>
</div>