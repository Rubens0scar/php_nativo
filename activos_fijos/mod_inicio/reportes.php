<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require_once("../mod_configuracion/clases/conexion.php");
    $db = Core::Conectar();
    require_once("../theme/header_reportes.php");
    ?>

    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        function imprSelec(imprime) {
            var ficha = document.getElementById(imprime);
            var ventimp = window.open(' ', 'popimpr');
            ventimp.document.write(ficha.innerHTML);
            ventimp.document.close();
            ventimp.print();
            ventimp.close();
        }
    </script>

    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <link rel="stylesheet" type="text/css" href="../theme/css/jquery.dataTables.css">

    <style type="text/css" class="init"></style>
    <script type="text/javascript" language="javascript" src="../theme/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

    <!-- Content Center -->

    <div id="centercontent" align="center">

        <!--a href="javascript:imprSelec('imprime')"><img src="../theme/images/print.png" width="30" height="30" /></a-->
        <br /><br />
        <?php
        try {
            $opcion = $_REQUEST["op"];
            $id = $_SESSION["id"];
            //////////////////////////////////////   
            if ($opcion == "1") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>                        
                    <table width="50%" >
                        <tr>
                            <td class="titulo">
                                <img src="../theme/images/sabor/gaucho.png" width="20%" align="left">REPORTE DE DEPARTAMENTOS <br>
                                <h5 style="color: black;">AL <?php echo date("d-m-Y"); ?></h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="subtitulo" style="text-align: center"></td>
                        </tr>
                    </table><br>
                    <table width="50%"style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N&UacuteMERO </th>
                            <th class="colEnc">C&OacuteDIGO DE DEPARTAMENTO</th>
                            <th class="colEnc">DEPARTAMENTO</th>
                            <th class="colEnc">ESTADO</th>
                        </tr>
                        <?php
                        $resultado = "SELECT id_departamento, codigo_departamento, nom_departamento, case estado when '1' then 'ACTIVO' else 'INACTIVO' end estado FROM departamentos order by codigo_departamento";
                        $resultado = $db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["codigo_departamento"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["nom_departamento"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["estado"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            //////////////////////////////////////////// 
            if ($opcion == "2") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE &AacuteREAS DE TRABAJO</h2><br>
                    <table width="0%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N&UacuteMERO </th>
                            <th class="colEnc">C&OacuteDIGO DE DEPARTAMENTO</th>
                            <th class="colEnc">CODIGO</th>
                            <th class="colEnc">&AacuteREA </th>
                        </tr>
                        <?php
                        $resultado = "SELECT a.id_departamento, d.nom_departamento, a.id_area, a.nom_area, a.estado, a.codigo_area
                                        FROM area a, departamentos d  
                                        WHERE a.estado=1 and d.codigo_departamento=a.id_departamento 
                                        order by a.id_departamento,a.codigo_area";
                        $resultado = $db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["id_departamento"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["codigo_area"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["nom_area"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            ///////////////////////////////////////////////////// 
            if ($opcion == "3") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE CLASIFICADOR DE ACTIVOS</h2><br>
                    <table width="50%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">Nº</th>
                            <th class="colEnc">ACR&OacuteNIMO</th>
                            <th class="colEnc">GRUPO CONTABLE</th>
                            <th class="colEnc">C&OacuteDIGO SUB GRUPO</th>
                            <th class="colEnc">DESCRIPCI&OacuteN SUB GRUPO</th>
                        </tr>
                        <?php
                        $resultado = "SELECT ga.cod_resumen, ga.descripcion, a.cod_subgrupo, a.nombre, a.fecha_reg, a.estado, ga.cod_contable 
                                        FROM activo a, grupo_contable ga
                                        WHERE a.estado=1 and a.id_grupo_contable=ga.id_grupo_contable";
                        $resultado = $db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_resumen"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["descripcion"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_subgrupo"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["nombre"]; ?>
                                    </td>                                    
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            ///////////////////////////////////////////////   
            if ($opcion == "4") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE PROVEEDORES DEL RESTAURANTE</h2>
                    <table width="70%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N&UacuteMERO </th>
                            <th class="colEnc">NIT</th>
                            <th class="colEnc">EMPRESA</th>
                            <th class="colEnc">DIRECCI&OacuteN </th>
                            <th class="colEnc">TEL&EacuteFONO </th>
                            <th class="colEnc">CORREO</th>
                            <th class="colEnc">CONTACTO</th>
                            <th class="colEnc">ESTADO</th>
                        </tr>
                        <?php
                        $resultado = "SELECT id_empresa, nit, empresa, direccion, telefonos, correo, contacto, 
                                        case estado when '1' then 'ACTIVO' else 'INACTIVO' end estado 
                                        FROM empresas order by id_empresa
";
                        $resultado = $db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["nit"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["empresa"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["direccion"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["telefonos"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["correo"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["contacto"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["estado"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            ///////////////////////////////////////////////////////////////   
            if ($opcion == "5") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE TIPO DE CAMBIO <br />D&OacuteLAR / UFV </h2>

                    <div style='overflow-y:auto;width:100%;'>
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr bgcolor='#CCCFF1'>
                                <th class="colEnc">N&UacuteMERO </th>
                                <th class="colEnc">FECHA</th>
                                <th class="colEnc">D&OacuteLAR VENTA</th>
                                <th class="colEnc">D&OacuteLAR COMPRA</th>
                                <th class="colEnc">UFV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultado = "SELECT id_tipo_cambio, fecha_reg, sus_venta, sus_compra, ufv_venta
                                            FROM tipo_cambio
                                            WHERE estado=1 
                                            order by CAST(fecha_reg AS varchar(max))";
                            $resultado = $db->query($resultado);
                            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                            $i = 0;
                            if (count($resultado) > 0) {

                                foreach ($resultado as $fila) {
                                    $i = $i + 1;
                                    ?>
                                    <tr bgcolor="#F2F9FF">
                                        <th scope="row" class="colDat">
                                            <?php echo $i; ?>
                                        </th>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["fecha_reg"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["sus_venta"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["sus_compra"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["ufv_venta"]; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            $db = null;
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <?php
            }
            /////////////////////////////////////////////    
            if ($opcion == "6") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE TIPO DE MATERIAL</h2>
                    <table width="70%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N&UacuteMERO </th>
                            <th class="colEnc">TIPO DE MATERIAL</th>
                            <th class="colEnc">ESTADO</th>
                        </tr>
                        <?php
                        $resultado = "select id_actmat, act_mat, case estado 
when true then 'ACTIVO' else 'INACTIVO' end estado 
from dbo.tipo_activo";
                        $resultado = $db->query($resultado);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $id = $fila[0];
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["act_mat"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["estado"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            //////////////////////////////////////////////////////////////////
            if ($opcion == "7") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE MOTIVO DE BAJA</h2><br>
                    <table width="50%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N&UacuteMERO </th>
                            <th class="colEnc">MOTIVO</th>
                        </tr>
                        <?php
                        $resultado = "SELECT id_motivo, motivo, case estado when 1 then 'ACTIVO' else 'INACTIVO' end estado FROM motivo_baja order by id_motivo asc";
                        $resultado = $db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["motivo"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            /////////////////////////////////////////
            if ($opcion == "8") {
                ?>
                <!-- <a href="repsis.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
                <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                        src="../theme/images/volver.jpg" width="30" height="30" /></a>

                <div id="imprime" style='overflow-y:auto;width:95%;'>
                    <h2>REPORTE GRUPO CONTABLE</h2>
                    <table width="70%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N&UacuteMERO </th>
                            <th class="colEnc">C&OacuteDIGO </th>
                            <th class="colEnc">ACR&OacuteNIMO </th>
                            <th class="colEnc">DESCRIPCI&OacuteN </th>
                            <th class="colEnc">A&NtildeOS DE VIDA &UacuteTIL </th>
                            <th class="colEnc">COEFICIENTE % </th>
                            <th class="colEnc">FECHA DE REGISTRO</th>
                        </tr>
                        <?php
                        $resultado = "SELECT g.id_grupo_contable, g.cod_contable, g.cod_resumen, g.descripcion, g.vida_util, g.depcoef, g.fecha_reg, 
                                        case g.estado when 1 then 'ACTIVO' else 'INACTIVO' end 
                                        FROM grupo_contable g  
                                        order by g.id_grupo_contable";
                        $resultado = $db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {

                            foreach ($resultado as $fila) {
                                $i = $i + 1;
                                ?>
                                <tr bgcolor="#F2F9FF">
                                    <th scope="row" class="colDat">
                                        <?php echo $i; ?>
                                    </th>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_contable"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["cod_resumen"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["descripcion"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["vida_util"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo round(($fila["depcoef"]*100),2); echo ' %'; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["fecha_reg"]; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <?php
            }
            //////////////////////////////////////////////////////////////////
            if ($opcion == "76") {
                $id_personal = $_REQUEST["id_personal"];
                ?>
                <div id="imprime" style='overflow-y:auto;width:95%;'>

                    <?php
                    $consuu = "SELECT numero, max(numero) as maximo FROM csa.asignacion_activos WHERE id_personal=$id_personal group by numero ";
                    $resuu = $db->query($consuu);
                    if (count($resuu) > 0) {
                        foreach ($resuu as $filu) {
                            $maximo = $filu["maximo"];

                            $consa = "SELECT * FROM personal WHERE id_personal=$id_personal ";
                            $resa = $db->query($consa);
                            if (count($resa) > 0) {
                                foreach ($resa as $filaa) {


                                    ?>
                                    <div align="center">
                                        <table width="auto">
                                            <tr>
                                                <td width="300"><img src="../theme/img/manual_Cooperativas.jpg" width="186" height="100" /></td>
                                                <td align="center">
                                                    <h2>FORMULARIO DE ASIGNACIÓN</h2>
                                                    <h3>INDIVIDUAL DE ACTIVOS FIJOS</h3>
                                                </td>
                                                <td width="300" align="right">
                                                    <h1>
                                                        <?php echo $maximo; ?>
                                                    </h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <h3 align="right">FECHA ACTUAL:
                                        <?php echo date('d/m/Y') ?>
                                    </h3>
                                    <table width="90%" height="55" style="border:1px;" align="center">
                                        <tr>
                                            <td>
                                                <h3> RESPONSABLE:
                                                    <?php
                                                    echo $filaa["paterno_personal"];
                                                    echo " ";
                                                    echo $filaa["materno_personal"];
                                                    echo " ";
                                                    echo $filaa["nom_personal"];
                                                    ?>
                                                </h3>
                                                <h3> CARGO:
                                                    <?php echo $filaa["cargo_personal"]; ?>
                                                </h3>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="90%" height="55" style="border:1px;" align="center" border="1">
                                        <tr bgcolor='#CCCFF1'>
                                            <th class="colEnc">N°</th>
                                            <th class="colEnc">CÓDIGO </th>
                                            <th class="colEnc">DESCRIPCIÓN</th>
                                            <th class="colEnc">ESTADO </th>
                                            <th class="colEnc">OBSERVACIONES</th>
                                        </tr>

                                        <?php
                                        $consulta1 = "SELECT p.id_personal, p.nom_personal,  p.paterno_personal,  p.materno_personal, p.cargo_personal, a.od_clas_am, a.codigo, ra.id_regact, aa.numero, extract(year from ra.fecha_compra::date) as anio, ri.descripcion_act, ea.est_tec, aa.observaciones
FROM csa.personal p, csa.activo a, csa.registro_activos ra, csa.asignacion_activos aa, csa.estado_activo ea, csa.registro_individual ri
WHERE ri.id_act=a.codigo and ra.id_regact=ri.id_regact and ri.id_regind=aa.id_regact and p.id_personal=aa.id_personal and ri.estado_activo=ea.id_estado and aa.estado=true and ri.estado=true and p.id_personal=$id_personal and aa.numero=$maximo";

                                        $resultado1 = $db->query($consulta1);
                                        $i = 0;
                                        if (count($resultado1) > 0) {
                                            foreach ($resultado1 as $fila1) {
                                                $id = $fila1[0];
                                                $i = $i + 1;
                                                ?>
                                                <tr bgcolor="#F2F9FF">
                                                    <th align="center" class="colDat">
                                                        <?php echo $i; ?>
                                                    </th>
                                                    <th align="center" class="colDat">
                                                        <?php
                                                        echo $fila1["od_clas_am"];
                                                        echo '-';
                                                        echo $fila1["codigo"];
                                                        echo '-';
                                                        echo $fila1["id_regact"];
                                                        echo '-';
                                                        echo $fila1["anio"];
                                                        ?>
                                                    </th>
                                                    <th align="center" class="colDat">
                                                        <?php echo $fila1["descripcion_act"]; ?>
                                                    </th>
                                                    <th align="center" class="colDat">
                                                        <?php echo $fila1["est_tec"]; ?>
                                                    </th>
                                                    <th align="center" class="colDat">
                                                        <?php echo $fila1["observaciones"]; ?>
                                                    </th>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table><br />

                                    <h3 align="justify">NOTA: A PARTIR DE LA FECHA QUEDA COMO DEPOSITARIO DE TODOS LOS ITEMS QUE SE DETALLAN EN
                                        EL FORMULARIO, CUALQUIER PERDIDA DESTRUCCION O MALTRATO QUE PUEDA SUFRIR, SERA IMPUTADA A SU PERSONA
                                        MIENTRAS NO DEMUESTRE LO CONTRARIO.</h3>
                                    <table width="60%" height="55" style="border:1px;" align="center" border="1">
                                        <tr>
                                            <th align="center" width="15%">
                                                <p>Firma</p>
                                            </th>
                                            <th align="center" width="15%">
                                                <p>Firma</p>
                                            </th>
                                            <th align="center" width="15%">
                                                <p>Firma</p>
                                            </th>
                                            <th align="center" width="15%">
                                                <p>Firma</p>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td align="center" style="padding-top: 100px;" width="15%">
                                                <p>RECIBIDO POR</p>
                                            </td>
                                            <td align="center" style="padding-top: 100px;" width="15%">
                                                <p>ENTREGADO POR</p>
                                            </td>
                                            <td align="center" style="padding-top: 100px;" width="15%">
                                                <p>Vo.Bo. TESORERO</p>
                                            </td>
                                            <td align="center" style="padding-top: 100px;" width="15%">
                                                <p>Vo.Bo. JEFE AREA CONTABLE</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div></br></br>
                                <center>
                                    <?php echo "<a href='pdf.php?id_personal=" . $fila1["id_personal"] . " & numero=" . $fila1["numero"] . " &op=76 'title='reporte' />" . "<img src='../theme/img/downalod-pdf.jpg' width='230' height='61'/>" . "</a>"; ?>
                                </center>
                                <p align="center">Ver tabla en PDF</p>
                            </div>
                            <?php
                                }
                            }
                        }
                    }
            }
            //////////////////////////////////////////////////////////////////
            if ($opcion == "78") {
                $id_personal = $_REQUEST["id_personal"];
                ?>
            <div id="imprime" style='overflow-y:auto;width:95%;'>

                <?php
                $consuu = "SELECT numero, max(numero) as maximo FROM csa.devolucion_activos WHERE id_personal=$id_personal group by numero ";
                $resuu = $db->query($consuu);
                if (count($resuu) > 0) {
                    foreach ($resuu as $filu) {
                        $maximo = $filu["maximo"];

                        $consa = "SELECT * FROM csa.personal WHERE id_personal=$id_personal ";
                        $resa = $db->query($consa);
                        if (count($resa) > 0) {
                            foreach ($resa as $filaa) {


                                ?>
                                <div align="center">
                                    <table width="auto">
                                        <tr>
                                            <td width="300"><img src="../theme/img/manual_Cooperativas.jpg" width="186" height="100" /></td>
                                            <td align="center">
                                                <h2>FORMULARIO DE DEVOLUCIÓN</h2>
                                                <h3>INDIVIDUAL DE ACTIVOS FIJOS</h3>
                                            </td>
                                            <td width="300" align="right">
                                                <h1>
                                                    <?php echo $maximo; ?>
                                                </h1>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <h3 align="right">FECHA ACTUAL:
                                    <?php echo date('d/m/Y') ?>
                                </h3>
                                <table width="90%" height="55" style="border:1px;" align="center">
                                    <tr>
                                        <td>
                                            <h3> RESPONSABLE:
                                                <?php
                                                echo $filaa["paterno_personal"];
                                                echo " ";
                                                echo $filaa["materno_personal"];
                                                echo " ";
                                                echo $filaa["nom_personal"];
                                                ?>
                                            </h3>
                                            <h3> CARGO:
                                                <?php echo $filaa["cargo_personal"]; ?>
                                            </h3>
                                        </td>
                                    </tr>
                                </table>
                                <table width="90%" height="55" style="border:1px;" align="center" border="1">
                                    <tr bgcolor='#CCCFF1'>
                                        <th class="colEnc">N°</th>
                                        <th class="colEnc">CÓDIGO </th>
                                        <th class="colEnc">DESCRIPCIÓN</th>
                                        <th class="colEnc">ESTADO </th>
                                        <th class="colEnc">OBSERVACIONES</th>
                                    </tr>

                                    <?php
                                    $consulta1 = "SELECT p.id_personal, p.nom_personal,  p.paterno_personal,  p.materno_personal, p.cargo_personal, a.od_clas_am, a.codigo, ra.id_regact, aa.numero, extract(year from ra.fecha_compra::date) as anio, ri.descripcion_act, ea.est_tec, aa.observaciones
FROM csa.personal p, csa.activo a, csa.registro_activos ra, csa.devolucion_activos aa, csa.estado_activo ea, csa.registro_individual ri
WHERE ri.id_act=a.codigo and ra.id_regact=ri.id_regact and ri.id_regind=aa.id_regact and p.id_personal=aa.id_personal and ri.estado_activo=ea.id_estado and aa.estado=true and ri.estado=true and p.id_personal=$id_personal and aa.numero=$maximo";

                                    $resultado1 = $db->query($consulta1);
                                    $i = 0;
                                    if (count($resultado1) > 0) {
                                        foreach ($resultado1 as $fila1) {
                                            $id = $fila1[0];
                                            $i = $i + 1;
                                            ?>
                                            <tr bgcolor="#F2F9FF">
                                                <th align="center" class="colDat">
                                                    <?php echo $i; ?>
                                                </th>
                                                <th align="center" class="colDat">
                                                    <?php
                                                    echo $fila1["od_clas_am"];
                                                    echo '-';
                                                    echo $fila1["codigo"];
                                                    echo '-';
                                                    echo $fila1["id_regact"];
                                                    echo '-';
                                                    echo $fila1["anio"];
                                                    ?>
                                                </th>
                                                <th align="center" class="colDat">
                                                    <?php echo $fila1["descripcion_act"]; ?>
                                                </th>
                                                <th align="center" class="colDat">
                                                    <?php echo $fila1["est_tec"]; ?>
                                                </th>
                                                <th align="center" class="colDat">
                                                    <?php echo $fila1["observaciones"]; ?>
                                                </th>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table><br />

                                <h3 align="justify">NOTA: A PARTIR DE LA FECHA QUEDA COMO DEPOSITARIO DE TODOS LOS ITEMS QUE SE DETALLAN EN EL
                                    FORMULARIO, CUALQUIER PERDIDA DESTRUCCION O MALTRATO QUE PUEDA SUFRIR, SERA IMPUTADA A SU PERSONA MIENTRAS
                                    NO DEMUESTRE LO CONTRARIO.</h3>
                                <table width="60%" height="55" style="border:1px;" align="center" border="1">
                                    <tr>
                                        <th align="center" width="15%">
                                            <p>Firma</p>
                                        </th>
                                        <th align="center" width="15%">
                                            <p>Firma</p>
                                        </th>
                                        <th align="center" width="15%">
                                            <p>Firma</p>
                                        </th>
                                        <th align="center" width="15%">
                                            <p>Firma</p>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td align="center" style="padding-top: 100px;" width="15%">
                                            <p>RECIBIDO POR</p>
                                        </td>
                                        <td align="center" style="padding-top: 100px;" width="15%">
                                            <p>ENTREGADO POR</p>
                                        </td>
                                        <td align="center" style="padding-top: 100px;" width="15%">
                                            <p>Vo.Bo. TESORERO</p>
                                        </td>
                                        <td align="center" style="padding-top: 100px;" width="15%">
                                            <p>Vo.Bo. JEFE AREA CONTABLE</p>
                                        </td>
                                    </tr>
                                </table>
                            </div></br></br>
                            <center>
                                <?php echo "<a href='pdf.php?id_personal=" . $fila1["id_personal"] . " & numero=" . $fila1["numero"] . " &op=76 'title='reporte' />" . "<img src='../theme/img/downalod-pdf.jpg' width='230' height='61'/>" . "</a>"; ?>
                            </center>
                            <p align="center">Ver tabla en PDF</p>
                            </div>
                            <?php
                            }
                        }
                    }
                }
            }

            //////////////////////////////////////////////////////////////////
            if ($opcion == "77") {
                $id_regact = $_REQUEST["id_regact"];
                $fac = "SELECT factura FROM registro_activos WHERE id_registro_Activos=$id_regact";
                $factura = $db->query($fac);
                $factura = $factura->fetchAll(PDO::FETCH_ASSOC);
                ?>
            <!-- <a href="../mod_cert/activos.php"><img src="../theme/images/volver.jpg" width="30" height="30" /></a> -->
            <a href="<?php echo "../index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_k")) ?>"><img
                    src="../theme/images/volver.jpg" width="30" height="30" /></a>


            <div id="imprime" style='overflow-y:auto;width:95%;'>
                <h2>DETALLE DE COMPRA</h2>
                <h2>FACTURA
                    <?php echo $factura[0]['factura']; ?>
                </h2>
                <table width="90%" height="55" style="border:1px;" align="center">
                    <tr bgcolor='#CCCFF1'>
                        <th class="colEnc">N&UacuteMERO </th>
                        <th class="colEnc">REGISTRO</th>
                        <th class="colEnc">ACTIVO</th>
                        <th class="colEnc">CORRELATIVO</th>
                        <th class="colEnc">GESTI&OacuteN </th>
                        <th class="colEnc">RECIBIDO POR</th>
                        <th class="colEnc">DESCRIPCI&OacuteN</th>
                        <th class="colEnc">MARCA</th>
                        <th class="colEnc">MODELO</th>
                        <th class="colEnc">SERIE</th>
                        <th class="colEnc">COSTO</th>
                        <th class="colEnc">OBSERVACIONES</th>
                    </tr>
                    <?php
                    $consulta = "SELECT ri.id_registro_activos, ri.id_activo, ri.correlativo_cantidad, ri.gestion, concat(p.nombres,' ', p.apaterno,' ',p.amaterno) as nom_personal, ri.descripcion_act, ri.marca, ri.modelo, ri.serie, ri.costo, ri.observaciones 
                        FROM registro_individual ri, personal p, registro_activos ra
                        WHERE ri.id_registro_activos=$id_regact and ra.id_registro_activos=ri.id_registro_activos and ra.id_urecibido=p.id_personal
                        order by ri.correlativo_cantidad;";
                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $i = 0;
                    if (count($resultado) > 0) {

                        foreach ($resultado as $fila) {
                            $i = $i + 1;
                            ?>
                            <tr bgcolor="#F2F9FF">
                                <th scope="row" class="colDat">
                                    <?php echo $i; ?>
                                </th>
                                <td align="center" class="colDat">
                                    <?php echo $fila["id_registro_activos"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["id_activo"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["correlativo_cantidad"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["gestion"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["nom_personal"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["descripcion_act"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["marca"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["modelo"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["serie"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["costo"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["observaciones"]; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    $db = null;
                    ?>
                </table>
            </div>
            <?php
            }

            $db = null;
        } catch (PDOException $e) {
            echo "Se tiene un problema con la conexion.<br>Mensaje de error: " . $e->getMessage() . "<br>Por favor comuniquese con personal de sistemas.";
        }
        ?>
    </div>
    <?php
    require("../theme/footer_inicio.php");
} else
    header('Location: ../index.php');
?>