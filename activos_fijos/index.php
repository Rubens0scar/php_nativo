<?php
include 'rutas.php';
include_once("theme/function.php");

//session_start();
// Verificar si hay un mensaje en la sesión y mostrarlo
if (isset($_SESSION['mensaje'])) {
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['mensaje'] . "');
            location.reload(); // Recargar la página
          </script>";

    // Limpiar el mensaje de la sesión para que no se muestre en la siguiente carga de página
    unset($_SESSION['mensaje']);
}

if (isset($_COOKIE['mensaje'])) {
    echo "<script>alert('" . $_COOKIE['mensaje'] . "'); location.reload();</script>";
    setcookie("mensaje", "", time() - 3600, "/"); // Elimina la cookie
}

if (isset($_GET['ruta'])) {
    $codigo = $_GET['ruta'];
    $rutaDecodificada = decodificarCodigoSeguro($codigo);

    if (isset($rutas[$rutaDecodificada])) {
        include($rutas[$rutaDecodificada]);
    } else {
        echo "Ruta no válida o página no encontrada.";
    }
} else {
    include($rutas['']); // Página por defecto
}