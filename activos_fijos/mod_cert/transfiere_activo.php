<?php
include_once '../mod_configuracion/clases/conexion.php';
include_once("../theme/function.php");

$db = Core::Conectar();
if (@$_POST["btntransferir"]) {
    $estadotrue = true;
    $fecha = date("Y-m-d");

    $id_pers1 = $_POST["id_transfiere"];
    $id_pers2 = $_POST["id_transfierea"];
    $id = $_POST["id"];
    //echo $id;
    $observaciones = $_POST["observaciones"];
    foreach ($_POST["asignados"] as $asignar) {
        $sql = "INSERT INTO asignacion_activos(id_registro_individual,id_usuario_asig,id_usuario_reg,numero,observaciones,fecha_asignacion,fecha_reg) 
                VALUES($asignar,$id_pers2,$id,1,'$observaciones',GETDATE(),GETDATE());";
        $sql2 = "UPDATE asignacion_activos set estado=0 WHERE id_registro_individual='$asignar' and id_usuario_asig='$id_pers1';";
        $sql3 = "INSERT INTO devolucion_activos(id_registro_individual,id_usuario_dev,id_usuario_reg,observaciones,fecha_dev,fecha_reg) 
                VALUES($asignar,$id_pers1,$id,'$observaciones',GETDATE(),GETDATE());";
        $sql4 = "INSERT INTO transferencia_activos(id_registro_individual,id_usuario_trans,id_usuario_reg,observaciones,fecha_traspaso,fecha_reg) 
                VALUES($asignar,$id_pers1,$id,'$observaciones',GETDATE(),GETDATE());";
        $datos = $db->query($sql);
        $datos2 = $db->query($sql2);
        $datos3 = $db->query($sql3);
        $datos4 = $db->query($sql4);
    }
}
// header("location:../mod_cert/transf.php")

header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_n")));
?>