<?php
    session_start();
    // Si el usuario ya ha iniciado sesión, redirige a la página de inicio
    if(isset($_SESSION['email'])){
        $_SESSION['error_message'] = "Para registrar una nueva cuenta, primero debes cerrar sesión";
        header('Location: /');
        exit(0);
    }

    // Cargamos las cookies con los datos del formulario por si el usuario recarga la página o hay un error en el envío o validación de datos
    $nombre = isset($_COOKIE['nombre']) ? $_COOKIE['nombre'] : '';
    $email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';

    // Título de la página para el head
    $titulo = "Registrarse | Actual News";
    include 'layouts/head-html.php';
?>
<main>
    <div class="page">
        <h1>Registrarse</h1>
        <form class="form-register" action="controllers/user/register_user.php" method="POST">
            <div>
                <input class="input-register" type="text" id="nombre" name="nombre" required placeholder="Nombre" value="<?php echo $nombre; ?>">
            </div>
            <div>
                <input class="input-register" type="email" id="email" name="email" required placeholder="Email" value="<?php echo $email; ?>">
            </div>
            <div>
                <input class="input-register" type="password" id="contrasena" name="contrasena" required placeholder="Contraseña">
            </div>
            <div>
                <button type="submit" name="register_btn">Registrarse</button>
            </div>
        </form>
    </div>
</main>
<?php
    include 'layouts/footer.php';
?>