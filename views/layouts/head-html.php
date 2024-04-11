<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="icon" href="views/img/favicon.png" type="image/png">
    <script src="https://cdn.tiny.cloud/1/qe10jcaippcse7rnorvy9tqbuyla49wgr6wt1kv3azlucu0m/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <title><?php echo isset($titulo) ? $titulo . ' | ' . 'Actual News' : 'Actual News | Tu web de noticias de actualidad'; ?></title>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'message.php'; ?>
    <?php include 'modal-eliminar.php'; ?>