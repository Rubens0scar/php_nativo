<?php

include_once '../mod_configuracion/clases/conexion.php';
include_once("../theme/function.php");

session_start();
$db = Core::Conectar();

try {
    $opcion = $_REQUEST["op"];
    $id = $_SESSION["id"];

    if ($opcion == "1") {
        $fecha = strtoupper(trim($_POST["fecha"], ' '));
        $dolar_venta = $_POST["sus_v"];
        $dolar_compra = $_POST["sus_c"];
        $ufv_venta = $_POST["ufv_v"];
        $consulta = "SELECT MAX(id_tipo_cambio+1) FROM tipo_cambio";
        $resultado = $db->query($consulta);
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

        try {
            $sql = "INSERT INTO tipo_cambio(sus_venta, sus_compra, ufv_venta, id_usuario_reg, fecha_reg, estado) VALUES ($dolar_venta,$dolar_compra,$ufv_venta,$id,'$fecha',1);";
            $datos = $db->query($sql);
            // echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "top.location = 'tipo_cambio.php';" . "</script>";
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

			header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_d")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
    }

    if ($opcion == "2") {
        $motivo = strtoupper(trim($_POST["motivo"], ' '));
        try {
            $sql = "INSERT INTO motivo_baja(motivo, fecha_reg, id_usuario_reg) VALUES('$motivo',GETDATE(),$id);";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_h")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;

    }
    ///////////////////////////////////////////////////////////
    if ($opcion == "3") {
        $codigo = strtoupper(trim($_POST["codigo"], ' '));
        $nombre = strtoupper(trim($_POST["nombre"], ' '));
        $activo = strtoupper(trim($_POST["activo"], ' '));
        try {
            $sql = "INSERT INTO departamentos(codigo_departamento,nom_departamento,estado,fecha_reg,id_usuario_reg) VALUES($codigo,'$nombre',$activo,GETDATE(),$id);";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_e")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }
    ///////////////////////////////////////////
    if ($opcion == "4") {
        $empresa = strtoupper(trim($_POST["empresa"], ' '));
        $nit = strtoupper(trim($_POST["nit"], ' '));
        $direccion = strtoupper(trim($_POST["direccion"], ' '));
        $telefonos = strtoupper(trim($_POST["fono"], ' '));
        $correo = trim($_POST["correo"], ' ');
        $contacto = strtoupper(trim($_POST["contacto"], ' '));
        $estado = strtoupper(trim($_POST["activo"], ' '));
        try {
            $sql = "INSERT INTO empresas(nit, empresa, direccion, telefonos, correo, contacto, estado, fecha_reg, id_usuario_reg) VALUES('$nit','$empresa','$direccion','$telefonos','$correo','$contacto',$estado,GETDATE(),$id);";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_g")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }

    if ($opcion == "6") {
        $gc_cnta_cm = strtoupper(trim($_POST["completo"], ' '));
        $gc_cnta_sp = strtoupper(trim($_POST["simple"], ' '));
        $descripcion = strtoupper(trim($_POST["des"], ' '));
        $depvidut = strtoupper(trim($_POST["anio"], ' '));
        $depcoef = strtoupper(trim($_POST["porcentaje"], ' '));
        $estado = strtoupper(trim($_POST["activo"], ' '));

        try {
            $sql = "INSERT INTO grupo_contable(cod_contable, cod_resumen, descripcion, vida_util, depcoef, estado, fecha_reg, id_usuario_reg) VALUES ('$gc_cnta_cm','$gc_cnta_sp','$descripcion','$depvidut','$depcoef','$estado',GETDATE(),$id);";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_i")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }
    ///////////////////////////////////////////////////////////
    if ($opcion == "7") {
        $antiguedad = $_POST["antiguedad"];
        $id_emp = $_POST["id_emp"];
        $descripcion = $_POST["descripcion"];
        $n_adjuntos = $_POST["cantidad"];
        $date = DateTime::createFromFormat('d/m/Y', $_POST["fecha_registro"]);
        $fecha_registro = $date->format('Y-m-d');
        $fecha_compra = date('Y-m-d', strtotime($_POST["fecha_compra"]));
        $fecha_inicial = date('Y-d-m H:i', strtotime($_POST["fecha_inicial"])); 
        $n_cbt = $_POST["cbte"];
        $id_cam = $_POST["id_gam"];
        $factura = $_POST["factura"];
        $costo = round($_POST["costo"], 2);
        $c_cred_fiscal = round($_POST["cr"], 2);
        $s_cred_fiscal = round($_POST["costo_sin_cr"], 2);
        $id_tc = $_POST["id_tc"];
        $id_personal = $_POST["id_personal"];
        $estado = $_POST["activo"];
        try {
            echo $antiguedad;
            if ($antiguedad == 'ANTIGUO') {
                $consulta = "SELECT top 1 id_tipo_cambio FROM tipo_cambio ORDER BY id_tipo_cambio desc;";
                $resultado = $db->query($consulta);
                $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                //echo $resultado[0]['id_tipo_cambio'];
                $id_tipo_cambio_actual = $resultado[0]['id_tipo_cambio'];
                $sql = "INSERT INTO registro_activos(id_empresa,id_grupo_contable,id_tipo_cambio,id_usuario_reg,antiguedad,descripcion,n_adjuntos,fecha_compra,n_cbt,factura,costo,c_cred_fiscal,s_cred_fiscal,estado,fecha_reg,id_urecibido,id_tipo_cambio_actual,fecha_inicial) VALUES($id_emp,$id_cam,$id_tc,$id,'$antiguedad','$descripcion','$n_adjuntos','$fecha_compra','$n_cbt','$factura','$costo','$c_cred_fiscal','$s_cred_fiscal','$estado','$fecha_registro',$id_personal,$id_tipo_cambio_actual,'$fecha_inicial');";
            } else {
                $sql = "INSERT INTO registro_activos(id_empresa,id_grupo_contable,id_tipo_cambio,id_usuario_reg,antiguedad,descripcion,n_adjuntos,fecha_compra,n_cbt,factura,costo,c_cred_fiscal,s_cred_fiscal,estado,fecha_reg,id_urecibido,fecha_inicial) VALUES($id_emp,$id_cam,$id_tc,$id,'$antiguedad','$descripcion','$n_adjuntos','$fecha_compra','$n_cbt','$factura','$costo','$c_cred_fiscal','$s_cred_fiscal','$estado','$fecha_registro',$id_personal,'$fecha_inicial');";
            }
            //echo $sql;
            $datos = $db->query($sql);
            // echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "top.location = 'activos.php';" . "</script>";
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_k")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
    }
    /////////////////////////////////////////
    if ($opcion == "8") {
        $id_dpto = $_POST["id_dpto"];
        $codigo = $_POST["codigo"];
        $nombre = strtoupper(trim($_POST["nombre"], ' '));
        $activo = strtoupper(trim($_POST["activo"], ' '));
        $cd_ubi1 = (($_POST["id_dpto"]) . '.' . ($_POST["codigo"]));

        try {
            $sql = "INSERT INTO area(id_departamento, codigo_area, nom_area, estado, ubicacion_area, fecha_reg, id_usuario_reg) VALUES($id_dpto,$codigo,'$nombre','$activo','$cd_ubi1', GETDATE(),'$id');";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_f")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
    }
    ///////////////////////
    if ($opcion == "9") {
        $id_gam = $_POST["id_gam"];
        $nombre = $_POST["nombre"];
        $activo = $_POST["activo"];    
        $s_activo = "SELECT case when MAX(CAST(CAST(cod_subgrupo AS VARCHAR(MAX)) AS INT)) is null then 1 else MAX(CAST(CAST(cod_subgrupo AS VARCHAR(MAX)) AS INT))+1 end AS cod_sub 
                        FROM activo WHERE id_grupo_contable=$id_gam";
        $datos =$db->query($s_activo);
        $datos = $datos->fetchAll(PDO::FETCH_ASSOC);
        $id_subg = $datos[0]['cod_sub'];
        
        try {

            $sql = "INSERT INTO activo(id_grupo_contable,cod_subgrupo,nombre,estado,fecha_reg,id_usuario_reg) 
                                VALUES($id_gam,'$id_subg','$nombre',$activo,GETDATE(),$id);";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_j")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }

    }
    //////////////////////////
    if ($opcion == "10") {
        $id_regind = $_REQUEST["id_regind"];
        $id_regact = $_REQUEST["id_regact"];
        try {
            $sql = "UPDATE registro_individual SET estado=0, correlativo_cantidad=0, paginacion='0-0'  WHERE id_registro_individual=$id_regind";
            $datos = $db->query($sql);
            // echo "<script type=\"text/javascript\">" . "window.alert('Se eliminó correctamente.');" . "top.location = 'registro_ind.php?id_registro_activos=" . $id_regact ."';" . "</script>";
            echo "<script type=\"text/javascript\">" . "window.alert('Se eliminó correctamente.');" . "top.location = '../attached.php?op=8&id=" . $id_regact ."';" . "</script>";
            
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;

    }

    if ($opcion == "11") {
        $id_dep = $_REQUEST["d"];
        $codigo = strtoupper(trim($_POST["codigo"], ' '));
        $nombre = strtoupper(trim($_POST["nombre"], ' '));
        $activo = strtoupper(trim($_POST["activo"], ' '));

        try {
            $sql = "UPDATE departamentos SET codigo_departamento='$codigo', nom_departamento='$nombre', estado=$activo, fecha_mod=GETDATE(), id_usuario_reg=$id WHERE id_departamento=$id_dep;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_e")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }
    if ($opcion == "12") {
        $codigo_activo = $_REQUEST["d"];
        $id_gam = $_POST["id_gam"];
        $nombre = $_POST["nombre"];
        $activo = $_POST["activo"];    

        try {
            $sql = "UPDATE activo SET id_grupo_contable='$id_gam', nombre='$nombre', estado=$activo, id_usuario_reg=$id, fecha_mod=GETDATE() WHERE id_activo=$codigo_activo;";
            $datos = $db->query($sql);
            //echo $sql;
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_j")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }

    }
    if ($opcion == "13") {
        $id_area = $_REQUEST["d"];
        $codigo = strtoupper(trim($_POST["codigo"], ' '));
        $nombre = strtoupper(trim($_POST["nombre"], ' '));
        $id_dpto = strtoupper(trim($_POST["id_dpto"], ' '));
        $activo = strtoupper(trim($_POST["activo"], ' '));
        $cd_ubi1 = (($_POST["id_dpto"]) . '.' . ($_POST["codigo"]));

        try {
            $sql = "UPDATE area SET id_departamento=$id_dpto, codigo_area=$codigo, nom_area='$nombre', estado=$activo, ubicacion_area='$cd_ubi1', id_usuario_reg=$id, fecha_mod=GETDATE() WHERE id_area=$id_area;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_f")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;  
    }
    if ($opcion == "14") {
        $id_tipo = $_REQUEST["d"];
        $dolar_venta = $_POST["sus_v"];
        $dolar_compra = $_POST["sus_c"];
        $ufv_venta = $_POST["ufv_v"];

        try {
            $sql = "UPDATE tipo_cambio SET fecha_mod=GETDATE(), sus_venta=$dolar_venta, sus_compra=$dolar_compra, ufv_venta=$ufv_venta, id_usuario_reg=$id WHERE id_tipo_cambio=$id_tipo;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";
            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_d")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
    }
    if ($opcion == "15") {
        $id_empresa = $_REQUEST["d"];
        $empresa = strtoupper(trim($_POST["empresa"], ' '));
        $nit = strtoupper(trim($_POST["nit"], ' '));
        $direccion = strtoupper(trim($_POST["direccion"], ' '));
        $telefonos = strtoupper(trim($_POST["fono"], ' '));
        $correo = trim($_POST["correo"], ' ');
        $contacto = strtoupper(trim($_POST["contacto"], ' '));
        $estado = strtoupper(trim($_POST["activo"], ' '));

        try {
            $sql = "UPDATE empresas SET empresa='$empresa', nit='$nit', direccion='$direccion', telefonos='$telefonos', correo='$correo', contacto='$contacto', estado=$estado, id_usuario_reg = $id, fecha_mod = GETDATE() WHERE id_empresa=$id_empresa;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_g")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }
    /*if ($opcion == "16") {
    $id_act = $_REQUEST["d"];
    $material = strtoupper(trim($_POST["material"], ' '));
    $estado = strtoupper(trim($_POST["estado"], ' '));
    try {
    $sql = "UPDATE dbo.tipo_activo SET act_mat='$material', estado=$estado WHERE id_actmat=$id_act;";
    $datos = $db->query($sql);
    } catch (PDOException $ex) {
    echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
    }
    //echo $sql;
    echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "top.location = 'tipo_material.php';" . "</script>";
    }*/
    if ($opcion == "17") {
        $id_gam = $_REQUEST["d"];
        $gc_cnta_cm = strtoupper(trim($_POST["completo"], ' '));
        $gc_cnta_sp = strtoupper(trim($_POST["simple"], ' '));
        $descripcion = strtoupper(trim($_POST["des"], ' '));
        $depvidut = strtoupper(trim($_POST["anio"], ' '));
        $depcoef = strtoupper(trim($_POST["porcentaje"], ' '));
        $estado = strtoupper(trim($_POST["activo"], ' '));

        try {
            $sql = "UPDATE grupo_contable SET cod_contable='$gc_cnta_cm', cod_resumen='$gc_cnta_sp', descripcion='$descripcion', vida_util='$depvidut', depcoef='$depcoef', estado=$estado, id_usuario_reg=$id, fecha_mod=GETDATE()  WHERE id_grupo_contable=$id_gam;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_i")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }
    if ($opcion == "18") {
        $id_mot = $_REQUEST["d"];
        $motivo = strtoupper(trim($_POST["motivo"], ' '));
        $estado = strtoupper(trim($_POST["activo"], ' '));

        try {
            $sql = "UPDATE motivo_baja SET motivo='$motivo', id_usuario_reg=$id, estado=$estado, fecha_mod=GETDATE() WHERE id_motivo=$id_mot;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_h")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;
    }
    if ($opcion == "19") {
        echo ('llega');
        $id_activo = $_POST["id_activo"];
        $descripcion = strtoupper(trim($_POST["descripcion"], ' '));
        try {
            $sql = "INSERT INTO tipo_activos(id_activo, descripcion, estado, fecha_reg, id_usuario_reg) VALUES($id_activo,'$descripcion',1,GETDATE(),$id);";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se registro correctamente.');" . "</script>";

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_p")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;

    }
    if ($opcion == "20") {
        $id = $_REQUEST["d"];
        echo ($id);
        $id_activo = $_POST["id_activo"];
        $descripcion = strtoupper(trim($_POST["descripcion"], ' '));
        $activo = $_POST["activo"];
        try {
            $sql = "UPDATE tipo_activos SET id_activo=$id_activo, descripcion='$descripcion', estado=$activo, fecha_mod=GETDATE() WHERE id_tipo_activos=$id;";
            $datos = $db->query($sql);
            echo "<script type=\"text/javascript\">" . "window.alert('Se modifico correctamente.');" . "</script>";            

            header("Location: ../index.php?ruta=".urlencode(generarCodigoSeguro("pagina_p")));
        } catch (PDOException $ex) {
            echo "hubo un problema con la conexion al almacenar las aplicaciones.<br>mensaje de error: " . $ex->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        //echo $sql;

    }
    //////////////////////////
    $db = null;
} catch (PDOException $e) {
    echo "Se tiene un problema con la conexion.<br>Mensaje de error: " . $e->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
}
?>