<?php
include_once("../theme/function.php");
include_once '../mod_configuracion/clases/conexion.php';
session_start();
$db = Core::Conectar();
        $idpersonal=$_GET['id'];
        $consulta = "UPDATE dbo.usuarios SET estado=1 WHERE id_personal='$idpersonal';";
        $resultado = $db->query($consulta);
        // header("location:../mod_usuarios/reg_personal_1.php");
        header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_c")));
?>

