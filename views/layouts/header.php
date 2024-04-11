<header>
    <div class="header-container">
        <div class="logo">
            <a href="/">
                <img src="views/img/logo-actual-news.png" alt="Logo">
            </a>
        </div>
        <div class="right-header">
            <nav>
                <ul>
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/noticias">Noticias</a></li>
                    <?php
                        if (isset($_SESSION['id_usuario'])) { 
                            // Obtener el ID del usuario actual
                            $id_usuario = $_SESSION['id_usuario'];
                        ?>
                            <li><a href="/crear-noticia">Crear noticia</a></li>
                            <li><a href="/noticias?autor=<?php echo $id_usuario; ?>">Mis noticias</a></li>
                    <?php } ?>
                </ul>
            </nav>
            <?php
                // Verificar si la sesión está iniciada
                if (isset($_SESSION["email"])) {
                    echo '<div class="usuario-iniciado">
                                        <p>Bienvenido, ' . $_SESSION["nombre"] . '</p>
                                        <span>|</span>
                                        <a href="controllers/user/logout.php">Cerrar sesión</a>
                          </div>';
                } else {
                    echo '<form class="login-form" action="controllers/user/login.php" method="POST">
                                <div class="input-div">
                                    <input type="text" name="email" placeholder="Email" class="input input-alt">
                                    <span class="input-border input-border-alt"></span>
                                </div>
                                <div class="input-div">
                                    <input type="password" name="contrasena" placeholder="Contraseña" class="input input-alt">
                                    <span class="input-border input-border-alt"></span>
                                </div>
                                <button class="login-btn" type="submit" name="login_btn">Login</button>
                                <a class="register-btn" href="registrarse">Registrarse</a>
                            </form>';
                }
            ?>
        </div>
    </div>
</header>