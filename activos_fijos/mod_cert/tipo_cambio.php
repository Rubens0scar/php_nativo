<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
    ?>
    <script language="javascript">
        function visibilidadDiv(id) {
            div = document.getElementById(id);
            document.getElementById("sus_v").value = '';
            document.getElementById("sus_c").value = '';
            document.getElementById("ufv_v").value = '';
            if (div.style.display == "block") {
                div.style.display = "none";
            } else {
                div.style.display = "block";
            }
        }
    </script>

    <br><br>
    <?php
    include_once 'mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();


    if (!isset($_REQUEST["id"])) {
        ?>
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=1">
            <center>
                <div class="estilo_div">
                    <div align="right"><a
                            href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_3")) ?>"><img
                                src="theme/images/volver.jpg" width="30" height="30" /><strong>VOLVER</strong></a></div>
                    <table>
                        <tr>
                            <td class="titulo">Tipo de Cambio</td>
                        </tr>
                        <tr>
                            <td class="subtitulo" style="text-align: center">Dolares y UFV</td>
                        </tr>
                    </table><br>
                    <button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registrar Tipo de Cambio (Dolares y UFV)
                        (Dolares)</button><br><br>

                    <div id="nuevo" style="display: none;" class="estilo_subdiv">
                        <center>
                            <table>
                                <tr>
                                    <td colspan="2" class="subtitulo" style="text-align: center">Registrar</td>
                                </tr>
                                <tr style="height: 10px">
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Fecha:</td>
                                    <td><input type="date" id="fecha" name="fecha" style="text-align: center" required /></td>
                                </tr>
                                <tr>
                                    <td>Dolar Venta:</td>
                                    <td><input type="text" id="sus_v" name="sus_v"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="10" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required /></td>
                                </tr> 
                                <tr>
                                    <td>Dolar Compra:</td>
                                    <td><input type="text" id="sus_c" name="sus_c"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="10" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required /></td>
                                </tr>
                                <tr>
                                    <td>UFV:</td>
                                    <td><input type="text" id="ufv_v" name="ufv_v"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="10" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required /></td>
                                </tr>                               
                                
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="GUARDAR" class="button">
                            <input id="cancelar" type="button" value="CANCELAR" class="button"
                                onclick="javascript: visibilidadDiv('nuevo');">
                        </center>

                        <br>
                    </div>
                    <!--div id="nuevo" style="display: none;" class="estilo_subdiv"-->
                    <br>
                    <table width="90%" height="55" style="border:1px;" align="center">
                        <thead>
                            <tr bgcolor='#CCCFF1'>
                                <th class="colEnc">FECHA</th>
                                <th class="colEnc">DOLAR VENTA</th>
                                <th class="colEnc">DOLAR COMPRA</th>
                                <th class="colEnc">UFV</th>
                                <th class="colEnc">QUIEN REGISTRO</th>
                                <th class="colEnc" colspan="2">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultado = "SELECT top 10 t.id_tipo_cambio, t.fecha_reg, t.sus_venta, t.sus_compra, ufv_venta, concat(p.nombres,' ',p.apaterno,' ',p.amaterno) nom_personal
                                    FROM tipo_cambio t, personal p, usuarios u
                                    WHERE t.estado=1 and t.id_usuario_reg=u.id_usuario and u.id_personal=p.id_personal
                                    order by CAST(t.fecha_reg AS varchar(max)) desc";
                            $resultado = $db->query($resultado);
                            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

                            $i = 0;
                            if (count($resultado) > 0) {
                                foreach ($resultado as $fila) {
                                    $i = $i + 1;
                                    ?>
                                    <tr bgcolor="#F2F9FF">
                                        <td align="center" class="colDat">
                                            <?php echo $fila["fecha_reg"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo round($fila["sus_venta"], 2); ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo round($fila["sus_compra"], 2); ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo round($fila["ufv_venta"], 5); ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["nom_personal"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <!-- <a href="mod_cert/tipo_cambio.php?id=<?php echo $fila["id_tipo_cambio"]; ?>"><img src="mod_cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a> -->
                                            <a href="attached.php?op=1&id=<?php echo $fila["id_tipo_cambio"]; ?>"><img
                                                    src="mod_cert/images/6.png" alt="" title="MODIFICAR"
                                                    style="width: 20px; height: 20px" /></a>
                                        </td>
                                        <!--<td align="center" class="colDat">MODIFICAR</td>-->
                                    </tr>
                                    <?php
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                    <br>
                    </!--div>
            </center>
        </form>
        <?php
    } else {
        $id = $_REQUEST["id"];
        $resultado = "SELECT fecha_reg, sus_venta, sus_compra, ufv_venta, case estado when 1 then 1 else 0 end estado FROM tipo_cambio where id_tipo_cambio=$id";
        $resultado = $db->query($resultado);
        foreach ($resultado as $fila) {
            $fecha = $fila[0];
            $sus_venta = round($fila[1], 2);
            $sus_compra = round($fila[2], 2);
            $estado = $fila[5];
        }
        ?>
        <form name="match_form" method="post" action="guardar.php?op=14&d=<?= $id ?>">
            <center>
                <div class="estilo_div">
                    <table>
                        <tr>
                            <td class="titulo">Tipo de Cambio</td>
                        </tr>
                        <tr>
                            <td class="subtitulo" style="text-align: center">Dolares</td>
                        </tr>
                    </table><br>

                    <div id="nuevo" class="estilo_subdiv">
                        <center>
                            <table>
                                <tr>
                                    <td colspan="2" class="subtitulo" style="text-align: center">Modificar</td>
                                </tr>
                                <tr style="height: 10px">
                                    <td></td>
                                    <td></td>
                                </tr>
                                <!--<tr><td>Fecha:</td><td><div class="date_input"><script class="inputs">DateInput('fecha', true, 'DD-MM-YYYY')</script> </div></td></tr>-->
                                <tr>
                                    <td>Dolar Venta:</td>
                                    <td><input type="text" id="sus_v" name="sus_v"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="10" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required value="<?= $sus_venta ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Dolar Compra:</td>
                                    <td><input type="text" id="sus_c" name="sus_c"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="10" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required value="<?= $sus_compra ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>UFV:</td>
                                    <td><input type="text" id="ufv_v" name="ufv_v"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="10" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required value="<?= $sus_venta ?>" /></td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="MODIFICAR" class="button">
                            <a href="tipo_cambio.php"><input id="cancelar" type="button" value="CANCELAR" class="button"></a>
                        </center>

                        <br>
                    </div>
                    <br>
                </div>
            </center>
            <?php
    }
    ?>
    </form>
    <?php
    $db = null;
    require("theme/footer_inicio.php");
} else
    header('Location: index.php');
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