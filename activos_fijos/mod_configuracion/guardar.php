<?php
// echo "<script>alert('ingreso al popup');</script>";

require_once 'clases/conexion.php';
include_once("../theme/function.php");

header('Content-Type: application/json');

session_start();

$db = Core::Conectar();

// Validar datos recibidos
$valor_id = $_POST['valor_id'] ?? null;
$valor_residual = $_POST['valor_residual'] ?? '';
$valor_nuevo = $_POST['valor_nuevo'] ?? 1;

// echo $valor_residual;
// echo "\n";
// echo $valor_nuevo;
try {
    $sql = "INSERT INTO [dbo].[valor_residual_historico]([valor_residual],[id_registro_individual],[fecha]) VALUES($valor_residual,$valor_id,getdate());";
    $datos = $db->query($sql);
    
    $sql = "UPDATE [dbo].[registro_individual] set valor_residual=$valor_nuevo where id_registro_individual=$valor_id;";
    $datos = $db->query($sql);
    
    echo "<script>alert('Se Actualizo el registro con exito.');</script>";
    header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_2")));
} catch (PDOException $ex) {
    echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
}