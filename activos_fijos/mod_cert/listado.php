<?php
session_start();

if ($_SESSION["usuario_nombre"]) {
    require("../theme/header_reportes.php");
    ?>
    <script language="javascript">
        function visibilidadDiv(id) {
            div = document.getElementById(id);
            document.getElementById("completo").value = '';
            document.getElementById("simple").value = '';
            document.getElementById("des").value = '';
            document.getElementById("anio").value = '';
            document.getElementById("porcentaje").value = '';

            if (div.style.display == "block") {
                div.style.display = "none";
            } else {
                div.style.display = "block";
            }
        }
    </script><br><br><br><br>
    <script type="text/javascript">
        function imprSelec(imprime) { var ficha = document.getElementById(imprime); var ventimp = window.open(' ', 'popimpr'); ventimp.document.write(ficha.innerHTML); ventimp.document.close(); ventimp.print(); ventimp.close(); }
    </script>
    <center>
        <a href="javascript:imprSelec('imprime')"><img src="../theme/images/print.png" width="30" height="30" / align="right"></a>
        <div id="imprime" style='overflow-y:auto;width:95%;'>
        <img src="../theme/images/sabor/gaucho.png" width="160" height="100" align="left">
            <table>
                <tr>
                
                    <td class="titulo">REPORTE GENERAL DE ACTIVOS SEGÚN INTÉRVALO DE FECHAS</td>
                </tr>
                <tr>
                    <td class="subtitulo" style="text-align: center">Reporte Restaurante "SABOR GAUCHO"</td>
                </tr>
            </table><br>
            <div id="nuevo" style="display: none;" class="estilo_subdiv">

                <br>
            </div>
            <br>
            <div style='overflow-y:auto;width:95%;'>
                <table width="90%" height="55" style="border:1px;" align="center">
                    <tr bgcolor='#CCCFF1'>
                        <th class="colEnc">Código Contable Completo</th>
                        <th class="colEnc">Descripción</th>
                        <th class="colEnc">Institución</th>
                        <th class="colEnc">Grupo Contable</th>
                        <th class="colEnc">Sub Grupo</th>
                        <th class="colEnc">Correlativo</th>
                        <th class="colEnc">Año</th>
                        <th class="colEnc">Fecha Registro</th>
                        <th class="colEnc">N° CBTE</th>
                        <th class="colEnc">Activo o Bien</th>
			            <th class="colEnc">UFV</th>
                        <th class="colEnc">Cantidad</th>
                        <th class="colEnc">Descripcion Detallada</th>
                        <th class="colEnc">N° Factura</th>
                        <th class="colEnc">Valor de Compra en Bs.</th>
                        <th class="colEnc">Estado Actual</th>
                        <th class="colEnc">Observaciones</th>
                    </tr>
                    <?php
                    include_once '../mod_configuracion/clases/conexion.php';
                    $db = Core::Conectar();


                    $consulta = "SELECT ra.id_registro_activos, a.cod_subgrupo, ra.factura, year (ra.fecha_compra) anio, gam.cod_contable, gam.cod_resumen, e.est_tec,
                    ra.n_adjuntos, ra.estado,  ri.descripcion_act, ri.observaciones, ri.correlativo_cantidad, ri.id_activo, em.empresa, em.direccion, p.nombres, 
                    c.descripcion as cargo, ra.fecha_reg, ra.descripcion, ra.n_adjuntos, ra.factura, ra.costo, ra.c_cred_fiscal, ra.s_cred_fiscal, ra.n_cbt,  
                    case ra.estado when 1 then 'ACTIVO' else 'INACTIVO' end estado, tc.sus_venta,tc.sus_compra,tc.ufv_venta 
                    FROM dbo.registro_activos ra 
                    inner join dbo.grupo_contable gam on gam.id_grupo_contable=ra.id_grupo_contable
                    inner join dbo.registro_individual ri on ri.id_registro_activos=ra.id_registro_activos
                    inner join dbo.activo a on a.id_activo=ri.id_activo 
                    inner join dbo.empresas em on em.id_empresa=ra.id_empresa 
                    inner join dbo.tipo_cambio tc on tc.id_tipo_cambio=ra.id_tipo_cambio 
                    inner join dbo.personal p on p.id_personal=ra.id_urecibido
                    inner join dbo.estado_activo e on e.id_estado_activo=ri.id_estado_activo
                    inner join dbo.cargo c on c.id_cargo=p.id_cargo
                    order by ra.id_registro_activos";
                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $i = 0;
                    if (count($resultado) > 0) {

                        foreach ($resultado as $fila) {
                            $codigo = $fila["id_activo"];
                            $consulta1 = "select nombre from dbo.activo where estado=1 and id_activo=$codigo";
                            $resultado1 = $db->query($consulta1);
                            foreach ($resultado1 as $fila1) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_contable"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["descripcion"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo 'CLR'; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_resumen"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_subgrupo"];
                                        ; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["correlativo_cantidad"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["anio"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["fecha_reg"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["n_cbt"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila1["nombre"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["ufv_venta"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["n_adjuntos"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["descripcion_act"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["factura"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["costo"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["est_tec"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["observaciones"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    $db = null;
                    ?>
                </table>

                <br>
            </div>
        </div>
    </center>

    <?php
    require("../theme/footer_inicio.php");
} else
    header('Location: ../index.php');
?>

<style>
    .button {
        border: 1px solid #DBE1EB;
        font-size: 14px;
        font-family: Arial, Verdana;
        padding-left: 7px;
        padding-right: 7px;
        padding-top: 5px;
        padding-bottom: 5px;
        border-radius: 4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        -o-border-radius: 4px;
        background: #4972B5;
        background: linear-gradient(left, #4972B5, #618ACB);
        background: -moz-linear-gradient(left, #4972B5, #618ACB);
        background: -webkit-linear-gradient(left, #4972B5, #618ACB);
        background: -o-linear-gradient(left, #4972B5, #618ACB);
        color: #FFFFFF;
    }

    .button:hover {
        background: #365D9D;
        background: linear-gradient(left, #365D9D, #436CAD);
        background: -moz-linear-gradient(left, #365D9D, #436CAD);
        background: -webkit-linear-gradient(left, #365D9D, #436CAD);
        background: -o-linear-gradient(left, #365D9D, #436CAD);
        color: #FFFFFF;
        border-color: #FBFFAD;
    }

    .estilo_div {
        border: solid 10px #ccc;
        border-radius: 15px;
        box-shadow: 8px 8px 10px 0px #818181;
        width: 850px;
    }

    .titulo {
        font-family: algerian;
        color: #001459;
        font-size: 180%;
    }

    .subtitulo {
        font-family: algerian;
        /*color: lightblue;*/
        color: #001459;
        font-size: 120%;
    }

    .estilo_subdiv {
        border: solid 3px #ccc;
        border-radius: 15px;
        width: 450px;
    }

    .inputs {
        float: none;
        padding: 0px;
        font-size: small;
        font-family: verdana;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border: 1px solid rgb(182, 182, 182);
        color: rgb(51, 51, 51);
    }

    .colEnc {
        display: table-cell;
        padding: 5px;
        font-family: monospace;
        font-size: 14px;
        color: #063b82;
        background: #CED4D9;
    }

    .colDat {
        display: table-cell;
        padding: 5px;
        font-family: monospace;
        font-size: 14px;
        color: #063b82;
    }
</style>