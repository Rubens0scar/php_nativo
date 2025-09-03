<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
    ?>
    <script language="javascript">
        function visibilidadDiv(id) {
            div = document.getElementById(id);
            document.getElementById("empresa").value = '';
            document.getElementById("nit").value = '';
            document.getElementById("direccion").value = '';
            document.getElementById("fono").value = '';
            document.getElementById("correo").value = '';
            document.getElementById("contacto").value = '';

            if (div.style.display == "block") {
                div.style.display = "none";
            } else {
                div.style.display = "block";
            }
        }
        function numeros(e){
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = " 0123456789";
            especiales = [8,37,39,46];
        
            tecla_especial = false
            for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
                } 
            }
        
            if(letras.indexOf(tecla)==-1 && !tecla_especial)
                return false;
        }
    </script>
    <br><br><br><br>
    <?php
    include_once 'mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();
    if (!isset($_REQUEST["id"])) {
        ?>
        <form name="match_form" method="post" action="mod_Cert/guardar.php?op=4">
            <center>
                <div class="estilo_div">
                    <div align="right"><a href="<?php echo "index.php?ruta=".urlencode(generarCodigoSeguro("pagina_3")) ?>"><img src="theme/images/volver.jpg" width="30"
                                height="30" /><strong>VOLVER</strong></a></div>
                    <table>
                        <tr>
                            <td class="titulo">Empresas Proveedoras</td>
                        </tr>
                        <tr>
                            <td class="subtitulo" style="text-align: center">Del Restaurante</td>
                        </tr>
                    </table><br>
                    <button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registar
                        Empresa</button><br><br>

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
                                    <td>Nombre Empresa: </td>
                                    <td><input type="text" id="empresa" name="empresa"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="60" class="inputs"
                                            required /></td>
                                </tr>
                                <tr>
                                    <td>NIT: </td>
                                    <td><input type="text" id="nit" name="nit"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="20"
                                            onkeypress="return numeros(event)" class="inputs" required /></td>
                                </tr>
                                <tr>
                                    <td>Dirección: </td>
                                    <td><textarea id="direccion" rows="3" name="direccion"
                                            style="width:82%; text-align: center;" class="inputs" required>
                                        </textarea></td>
                                    
                                </tr>
                                <tr>
                                    <td>Telefonos: </td>
                                    <td><input type="text" id="fono" name="fono"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="16" class="inputs"
                                            onkeypress="return numeros(event)" required /></td>
                                </tr>
                                <tr>
                                    <td>Correo: </td>
                                    <td><input type="text" id="correo" name="correo"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="60" class="inputs"
                                            required /></td>
                                </tr>
                                <tr>
                                    <td>Contacto: </td>
                                    <td><input type="text" id="contacto" name="contacto"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="60" class="inputs"
                                            required /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="radio" name="activo" value="1" checked="checked"> Activo<br><input
                                            type="radio" name="activo" value="0"> Inactivo</td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="GUARDAR" class="button">
                            <input id="cancelar" type="button" value="cancelar" class="button"
                                onclick="javascript: visibilidadDiv('nuevo');">
                        </center>

                        <br>
                    </div>
                    <br>
                    <div style='overflow-y:auto;width:95%;'>
                        <table width="90%" height="55" style="border:1px;" align="center">
                            <tr bgcolor='#CCCFF1'>
                                <th class="colEnc">ID</th>
                                <th class="colEnc">Nombre Empresa</th>
                                <th class="colEnc">NIT</th>
                                <th class="colEnc">Dirección</th>
                                <th class="colEnc">Telefonos</th>
                                <th class="colEnc">Correo</th>
                                <th class="colEnc" colspan="2">ACCIONES</th>
                            </tr>
                            <?php
                            $consulta = "SELECT id_empresa, empresa, nit, direccion, telefonos, correo, contacto, case estado when '1' then 'ACTIVO' else 'NO ACTIVO' end estado FROM empresas order by id_empresa desc";
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
                                            <?php echo $fila["empresa"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["nit"]; ?>
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
                                            <!-- <a href="empresas_prov.php?id=<?php echo $fila["id_empresa"]; ?>"><img src="images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a></td> -->
                                            <a href="attached.php?op=4&id=<?php echo $fila["id_empresa"]; ?>"><img src="mod_cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a>
                                        <!--<td align="center" class="colDat">MODIFICAR</td>-->
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
            <?php
    } else {
        $id = $_REQUEST["id"];
        $resultado = "SELECT empresa, nit, direccion, telefonos, correo, contacto, case estado when 1 then 1 else 0 end estado FROM empresas WHERE id_empresa=$id;";
        $resultado = $db->query($resultado);
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultado as $fila) {
            $empresa = $fila['empresa'];
            $nit = $fila['nit'];
            $direccion = $fila['direccion'];
            $telefonos = $fila['telefonos'];
            $correo = $fila['correo'];
            $contacto = $fila['contacto'];
            $estado = $fila['estado'];
        }
        ?>
            <form name="match_form" method="post" action="guardar.php?op=15&d=<?= $id ?>">
                <center>
                    <div class="estilo_div">
                        <table>
                            <tr>
                                <td class="titulo">Empresas Proveedoras</td>
                            </tr>
                            <tr>
                                <td class="subtitulo" style="text-align: center">De la institución</td>
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
                                    <tr>
                                        <td>Nombre Empresa: </td>
                                        <td><input type="text" id="empresa" name="empresa"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="60"
                                                class="inputs" required value="<?= $empresa ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>NIT: </td>
                                        <td><input type="text" id="nit" name="nit"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="20"
                                                onkeypress="return numeros(event)" class="inputs" required
                                                value="<?= $nit ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Dirección: </td>
                                        <td><input type="text" id="direccion" name="direccion"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="60"
                                                class="inputs" required value="<?= $direccion ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Telefonos: </td>
                                        <td><input type="text" id="fono" name="fono"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="16"
                                                class="inputs" onkeypress="return numeros(event)" required
                                                value="<?= $telefonos ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Correo: </td>
                                        <td><input type="text" id="correo" name="correo"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="60"
                                                class="inputs" required value="<?= $correo ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Contacto: </td>
                                        <td><input type="text" id="contacto" name="contacto"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="60"
                                                class="inputs" required value="<?= $contacto ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : '' ?>>
                                            Activo<br><input type="radio" name="activo" value="0"
                                                <?= $estado == 0 ? 'checked' : '' ?>> Inactivo</td>
                                    </tr>
                                </table>
                            </center>
                            <br>
                            <center>
                                <input type="submit" value="MODIFICAR" class="button">
                                <a href="empresas_prov.php"><input id="cancelar" type="button" value="CANCELAR"
                                        class="button"></a>
                            </center>

                            <br>
                        </div>
                        <br>

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