<?php
include_once("../theme/function.php");
include_once '../mod_configuracion/clases/conexion.php';
session_start();
$db = Core::Conectar();
		$id_personal= $_POST["id_personal"];
		$usuario=$_POST["usuario"];
		$password=$_POST["password"];
        echo $password;
		$id_rol=$_POST["id_rol"];       
        $pwd=  md5($password);
        try {

            $sql = "INSERT INTO dbo.usuarios(id_personal,id_rol,usuario,pws_usuario,fecha_reg) VALUES($id_personal,$id_rol,'$usuario','$pwd',GETDATE());";
            echo $sql;
            $datos = $db->query($sql);
            header("location:../mod_usuarios/reg_personal_1.php");
            
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        // header("location:../mod_usuarios/reg_personal_1.php");
        header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_c")));
?>

