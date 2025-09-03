<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
    ?>
    <script language="javascript">
        function visibilidadDiv(id) {
            div = document.getElementById(id);
            document.getElementById("nombre").value = '';
            document.getElementById("codigo").value = '';

            if (div.style.display == "block") {
                div.style.display = "none";
            } else {
                div.style.display = "block";
            }
        }
    </script>
    <br><br><br><br>
    <?php
    include_once 'mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();
    if (!isset($_REQUEST["id"])) {
        ?>
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=3">
            <center>
                <div class="estilo_div">
                    <div align="right"><a href="<?php echo "index.php?ruta=".urlencode(generarCodigoSeguro("pagina_3")) ?>"><img src="theme/images/volver.jpg" width="30"
                                height="30" /><strong>VOLVER</strong></a></div>
                    <table>
                        <tr>
                            <td class="titulo">Departamentos</td>
                        </tr>
                    </table><br>
                    <button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registar Departamento</button><br><br>

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
                                    <td>Código Departamento: </td>
                                    <td><input type="text" id="codigo" name="codigo"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="5" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required /></td>
                                </tr>
                                <tr>
                                    <td>Nombre del Departamento: </td>
                                    <td><input type="text" id="nombre" name="nombre"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="50" class="inputs"
                                            required /></td>
                                </tr>
                                <tr>
                                    <td>Vigencia de Departamento: </td>
                                    <td><input type="radio" name="activo" value="1"> Activo<br><input type="radio" name="activo"
                                            value="0"> Inactivo</td>
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
                    <br>
                    <div style='overflow-y:auto;width:95%;'>
                        <table width="90%" height="55" style="border:1px;" align="center">
                            <tr bgcolor='#CCCFF1'>
                                <th class="colEnc">Código Departamento</th>
                                <th class="colEnc">Nombre</th>
                                <th class="colEnc">Vigencia</th>
                                <th class="colEnc" colspan="2">ACCIONES</th>
                            </tr>
                            <?php
                            $resultado = "SELECT id_departamento, codigo_departamento, nom_departamento, case estado when 1 then 'ACTIVO' else 'INACTIVO' end estado 
                                        FROM departamentos
                                        order by codigo_departamento";
                            $resultado = $db->query($resultado);
                            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                            $i = 0;
                            if (count($resultado) > 0) {
                                foreach ($resultado as $fila) {
                                    $i = $i + 1;
                                    ?>
                                    <tr bgcolor="#F2F9FF">
                                        <td align="center" class="colDat">
                                            <?php echo $fila["codigo_departamento"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["nom_departamento"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["estado"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <!-- <a href="departamentos.php?id=<?php echo $fila["id_departamento"]; ?>"><img src="mod_Cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a> -->
                                            <a href="attached.php?op=2&id=<?php echo $fila["id_departamento"]; ?>"><img src="mod_cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <br>
                </div>
            </center>
        </form>

        <?php
    } else {
        $id = $_REQUEST["id"];
        $resultado = "SELECT codigo_departamento, nom_departamento, case estado when 1 then 1 else 0 end estado FROM departamentos where id_departamento=$id";
        $resultado = $db->query($resultado);
        foreach ($resultado as $fila) {
            $codigo = $fila[0];
            $nombre = $fila[1];
            $estado = $fila[2];
        }
        ?>
        </table>
        </div>
        <form name="match_form" method="post" action="guardar.php?op=11&d=<?= $id ?>">
            <center>
                <div class="estilo_div">
                    <table>
                        <tr>
                            <td class="titulo">Departamentos</td>
                        </tr>
                        <!--<tr><td class="subtitulo" style="text-align: center">De la institución</td></tr>-->
                    </table><br>
                    <!--<button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registar Departamento</button><br><br>-->

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
                                <tr>
                                    <td>Código Departamento: </td>
                                    <td><input type="text" id="codigo" name="codigo"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="5" class="inputs"
                                            onkeypress="return NumCheck(event, this)" required value="<?= $codigo ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Nombre del Departamento: </td>
                                    <td><input type="text" id="nombre" name="nombre"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="50" class="inputs"
                                            required value="<?= $nombre ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Vigencia de Departamento: </td>
                                    <td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : ''; ?>> Activo
                                        <input type="radio" name="activo" value="0" <?= $estado == 0 ? 'checked' : ''; ?>> Inactivo
                                    </td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="MODIFICAR" class="button">
                            <a href="departamentos.php"><input id="cancelar_mod" name="cancelar_mod" type="button"
                                    value="CANCELAR" class="button"></a>
                        </center>
                        <br>
                    </div>
            </center>
        <?php }
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