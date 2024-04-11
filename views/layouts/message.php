<?php
    if(isset($_SESSION['message']) || isset($_SESSION['error_message'])) {
        ?>
        <div id="notification" class="<?php echo isset($_SESSION['message']) ? 'message' : 'error-message'; ?>">
            <?php echo isset($_SESSION['message']) ? $_SESSION['message'] : $_SESSION['error_message']; ?>
        </div>
        <?php
            unset($_SESSION['message']);
            unset($_SESSION['error_message']);
        ?>
        <script>
            // Cerrar la notificación después de 4 segundos (4000 milisegundos)
            setTimeout(function() {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.style.display = 'none';
                }
            }, 4000);
        </script>
        <?php
    }
?>