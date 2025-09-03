<?php
include_once '../mod_configuracion/clases/conexion.php';
include_once("../theme/function.php");

$db = Core::Conectar();
if (@$_POST["btnasignar"]) {
    $id_pers = $_POST["id_persona"];
    $id = $_POST["id"];
    $observaciones = $_POST["observaciones"];

    foreach ($_POST["asignados"] as $asignar) {
        $sql = "INSERT INTO devolucion_activos(id_registro_individual,id_usuario_dev,id_usuario_reg,observaciones,fecha_dev,fecha_reg) 
                VALUES($asignar,$id_pers,$id,'$observaciones',GETDATE(),GETDATE());";
        echo $sql;
        $sql2 = "update asignacion_activos set estado=0 where id_registro_individual='$asignar' and id_usuario_asig='$id_pers' ;";
        echo $sql2;
        $datos2 = $db->query($sql2);
        $datos = $db->query($sql);
    }
}
// header("location:../mod_cert/devolucion.php")
header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_m")));
?>