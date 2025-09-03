<?php
include_once '../mod_configuracion/clases/conexion.php';
session_start();
$db = Core::Conectar();
		$n_adjuntos = $_POST["n_adjuntos"];
        $id_registro_activos = $_POST["id_registro_activos"];
        $paginacion = $_POST["paginacion"];
        $id_act = $_POST["reg_activo_id"];
        $id_tipo_activos = $_POST["tipo_activo_id"];
		$correlativo_cantidad = $_POST["correlativo"];
        $gestion = $_POST["gestion"];
        $descripcion_act = $_POST["descripcion_act"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $serie = $_POST["serie"];
        $costo = $_POST["costo"];
        $fecha_inicial = date('Y-d-m H:i', strtotime($_POST["fecha_inicial"])); 
        $valorIndividual = $_POST["residual"];
        $estado_activo = $_POST["estado_activo"];
        $observaciones = $_POST["observaciones"];
        $estado = $_POST["activo"];
        try{
            $id = $_SESSION["id"];
            $sql = "INSERT INTO registro_individual(id_registro_activos,id_activo,id_estado_activo,id_usuario_reg,paginacion,correlativo_cantidad,gestion,descripcion_act,marca,modelo,serie,costo,observaciones,fecha_reg,estado,valor_residual,id_tipo_activos,fecha_inicial) VALUES($id_registro_activos,$id_act,$estado_activo,$id,'$paginacion','$correlativo_cantidad','$gestion','$descripcion_act','$marca','$modelo','$serie','$costo','$observaciones',GETDATE(),'$estado',$valorIndividual, $id_tipo_activos,'$fecha_inicial');";
            $datos = $db->query($sql);
            // echo "<script type=\"text/javascript\">"."window.alert('Se registro correctamente.');"."top.location = 'registro_ind.php?&id_registro_activos=".$id_registro_activos."';"."</script>";
            echo "<script type=\"text/javascript\">"."window.alert('Se registro correctamente.');"."</script>";
            
            header("Location: ../attached.php?op=8&id=".$id_registro_activos);

	}       
        catch(PDOException $ex)
        {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: ".$ex->getMessage()."<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;		  
    
?>