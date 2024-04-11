<?php


if(isset($_POST['login_btn'])) {
    // Verifica si se han enviado los campos de email y contraseña
    if(!isset($_POST['email']) || !isset($_POST['contrasena'])) {
        // Si no se han enviado los campos, muestra un mensaje de error
        session_start();
        $_SESSION["error_message"] = "Por favor, introduce tu email y contraseña";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    include_once '../../models/UsuarioModel.php';

    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    if (empty($email)) {
        session_start();
        $_SESSION['error_message'] = "El email es obligatorio para iniciar sesión";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if (empty($contrasena)) {
        session_start();
        $_SESSION['error_message'] = "La contraseña es obligatoria para iniciar sesión";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $usuarioModel = new UsuarioModel();
    $autenticado = $usuarioModel->iniciarSesion($email, $contrasena);

    if ($autenticado) {
        // Si las credenciales son correctas, redirige al usuario a la página principal
        header("Location: /");
        exit();
    } else {
        // Si las credenciales son incorrectas, muestra un mensaje de error y se queda en la misma página
        session_start();
        $_SESSION['error_message'] = "El correo electrónico o la contraseña proporcionados son incorrectos";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

}

?>