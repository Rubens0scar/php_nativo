<?php
include_once("clases/conexion.php");
include_once("../theme/function.php");

if ($_POST['usuario'] && $_POST['anterior_password'] && $_POST['nueva_password']) {
    $db = Core::Conectar();

    $usuario = $_POST['usuario'];
    $anterior = md5($_POST['anterior_password']);
    $nueva = md5($_POST['nueva_password']);


    $sql = "UPDATE dbo.usuarios SET pws_usuario = '$nueva' WHERE CAST(usuario AS VARCHAR(MAX)) = '$usuario' and CAST(pws_usuario AS VARCHAR(MAX)) = '$anterior'";
    $datos = $db->query($sql);

    setcookie("mensaje", "Contraseña actualizada correctamente.", time() + 5, "/");

    header("Location: ../index.php");
    exit;
} else {
    setcookie("mensaje", "Datos incompletos.", time() + 5, "/");
    header("Location: ../index.php");
}