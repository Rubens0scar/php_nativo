<?php
include_once 'mod_configuracion/clases/conexion.php';

$db = Core::Conectar();

if (isset($_POST["reg_activo_id"])) {
    $reg_activo_id = $_POST["reg_activo_id"];

    $consulta = "SELECT id_tipo_activos, descripcion FROM dbo.tipo_activos WHERE estado = 1 and id_activo = ".$reg_activo_id;
    $resultado = $db->query($consulta);

    echo '<option value="">Seleccione un tipo... </option>';
    foreach ($resultado as $fila) {
        echo "<option value='{$fila['id_tipo_activos']}'>{$fila['descripcion']}</option>";
    }

}
?>