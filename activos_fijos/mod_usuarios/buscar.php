<?php
include_once '../mod_configuracion/clases/conexion.php';
$db = Core::Conectar();

$op=$_REQUEST["op"];

$consultaBusqueda = $_POST['valorBusqueda'];

if($op=="1"){

    $consulta = "SELECT concat(id_personal,'-',id_area,'-',ubicacion,'-',ci,'-',nombres,'-',apaterno,'-',amaterno,'-',id_cargo,'-',direccion,'-',telefonos,'-',ubicacion,'-',estado,'-',correo) datos FROM personal where ci like '" . $consultaBusqueda . "';";

    $resultado = $db->query($consulta);
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
    
    $mensaje = "";

    foreach ($resultado as $fila) {
        $mensaje = $fila["datos"];
    }

    echo $mensaje;
}

if($op=="2"){
    
    $consulta = "SELECT count(id_usuario) datos FROM usuarios where upper(usuario)=upper('" . $consultaBusqueda . "');";

    $resultado = $db->query($consulta);

    $mensaje = "";

    foreach ($resultado as $fila) {
        $mensaje = $fila["datos"];
    }

    echo $mensaje;
}

if($op=="3"){
   
    $consulta = "SELECT id_usuario || '%' || id_personal || '%' || usuario || '%' || pws_usuario || '%' || estado datos FROM dbo.usuarios where id_personal=" . $consultaBusqueda . ";";

    $resultado = $db->query($consulta);

    $mensaje = "";

    foreach ($resultado as $fila) {
        $mensaje = $fila["datos"];
    }

    echo $mensaje;
}

if($op=="4"){

    $consulta = "SELECT concat(id_cargo,'-',descripcion,'-',estado) datos FROM cargo WHERE descripcion like '" . $consultaBusqueda . "';";

    $resultado = $db->query($consulta);
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
    
    $mensaje = "";

    foreach ($resultado as $fila) {
        $mensaje = $fila["datos"];
    }

    echo $mensaje;
}