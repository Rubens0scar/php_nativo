<?php

include_once '../mod_configuracion/clases/conexion.php';
session_start();
$db = Core::Conectar();

try {
    $opcion = $_REQUEST["op"];
    if ($opcion == "1") {
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
        
        /*$usr = $_POST["usr"];
        $contraseña = $_POST["pass1"];
        $pwd = md5($contraseña);
        $estado_usu = $_POST["activo_usuario"];
        $rol = $_POST["rol"];*/

        $consulta = "SELECT id_dpto, cd_cnt_area FROM csa.area where estado=true and id_area='$id_area';";
        $resultado = $db->query($consulta);
		
        foreach ($resultado as $fila) {
            $ubi = $fila["id_dpto"];
            $ubi2 = $fila["cd_cnt_area"];
        }
        $cd_ubi3 = $ubi . '.' . $ubi2 . '.' . $cd_ubicacion;

        try {
            $sql = "INSERT INTO csa.personal(id_personal,id_area,cd_ubicacion,cd_ubi3,ci_personal,nom_personal,paterno_personal,materno_personal,cargo_personal,dir_personal,fn_personal,estado) VALUES('$id_personal','$id_area','$cd_ubicacion','$cd_ubi3','$ci_personal','$nom_personal','$paterno_personal','$materno_personal','$cargo_personal','$dir_personal','$fn_personal','$estado');";
            $datos = $db->query($sql);
            
            /*if($usr!=''){
                $id_persona="SELECT id_personal FROM csa.personal where ci_personal='$ci_personal';";
                $da = $db->query($id_persona);
                foreach ($da as $fila){ $id_per = $fila["id_personal"]; }

                $sql="insert into csa.usuarios(id_personal, usuario, pws_usuario, estado, rol) values($id_per,'$usr','$pwd',$estado_usu, '$rol');";
                $datos = $db->query($sql);
            }*/
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }

        echo '<script type="text/javascript\">' . "window.alert('Se registro correctamente.');" . "top.location = 'reg_personal.php';" . '</script>';
    }

    if ($opcion == "2") {

        try {
            if ($_REQUEST["pass1"] != $_REQUEST["pass2"]) {
                echo "<script type=\"text/javascript\">" . "window.alert('Las contrase�as no coinciden.');" . "top.location = 'reg_usu.php?id_personal=" . $_REQUEST["id_personal"] . "';" . "</script>";
            } else {
                $id_personal = $_POST["id_personal"];
                $usuario = $_POST["usuario"];
                $pws_usuario = md5($_REQUEST["pass1"]);
                $estado = $_POST["activo"];
                $sql = "INSERT INTO csa.usuarios(id_personal,usuario,pws_usuario,estado, rol) VALUES('$id_personal','$usuario','$pws_usuario','$estado',$rol);";
                $datos = $db->query($sql);
            }
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }

        echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "top.location = 'reg_usuario.php';" . "</script>";
    }
    
    if ($opcion == "3") {
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
        $estado = $_POST["estado"];
        
        $usr = $_POST["usr"];
        $contraseña = $_POST["pass1"];
        $pwd = md5($contraseña);
        $estado_usu = $_POST["estado_usuario"];
        $a=0;
        $chec =$_POST["usuario"];
        
        $consulta = "SELECT id_dpto, cd_cnt_area FROM csa.area where estado=true and id_area='$id_area';";
        $resultado = $db->query($consulta);
        foreach ($resultado as $fila) {
            $ubi = $fila["id_dpto"];
            $ubi2 = $fila["cd_cnt_area"];
        }
        $cd_ubi3 = $ubi . '.' . $ubi2 . '.' . $cd_ubicacion;

        try {
            $sql = "UPDATE csa.personal SET id_area=$id_area, cd_ubicacion=$cd_ubicacion, cd_ubi3='$cd_ubi3', ci_personal='$ci_personal', nom_personal='$nom_personal', paterno_personal='$paterno_personal', materno_personal='$materno_personal', cargo_personal='$cargo_personal', dir_personal='$dir_personal', fn_personal='$fn_personal', estado=$estado WHERE id_personal=$id_personal;";
            $datos = $db->query($sql);
            
            if($chec=='1'){
                $sqlh="select usuario from csa.usuarios where usuario='$usr'";
                $usuario=$db->query($sqlh);
                if(!$usuario)
                {
                $sql="UPDATE csa.usuarios SET usuario='$usr', pws_usuario='$pwd', estado=$estado_usu WHERE id_personal=$id_personal";
                $datos = $db->query($sql);
                }
                else
                {
                    $idu = "SELECT id_personal FROM csa.personal where ci_personal='$ci_personal';";
                    $idusu = $db->query($idu);
                    foreach ($idusu as $row)
                        $a= $row['id_personal'];
                $sql = "INSERT INTO csa.usuarios(id_personal,usuario,pws_usuario,estado,rol) VALUES('$a','$usr','$pwd','$estado_usu',1);";
                $datos = $db->query($sql);
                }
                }
            
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }

        echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "top.location = 'reg_personal.php';" . "</script>";
    }
    
    
    
    $db = null;
} catch (PDOException $e) {
    echo "Se tiene un problema con la conexion.<br>Mensaje de error: " . $e->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
}
?>

