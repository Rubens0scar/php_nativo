<?php
include_once("../theme/function.php");
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
        $id_cargo = $_POST["id_cargo"];
        $dir_personal = $_POST["dir_personal"];
        $fn_personal = $_POST["fn_personal"];
        $estado = $_POST["activo"];
        $correo = $_POST["correo_personal"];
//echo $nom_personal;
        try {
            $sql = "INSERT INTO personal(id_area,id_cargo,ci,apaterno,amaterno,nombres,direccion,telefonos,ubicacion,estado,fecha_reg,correo) 
                    VALUES('$id_area','$id_cargo','$ci_personal','$paterno_personal','$materno_personal','$nom_personal','$dir_personal','$fn_personal','$id_cargo','$estado',GetDate(),'$correo');";
            echo ($sql);
            $datos = $db->query($sql);
            echo "LOS DATOS SE INSERTARON CORRECTAMENTE...";
            //header("refresh:2;url=reg_personal.php");
            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_b")));
        }
        catch (PDOException $ex)
        {
          echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
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
                $sql = "INSERT INTO usuarios(id_personal,usuario,pws_usuario,estado, rol) VALUES('$id_personal','$usuario','$pws_usuario','$estado',$rol);";
                $datos = $db->query($sql);
            }
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }

        // echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "top.location = 'reg_usuario.php';" . "</script>";
        echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";
        header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_b")));
    }
    
    if ($opcion == "3") {
        $id_personal = $_POST["id_personal"];
        $id_area = $_POST["id_area"];
        $nom_personal = $_POST["nombres"];
        $paterno_personal = $_POST["apaterno"];
        $materno_personal = $_POST["amaterno"];
        $ci_personal = $_POST["ci"];
        $cd_ubicacion = ''; //$_POST["ubicacion"];
        $id_cargo = $_POST["id_cargo"];
        $dir_personal = $_POST["direccion"];
        $fn_personal = $_POST["telefonos"];
        $estado = $_POST["estado"];
        $correo_personal = $_POST["correo_personal"];
        
        $consulta = "SELECT id_departamento, codigo_area FROM area where estado=1 and id_area='$id_area';";
        $resultado = $db->query($consulta);
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultado as $fila) {
            $ubi = $fila["id_departamento"];
            $ubi2 = $fila["codigo_area"];
        }
        $cd_ubi3 = $ubi . '.' . $ubi2 . '.' . $cd_ubicacion;

        try {
            $sql = "UPDATE personal SET correo='$correo_personal', id_area=$id_area, ubicacion='$cd_ubicacion', ci='$ci_personal', nombres='$nom_personal', apaterno='$paterno_personal', amaterno='$materno_personal', id_cargo=$id_cargo, direccion='$dir_personal', telefonos='$fn_personal', estado=$estado WHERE id_personal=$id_personal;";
            $datos = $db->query($sql);
            echo "Se modifico correctamente.";
            
        } catch (PDOException $ex) {
            echo "Hubo un problema con la conexion al almacenar las aplicaciones. /n mensaje de error: " . $ex->getMessage() . " Por favor comuniquese con personal de sistemas.";
        }

        // echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "top.location = 'reg_personal.php';" . "</script>";        
        //header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_b")));
    }

    if ($opcion == "4") {
        $cargo = $_POST["cargo"];
        $estado = $_POST["activo"];        
        
        try {
            $sql = "INSERT INTO cargo(descripcion,estado,fecha_reg) 
                    VALUES('$cargo','$estado',GetDate());";
            echo ($sql);
            $datos = $db->query($sql);
            echo "LOS DATOS SE INSERTARON CORRECTAMENTE...";
            //header("refresh:2;url=reg_personal.php");
            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_o")));
        }
        catch (PDOException $ex)
        {
          echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        // echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "top.location = 'reg_personal.php';" . "</script>";        
        //header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_b")));
    }

    if ($opcion == "5") {
        $id_cargo = $_POST["id_cargo"];
        $descripcion = $_POST["descripcion"];
        $estado = $_POST["estado"];     
        try {
            $sql = "UPDATE cargo SET descripcion='$descripcion', estado=$estado WHERE id_cargo=$id_cargo;";
            $datos = $db->query($sql);
            echo "Se modifico correctamente.";
            
        } catch (PDOException $ex) {
            echo "Hubo un problema con la conexion al almacenar las aplicaciones. /n mensaje de error: " . $ex->getMessage() . " Por favor comuniquese con personal de sistemas.";
        }

        // echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "top.location = 'reg_personal.php';" . "</script>";        
        //header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_b")));
    }

    $db = null;
} catch (PDOException $e) {
    echo "Se tiene un problema con la conexion.<br>Mensaje de error: " . $e->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
}
?>

