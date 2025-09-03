<?php

include_once '../mod_configuracion/clases/conexion.php';
session_start();
$db = Core::Conectar();

    $opcion = $_REQUEST["op"];
        $id_personal = $_POST["id_personal"];
        $id_area = $_POST["id_area"];
        $nom_personal = $_POST["nom_personal"];
        $paterno_personal = $_POST["paterno_personal"];
        $materno_personal = $_POST["materno_personal"];
        $ci_personal = $_POST["ci_personal"];
        $cd_ubicacion = $_POST["cd_ubicacion"];
        $cargo_personal = $_POST["cargo_personal"];
        $dir_personal = $_POST["dir_personal"];
        $fn_personal = $_POST["fn_personal"];
        $estado = $_POST["activo"];
        

        $consulta = "SELECT id_dpto, cd_cnt_area FROM dbo.area where estado=true and id_area='$id_area';";
        $resultado = $db->query($consulta);
		
        foreach ($resultado as $fila) {
            $ubi = $fila["id_dpto"];
            $ubi2 = $fila["cd_cnt_area"];
        }
        $cd_ubi3 = $ubi . '.' . $ubi2 . '.' . $cd_ubicacion;

        try {
            $sql = "UPDATE dbo.personal SET id_personal='$id_personal',id_area='$id_area',cd_ubicacion='$cd_ubicacion',cd_ubi3='$cd_ubi3',ci_personal='$ci_personal',nom_personal='$nom_personal',paterno_personal='$paterno_personal',materno_personal='$materno_personal',cargo_personal='$cargo_personal',dir_personal='$dir_personal',fn_personal='$fn_personal',estado='$estado' WHERE id_personal='$id_personal';";
            $datos = $db->query($sql);
            
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
echo "asdasd";
        header("Location:../mod_usuarios/reg_personal.php");
?>
