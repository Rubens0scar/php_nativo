<?php
include_once '../mod_configuracion/clases/conexion.php';
include_once("../theme/function.php");

$db = Core::Conectar();

$id_pers = $_POST["id_persona"];
$id = $_POST["id_reg"];
$observaciones = $_POST["observaciones"];

$asignados = $_POST['asignados'];
//$id = $_SESSION['id'];

$numero = count($asignados);
//echo $numero;
$i = 1;
$as = 0;
try {
	while ($i <= $numero) {

		$id_ri = $_POST['asignados'][$as];
		$sql = "INSERT INTO asignacion_activos(id_registro_individual,id_usuario_asig,id_usuario_reg,numero,observaciones,fecha_asignacion,fecha_reg) VALUES($id_ri,$id_pers,$id,1,'$observaciones',GETDATE(),GETDATE());";
		$datos = $db->query($sql);
		$i = $i + 1;
		$as = $as + 1;
		// header("location:../mod_cert/asignacion.php");

		header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_l")));
	}
} catch (PDOException $ex) {
	echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
}


?>