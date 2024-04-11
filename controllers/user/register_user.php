<?php
include_once '../../models/UsuarioModel.php';

if(isset($_POST['register_btn'])){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Guardamos en cookies los datos del formulario
    setcookie('nombre', $nombre, time() + 3600, '/');
    setcookie('email', $email, time() + 3600, '/');

    if (empty($nombre) || empty($email) || empty($contrasena)) {
        $_SESSION['error_message'] = "Debes completar todos los campos.";
        header('Location: /registrarse');
        exit(0);
    }

    if (strlen($nombre) < 3) {
        $_SESSION['error_message'] = "El nombre debe tener al menos 3 caracteres";
        header('Location: /registrarse');
        exit(0);
    }

    $usuarioModel = new UsuarioModel();

    // Verificar si el email ya está registrado
    $usuarioExistente = $usuarioModel->obtenerUsuarioPorEmail($email);
    if ($usuarioExistente) {
        $_SESSION['error_message'] = "El email introducido ya está en uso";

        // Eliminamos las cookies del email
        setcookie('email', '', time() - 3600, '/');

        header('Location: /registrarse');
        exit(0);
    }
    $registroExitoso = $usuarioModel->registrarUsuario($nombre, $email, $contrasena);

    if ($registroExitoso) {
        $_SESSION['message'] = "Usuario registrado correctamente";

        // Eliminamos las cookies
        setcookie('nombre', '', time() - 3600, '/');
        setcookie('email', '', time() - 3600, '/');
        
        // Redirigimos al usuario a la página principal
        header('Location: /');
    } else {
        header('Location: /registrarse');
    }
} else {
    header('Location: /');
}
exit(0);
?>
