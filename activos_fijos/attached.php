<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
    include_once 'mod_configuracion/clases/conexion.php';

    $db = Core::Conectar();

    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '1') {

        $id = $_REQUEST["id"];
        $resultado = "SELECT fecha_reg, sus_venta, sus_compra, ufv_venta, case estado when 1 then 1 else 0 end estado FROM tipo_cambio where id_tipo_cambio=$id";
        $resultado = $db->query($resultado);
        foreach ($resultado as $fila) {
            $fecha = $fila[0];
            $sus_venta = round($fila[1], 2);
            $sus_compra = round($fila[2], 2);
            $ufv_venta = round($fila[3], 2);
            $estado = $fila[4];
        }
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
        <br><br><br><br>
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=14&d=<?= $id ?>">
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
                                            onkeypress="return NumCheck(event, this)" required value="<?= $ufv_venta ?>" /></td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="MODIFICAR" class="button">
                            <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_d")) ?>"><input id="cancelar" type="button" value="CANCELAR" class="button"></a>
                        </center>

                        <br>
                    </div>
                    <br>
                </div>
            </center>
        </form>
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
        <?php
        $db = null;
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '2') {
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
            $db = Core::Conectar();
            $id = $_REQUEST["id"];
            $resultado = "SELECT codigo_departamento, nom_departamento, case estado when 1 then 1 else 0 end estado FROM departamentos where id_departamento=$id";
            $resultado = $db->query($resultado);
            foreach ($resultado as $fila) {
                $codigo = $fila[0];
                $nombre = $fila[1];
                $estado = $fila[2];
            }
            ?>
                        
            <form name="match_form" method="post" action="mod_cert/guardar.php?op=11&d=<?= $id ?>">
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
                                <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_e")) ?>"><input id="cancelar_mod" name="cancelar_mod" type="button" value="CANCELAR" class="button"></a>
                            </center>
                            <br>
                        </div>
                </center>
        </form>
        <?php
        $db = null;
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
        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '3') {
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
        $db = Core::Conectar();
        $id = $_REQUEST["id"];
        $resultado = "SELECT id_departamento, codigo_area, nom_area, case estado when 1 then 1 else 0 end estado FROM area where id_area=$id";
        $resultado = $db->query($resultado);
        foreach ($resultado as $fila) {
            $id_dpto = $fila[0];
            $cd_cnt_area = $fila[1];
            $nom_area = $fila[2];
            $estado = $fila[3];
        }
        ?>
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=13&d=<?= $id; ?>">
            <center>
                <div class="estilo_div">
                    <table>
                        <tr>
                            <td class="titulo">Áreas</td>
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
                                    <td>Código contable de Área: </td>
                                    <td><input type="text" id="codigo" name="codigo"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="5"
                                            class="inputs" onkeypress="return NumCheck(event, this)" required
                                            value="<?= $cd_cnt_area ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Nombre del Área: </td>
                                    <td><input type="text" id="nombre" name="nombre"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="50"
                                            class="inputs" required value="<?= $nom_area ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Departamento:</td>
                                    <td>
                                        <select id="id_dpto" name="id_dpto"
                                            style="height: 20px; width: 82%; text-align: center;" class="inputs" required>
                                            <option value="">-SELECCIONAR-</option>
                                            <?php
                                            $consulta = "SELECT id_departamento, codigo_departamento, nom_departamento FROM departamentos where estado=1;";
                                            $resultado = $db->query($consulta);
                                            foreach ($resultado as $fila) {
                                                $p = "";
                                                if ($id_dpto == $fila["id_departamento"])
                                                    $p = "selected";
                                                ?>
                                                    <option value="<?php echo $fila["id_departamento"]; ?>" <?= $p ?>><?php echo $fila["nom_departamento"]; ?></option>
                                                    <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Vigencia de Área: </td>
                                    <td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : ''; ?>>
                                        Activo<br><input type="radio" name="activo" value="0"
                                            <?= $estado == 0 ? 'checked' : ''; ?>> Inactivo</td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="MODIFICAR" class="button">
                            <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_f")) ?>"><input id="cancelar_mod" name="cancelar_mod" type="button" value="CANCELAR" class="button"></a>
                        </center>

                        <br>
                    </div>
                    <br>
                </div>
            </center>
        </form>
    <?php
    $db = null;
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
        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '4') {
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
        $db = Core::Conectar();

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
            <form name="match_form" method="post" action="mod_Cert/guardar.php?op=15&d=<?= $id ?>">
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
                                        <td><textarea id="direccion" rows="3" name="direccion"
                                            style="width:82%; text-align: center;" class="inputs" required><?php echo $direccion ?>
                                        </textarea></td>
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
                                <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_g")) ?>"><input id="cancelar" type="button" value="CANCELAR" class="button"></a>
                            </center>

                            <br>
                        </div>
                        <br>

                        <br>
                    </div>
                </center>
        </form>
        <?php
        $db = null;
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

        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '5') {
        ?>
        <script language="javascript">        
                function visibilidadDiv(id) {
                    div = document.getElementById(id);
                    document.getElementById("motivo").value='';
            
                    if (div.style.display == "block") {
                        div.style.display = "none";
                    } else {
                        div.style.display = "block";
                    }
                }
        </script>
        <style>
            .button{
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

            .button:hover{
                background: #365D9D;
                background: linear-gradient(left, #365D9D, #436CAD);
                background: -moz-linear-gradient(left, #365D9D, #436CAD);
                background: -webkit-linear-gradient(left, #365D9D, #436CAD);
                background: -o-linear-gradient(left, #365D9D, #436CAD);
                color: #FFFFFF;
                border-color: #FBFFAD;
            }
            .estilo_div{
                border:solid 10px #ccc;
                border-radius:15px;
                box-shadow: 8px 8px 10px 0px #818181;
                width:850px;
            }
            .titulo{
                font-family: algerian;
                color: #001459;
            font-size: 180%;
            }
            .subtitulo{
                font-family: algerian;
            /*color: lightblue;*/
                color: #001459;
            font-size: 120%;
            }

            .estilo_subdiv{
                border:solid 3px #ccc;
                border-radius:15px;
                width:450px;
            }
            .inputs{
                float: none;
            padding: 0px;
            font-size: small;
                font-family: verdana;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            border: 1px solid rgb(182, 182, 182);
            color: rgb(51,51,51);
            }
    
            .colEnc{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
                background: #CED4D9;
            }
            .colDat{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
            }
        </style><br><br><br><br>
        <?php
        $db = Core::Conectar();
        $id = $_REQUEST["id"];
        $resultado = "SELECT motivo, case estado when 1 then 1 else 0 end estado FROM motivo_baja where id_motivo=$id";
        $resultado = $db->query($resultado);
        foreach ($resultado as $fila) {
            $motivo = $fila[0];
            $estado = $fila[1];
        }
        ?>    
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=18&d=<?= $id ?>">
            <center>
            <div class="estilo_div" >
                <table><tr><td class="titulo">MOTIVO DE LA BAJA</td></tr>   
                </table><br>
        
                <div id="nuevo" class="estilo_subdiv">        
                    <center>
                    <table>
                        <tr><td colspan="2" class="subtitulo" style="text-align: center">Modificar</td></tr>
                        <tr style="height: 10px"><td></td><td></td></tr>
                        <tr><td>Motivo:</td><td><textarea name="motivo" id="motivo" rows="5" cols="20" ><?= $motivo ?></textarea></td></tr>
                        <tr><td>&nbsp;</td><td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : '' ?>> Activo<br><input type="radio" name="activo" value="0" <?= $estado == 0 ? 'checked' : '' ?>> Inactivo</td></tr>
                    </table>
                    </center>
                    <br>
                    <center>
                        <input type="submit" value="GUARDAR" class="button">
                        <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_h")) ?>"><input id="CANCELAR" type="button" value="CANCELAR" class="button"></a>
                    </center>
            
                    <br>
                </div>       
                <br>
            </div>
            </center>
        </form>
        <?php
        $db = null;
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '6') {
        ?>
        <script language="javascript">        
                function visibilidadDiv(id) {
                    div = document.getElementById(id);
                    document.getElementById("completo").value='';
                    document.getElementById("simple").value='';
                    document.getElementById("des").value='';
                    document.getElementById("anio").value='';
                    document.getElementById("porcentaje").value='';
            
                    if (div.style.display == "block") {
                        div.style.display = "none";
                    } else {
                        div.style.display = "block";
                    }
                }
        </script>
        <br><br><br><br>
        <?php
        $db = Core::Conectar();
        $id = $_REQUEST["id"];
        $resultado = "SELECT cod_contable, cod_resumen, descripcion, vida_util, depcoef, case estado when 1 then 1 else 0 end estado FROM grupo_contable where id_grupo_contable=$id;";
        $resultado = $db->query($resultado);
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultado as $fila) {
            $gc_cnta_cm = $fila['cod_contable'];
            $gc_cnta_sp = $fila['cod_resumen'];
            $descripcion = $fila['descripcion'];
            $depvidut = $fila['vida_util'];
            $depcoef = round($fila['depcoef'], 2);
            $estado = $fila['estado'];
        }
        ?>    
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=17&d=<?= $id ?>">
            <center>
            <div class="estilo_div" >
                <table><tr><td class="titulo">GRUPO CONTABLE DE ACTIVOS FIJOS</td></tr>   
                </table><br>
        
                <div id="nuevo" class="estilo_subdiv">        
                    <center>
                    <table>
                        <tr><td colspan="2" class="subtitulo" style="text-align: center">Modificar</td></tr>
                        <tr style="height: 10px"><td></td><td></td></tr>                
            
                        <tr><td>Código Contable Completo: </td><td><input type="text" id="completo" name="completo" style="height: 20px; width:82%; text-align: center;" maxlength="20" onkeypress="return numeros(event)" class="inputs" required value="<?= $gc_cnta_cm ?>"/></td></tr>
                        <tr><td>Código Contable Simple: </td><td><input type="text" id="simple" name="simple" style="height: 20px; width:82%; text-align: center;" maxlength="100" class="inputs" onkeypress="return numeros(event)" required value="<?= $gc_cnta_sp ?>"/></td></tr>
                        <tr><td>Descripción: </td><td><input type="text" id="des" name="des" style="height: 20px; width:82%; text-align: center;" maxlength="100" class="inputs" required value="<?= $descripcion ?>"/></td></tr>
                        <tr><td>Años de Depreciación: </td><td><input type="text" id="anio" name="anio" style="height: 20px; width:82%; text-align: center;" maxlength="20" class="inputs" required value="<?= $depvidut ?>"/></td></tr>
                        <tr><td>Porcentaje de Depreciación: </td><td><input type="text" id="porcentaje" name="porcentaje" style="height: 20px; width:82%; text-align: center;" maxlength="20" class="inputs" required value="<?= $depcoef ?>"/></td></tr>
                        <tr><td>&nbsp;</td><td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : '' ?>> Activo<br><input type="radio" name="activo" value="0" <?= $estado == 0 ? 'checked' : '' ?>> Inactivo</td></tr>
                    </table>
                    </center>
                    <br>
                    <center>
                        <input type="submit" value="MODIFICAR" class="button">
                        <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_i")) ?>"><input id="cancelar" type="button" value="CANCELAR" class="button"></a>
                    </center>
            
                    <br>
                </div>
                <br>
        
            </div>
            </center>
        </form>
        <?php
        $db = null;
        ?>
        <style>
            .button{
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

            .button:hover{
                background: #365D9D;
                background: linear-gradient(left, #365D9D, #436CAD);
                background: -moz-linear-gradient(left, #365D9D, #436CAD);
                background: -webkit-linear-gradient(left, #365D9D, #436CAD);
                background: -o-linear-gradient(left, #365D9D, #436CAD);
                color: #FFFFFF;
                border-color: #FBFFAD;
            }
            .estilo_div{
                border:solid 10px #ccc;
                border-radius:15px;
                box-shadow: 8px 8px 10px 0px #818181;
                width:850px;
            }
            .titulo{
                font-family: algerian;
                color: #001459;
            font-size: 180%;
            }
            .subtitulo{
                font-family: algerian;
            /*color: lightblue;*/
                color: #001459;
            font-size: 120%;
            }

            .estilo_subdiv{
                border:solid 3px #ccc;
                border-radius:15px;
                width:450px;
            }
            .inputs{
                float: none;
            padding: 0px;
            font-size: small;
                font-family: verdana;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            border: 1px solid rgb(182, 182, 182);
            color: rgb(51,51,51);
            }
    
            .colEnc{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
                background: #CED4D9;
            }
            .colDat{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
            }
        </style>
        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '7') {
        ?>
        <script language="javascript">
            function visibilidadDiv(id) {
                div = document.getElementById(id);
                document.getElementById("nombre").value = '';
                document.getElementById("id_subg").value = '';

                if (div.style.display == "block") {
                    div.style.display = "none";
                } else {
                    div.style.display = "block";
                }
            }
        </script>
        <br><br><br><br>

        <?php
        $db = Core::Conectar();
        $id = $_REQUEST["id"];
        $resultado = "SELECT fecha_reg, id_grupo_contable, cod_subgrupo, nombre, case estado when 1 then 1 else 0 end estado FROM activo where id_activo=$id;";

        $resultado = $db->query($resultado);
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultado as $fila) {
            $id_gam = $fila['id_grupo_contable'];
            $id_subg = $fila['cod_subgrupo'];
            $nombre = $fila['nombre'];
            $estado = $fila['estado'];
        }
        ?>
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=12&d=<?= $id; ?>">
                <center>
                    <div id="nuevo" class="estilo_subdiv">
                        <center>
                            <p class="subtitulo" style="text-align: center">Modificar Clasificador de activos</p>
                            <br>
                            <table>
                                
                                <tr style="height: 10px">
                                </tr>                                        
                                    <td>Grupo Contable:</td>
                                    <td>
                                        <select id="id_gam" name="id_gam" style="height: 20px; width: 82%; text-align: center;"
                                            class="inputs" required>
                                            <option value="">-SELECCIONAR-</option>
                                            <?php
                                            $consulta = "SELECT id_grupo_contable, descripcion, cod_contable, cod_resumen  FROM grupo_contable where estado=1;";
                                            $resultado = $db->query($consulta);
                                            foreach ($resultado as $fila) {
                                                $p = "";
                                                if ($fila["id_grupo_contable"] == $id_gam)
                                                    $p = "selected";
                                                ?>
                                                    <option value="<?php echo $fila["id_grupo_contable"]; ?>" <?= $p; ?>><?php echo $fila["descripcion"]; ?></option>
                                                    <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nombre del Activo: </td>
                                    <td><input type="text" id="nombre" name="nombre"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="50" class="inputs"
                                            required value="<?= $nombre ?>" /></td>
                                </tr>
                                
                                <tr>
                                    <td>Vigencia de Activo: </td>
                                    <td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : ''; ?> >
                                        Activo<br><input type="radio" name="activo" value="0" <?= $estado == 0 ? 'checked' : ''; ?> >
                                        Inactivo</td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <center>
                            <input type="submit" value="MODIFICAR" class="button">
                            <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_j")) ?>"><input id="cancelar_mod" name="cancelar_mod" type="button" value="CANCELAR" class="button"></a>
                        </center>

                        <br>
                    </div>
                </center>
    
        </form>
        <?php
        $db = null;
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

        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '8') {
        ?>
        <script language="javascript">
            $(document).ready(function () {
                $("#costo").change(function () {
                    var a = $("#costo").val();
                    var cr = (13 * a) / 100;
                    var costo_sin_cr = a - cr;
                    $("#cr").val(cr);
                    $("#costo_sin_cr").val(costo_sin_cr);
                });

            });
            function visibilidadDiv(id) {
                div = document.getElementById(id);

                if (div.style.display == "block") {
                    div.style.display = "none";
                } else {
                    div.style.display = "block";
                }
            }

            function changeAction() {
                document.miformulario.action = "mod_cert/cBuscar.php"
                document.miformulario.submit()
            }
            function enforceNumberValidation(ele) {
                if ($(ele).data('decimal') != null) {
                    // found valid rule for decimal
                    var decimal = parseInt($(ele).data('decimal')) || 0;
                    var val = $(ele).val();
                    if (decimal > 0) {
                        var splitVal = val.split('.');
                        if (splitVal.length == 2 && splitVal[1].length > decimal) {
                            // user entered invalid input
                            $(ele).val(splitVal[0] + '.' + splitVal[1].substr(0, decimal));
                        }
                    } else if (decimal == 0) {
                        // do not allow decimal place
                        var splitVal = val.split('.');
                        if (splitVal.length > 1) {
                            // user entered invalid input
                            $(ele).val(splitVal[0]); // always trim everything after '.'
                        }
                    }
                }
            }
        </script>
        
        <br><br><br><br>
        <form name="match_form" method="post" action="mod_cert/guardar_ind.php">
        <?php
            $db = Core::Conectar();
            
        ?>
            <center>
                <div class="estilo_div">
                    <table>
                        <tr>
                            <td class="titulo">Registro de compra de Activos</td>
                        </tr>
                        <tr>
                            <td class="subtitulo" style="text-align: center">Del Restaurante</td>
                        </tr>
                    </table><br />
                    <div id="nuevo" class="estilo_subdiv">
                        <center>
                            <table>
                                <tr>
                                    <center><br />
                                        <input type="radio" name="activo" value="1" checked="checked">
                                        activo
                                        &nbsp;
                                        <input type="radio" name="activo" value="0">
                                        inactivo
                                    </center>
                                    <td style="width: 48%">
                                        <div class="subdiv">
                                            &nbsp;&nbsp;Informacion General:<br>
                                            <table>
                                                <tr>
                                                    <td>Codigo:</td>
                                                    <td><input type="text" id="id_registro_activos" name="id_registro_activos"
                                                            value="<?php echo $_REQUEST["id"]; ?>"
                                                            style="height: 20px; width:50%; text-align: center;" class="inputs"
                                                            readonly>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Paginación:</td>
                                                    <?php
                                                    $id_regact = $_REQUEST["id"];
                                                    $consultas = "SELECT n_adjuntos, id_urecibido, YEAR ( fecha_compra ) as anio FROM registro_activos where id_registro_activos=" . $id_regact;
                                                    //echo $consultas;
                                                    $resultados = $db->query($consultas);
                                                    foreach ($resultados as $filas) {
                                                        $n_adjuntos = $filas['n_adjuntos'];
                                                        $id_personal = $filas['id_urecibido'];
                                                        $anio_compra = $filas['anio'];

                                                        $consultap = "SELECT concat(nombres,' ', apaterno,' ',amaterno) as nom_personal FROM personal where id_personal=" . $id_personal;
                                                        $resultadop = $db->query($consultap);
                                                        $resultadop = $resultadop->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($resultadop as $filap) {
                                                            $nom_personal = $filap['nom_personal'];
                                                            echo $nom_personal;
                                                            $cantidad = "SELECT count(id_activo) as correl, count(id_registro_activos) as total FROM registro_individual where id_registro_activos=$id_regact and estado=1 ;";
                                                            $resultadoc = $db->query($cantidad);
                                                            //$resultadoc = $resultadoc->fetchAll(PDO::FETCH_ASSOC);
                                            
                                                            foreach ($resultadoc as $filac) {

                                                                $cant = $filac['total'] + 1;
                                                                $entero = $filac['correl'] + 1;

                                                                if ($cant > $n_adjuntos) {
                                                                    $cant = 1;
                                                                    $entero = 1;
                                                                    // echo "<script type=\"text/javascript\">" . "window.alert('Se registraron todos los activos de esta adquisición gracias.');" . "top.location = 'activos.php';" . "</script>";
                                                                    echo "<script type=\"text/javascript\">" . "window.alert('Se registraron todos los activos de esta adquisición gracias.');" . "top.location = 'index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_k")) . "';" . "</script>";

                                                                }
                                                            }
                                                        }
                                                    } ?>
                                                    <input type="hidden" id="n_adjuntos" name="n_adjuntos"
                                                        value="<?php echo $n_adjuntos; ?>">

                                                    <td><input type="text" id="paginacion" name="paginacion"
                                                            style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                            class="inputs" value="<?php echo $cant;
                                                            echo '-';
                                                            echo $n_adjuntos; ?>" readonly=""></td>
                                                </tr>

                                                <input type="hidden" id="correlativo" name="correlativo"
                                                    style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                    class="inputs" value="<?php echo $entero; ?>" readonly="">


                                                <tr>
                                                    <td><label for="reg_activo_id">Activo:</label></td>
                                                    <td><select id="reg_activo_id" name="reg_activo_id"
                                                            style="height: 20px; width: 82%; text-align: center;" class="inputs"
                                                            required>
                                                            <option value="">Seleccione un Activo</option>
                                                            <?php
                                                            $consulta = "SELECT id_activo, nombre FROM activo where estado=1 ORDER BY CAST(nombre AS VARCHAR(MAX)) ASC;";
                                                            $resultado = $db->query($consulta);
                                                            foreach ($resultado as $fila) { ?>
                                                                    <option value="<?php echo $fila["id_activo"]; ?>"><?php echo $fila["nombre"]; ?></option>
                                                                    <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><label for="tipo_activo_id">Tipo de activo</label></td>
                                                    <td><select id="tipo_activo_id" name="tipo_activo_id"
                                                            style="height: 20px; width: 82%; text-align: center;"
                                                            required>
                                                            <option value="">Seleccione un tipo de activo </option>
                                                        </select>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $("#reg_activo_id").change(function() {
                                                                    var reg_activo_id = $(this).val();
                                                                    // alert(reg_activo_id);
                                                                    $.ajax({
                                                                        url: "tipo_activo.php",
                                                                        type: "POST",
                                                                        data: { reg_activo_id: reg_activo_id },
                                                                        success: function(data) {
                                                                            //alert(data);
                                                                            $("#tipo_activo_id").html(data);
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Gestion:</td>
                                                    <td><input type="text" id="gestion" name="gestion"
                                                            style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                            class="inputs" value="<?php echo $anio_compra; ?>" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td>Recibido por:</td>
                                                    <td><input type="hidden" id="recibido" name="recibido"
                                                            style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                            class="inputs" value="<?php echo $id_personal; ?>"><?php echo $nom_personal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Descripcion Activo:</td>
                                                    <td><textarea id="descripcion_act" rows="2" cols="30" name="descripcion_act"
                                                            class="inputs"></textarea></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td style="width: 10px"></td>
                                    <td style="width: 49%">
                                        <div class="subdiv">
                                            &nbsp;&nbsp;Informacion Detallada:<br><br>
                                            <table>
                                                <tr>
                                                    <td>Marca:</td>
                                                    <td><input type="text" id="marca" name="marca"
                                                            style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                            required /></td>
                                                </tr>
                                                <tr>
                                                    <td>Modelo:</td>
                                                    <td><input type="text" id="modelo" name="modelo"
                                                            style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                            required /></td>
                                                </tr>
                                                <tr>
                                                    <td>Serie:</td>
                                                    <td><input type="text" id="serie" name="serie"
                                                            style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                            required /></td>
                                                </tr>
                                                <tr>
                                                    <td>Costo Bs.</td>
                                                    <td><input type="text" id="costo" name="costo"
                                                            style="height: 20px; width:82%; text-align: center;" maxlength="10"
                                                            class="inputs" onkeypress="return NumCheckD(event,this)" required />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Estado Activo:</td>
                                                    <td>
                                                        <select id="estado_activo" name="estado_activo"
                                                            style="height: 20px; width: 200px; text-align: center;"
                                                            class="inputs" required>
                                                            <option value="">-SELECCIONAR-</option>
                                                            <?php
                                                            $consulta = "SELECT id_estado_activo, est_tec FROM estado_activo where estado=1;";
                                                            $resultado = $db->query($consulta);
                                                            foreach ($resultado as $fila) { ?>
                                                                    <option value="<?php echo $fila["id_estado_activo"]; ?>"><?php echo $fila["est_tec"]; ?></option>
                                                                    <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div><br>
                                        <div class="subdiv">
                                            &nbsp;&nbsp;Registrar fecha de Ingreso:<br><br>
                                            <table>
                                                <tr>
                                                    <td>Fecha inicial:</td>
                                                    <td>
                                                        <input type="text" class="date_input" id="fecha_inicial" name="fecha_inicial">
                                                        <script>
                                                            flatpickr("#fecha_inicial", {
                                                                enableTime: true,          
                                                                dateFormat: "d-m-Y H:i",    
                                                                time_24hr: true,            
                                                            });
                                                        </script>
                                                    </td>
                                                </tr>                                                
                                            </table>
                                        </div>
                                    </td>
                                    <td style="width: 1px"></td>
                                </tr>
                                <input type="hidden" id="correlativo" name="correlativo"
                                    style="height: 20px; width:82%; text-align: center;" maxlength="4" class="inputs"
                                    value="<?php echo $entero; ?>" readonly="">
                            </table>
                        </center>
                        <br /><br />
                        <table>
                            <tr>
                                <td>Observaciones:</td>
                                <td><textarea id="observaciones" rows="2" cols="30" name="observaciones"
                                        class="inputs"></textarea></td>
                            </tr>
                        </table>
                        <br>
                        <div class="mi-div">
                            <p style="padding-top: 15px; ">Valor Residual</p>
                            <!-- <input type="text" id="residual" name="residual" style="height: 20px; width:90px; text-align: center;" class="inputs" onkeypress="return validarDecimales(this)" required /> -->
                            <input id="residual" name="residual" type="number" data-decimal="2"
                                oninput="enforceNumberValidation(this)" value=""
                                style="height: 25px; width:120px; text-align: center;" class="inputs" required minlength="4"
                                maxlength="8" />
                        </div>
                        <br />
                        <center>
                            <input type="submit" value="GUARDAR" class="button">
                            <!--<input id="cancelar" type="button" value="Cancelar" class="button" onclick="javascript: visibilidadDiv('nuevo');">-->
                        </center>
                        <br>
                    </div>
                    <br />
                    <div style='overflow-y:auto;width:95%;'>
                        <table width="90%" height="55" style="border:1px;" align="center">
                            <tr bgcolor='#CCCFF1'>
                                <th class="colEnc">Correlativo</th>
                                <th class="colEnc">Descripción</th>
                                <th class="colEnc">Marca</th>
                                <th class="colEnc">Modelo</th>
                                <th class="colEnc">Serie</th>
                                <th class="colEnc">Costo</th>
                                <th class="colEnc">Fecha ingreso</th>
                                <th class="colEnc">Observaciones</th>
                                <th class="colEnc" colspan="2">ACCIONES</th>
                            </tr>
                            <?php

                            $consulta = "SELECT ri.*, e.est_tec, FORMAT(ri.fecha_inicial, 'dd-MM-yyyy HH:mm') AS fecha_inicial FROM registro_individual ri, estado_activo e WHERE ri.id_estado_activo=e.id_estado_activo and ri.estado=1 and ri.id_registro_activos=$id_regact;";
                            $resultado = $db->query($consulta);
                            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                            if (count($resultado) > 0) {
                                foreach ($resultado as $fila) {
                                    ?>
                                    <tr bgcolor="#F2F9FF">
                                        <td align="center" class="colDat">
                                            <?php echo $fila["correlativo_cantidad"]; ?>
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
                                            <?php echo $fila["fecha_inicial"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["observaciones"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo "<a href='mod_cert/guardar.php?id_regind=" . $fila["id_registro_individual"] . "&id_regact=" . $fila["id_registro_activos"] . "&op=10'title='eliminar';>" ?>
                                            <img src="theme/images/borrar.png" width="30" height="30" />
                                            <?php "</a>"; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            $db = null;
                            ?>
                        </table>
                    </div>
                </div>
            </center>
        </form>
                    
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
                width: 95%;
            }

            .subdiv {
                border: solid 3px #ccc;
                /*border-radius:15px;*/
                width: 100%;
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

            .mi-div {
                width: 200px;
                height: 90px;
                border: 2px solid gray;
                /* Borde sólido de 2 píxeles de grosor y color negro */
            }
        </style>

        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '9') {
        ?>
        <script type="text/javascript" language="javascript" class="init">
            $(document).ready(function () {
                $('#resultado').DataTable();
            });
        </script>
        <br><br><br><br>
        <center>
            <table>
                <tr>
                    <td class="titulo">ASIGNACIÓN DE ACTIVOS</td>
                </tr>
            </table>
            <form action="mod_cert/asigna_activo.php" method="post">
                <table id="resultado" class="display" width="90%" height="55" style="border:1px;" align="center">
                    <thead>
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N°</th>
                            <th class="colEnc">Nombre del Activo</th>
                            <th class="colEnc">Codigo</th>
                            <th class="colEnc">Descripcion</th>
                            <th class="colEnc">Marca</th>
                            <th class="colEnc">Modelo</th>
                            <th class="colEnc">Serie</th>
                            <th class="colEnc">Estado</th>
                            <th class="colEnc">Observaciones</th>
                            <th class="colEnc">Asignacion</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr bgcolor='#CCCFF1'>
                            <th align="center" class="colDat">N°</th>
                            <th align="center" class="colDat">Nombre del Activo</th>
                            <th align="center" class="colDat">Codigo</th>
                            <th align="center" class="colDat">Descripcion</th>
                            <th align="center" class="colDat">Marca</th>
                            <th align="center" class="colDat">Modelo</th>
                            <th align="center" class="colDat">Serie</th>
                            <th align="center" class="colDat">Estado</th>
                            <th align="center" class="colDat">Observaciones</th>
                            <th align="center" class="colDat">Asignacion</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php
                        $db = Core::Conectar();

                        $cantidad = "SELECT id_activo,count(id_activo) AS total FROM registro_individual group by id_activo";
                        $cant = $db->query($cantidad);
                        $cant = $cant->fetchAll(PDO::FETCH_ASSOC);

                        //$id_act = $cant[0]['total'];
                        $id_pers = $_GET['id'];

                        $id_reg = $_SESSION["id"];
                        $consulta = "SELECT ga.cod_resumen, ri.id_activo, ri.id_registro_individual, a.nombre, ri.gestion, ri.descripcion_act, ri.marca, ri.modelo, ri.serie, e.est_tec, ri.observaciones, ra.n_adjuntos
                                        FROM registro_individual ri
                                        left join registro_activos ra on ri.id_registro_activos=ra.id_registro_activos
                                        left join activo a on ri.id_activo=a.id_activo
                                        left join estado_activo e on ri.id_estado_activo=e.id_estado_activo
                                        left join grupo_contable ga on ra.id_grupo_contable=ga.id_grupo_contable
                                        WHERE ri.estado=1 and ri.id_registro_individual not in (select id_registro_individual from asignacion_activos where estado=1)
                                        order by ri.id_registro_individual";
                        $resultado = $db->query($consulta);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i = 0;
                        if (count($resultado) > 0) {
                            foreach ($resultado as $fila) {

                                $i = $i + 1;
                                ?>
                                        <tr>
                                            <th align="center" class="colDat">
                                                <?php echo $i; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["nombre"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo "dbo-";
                                                echo $fila["cod_resumen"];
                                                echo "-";
                                                echo $fila["id_activo"];
                                                echo "-";
                                                echo $fila["id_registro_individual"];
                                                echo "-";
                                                echo $fila["gestion"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["descripcion_act"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["marca"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["modelo"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["serie"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["est_tec"]; ?>
                                            </th>
                                            <th align="center" class="colDat">
                                                <?php echo $fila["observaciones"]; ?>
                                            </th>
                                            <th align="center" class="colDat"><input type="checkbox" name="asignados[]"
                                                    value="<?php echo $fila["id_registro_individual"]; ?>">
                                            </th>
                                        </tr>
                                        <?php
                            }

                        }
                        $db = null;
                        ?>
                    </tbody>
                </table>
                <input type="hidden" name="id_persona" value="<?php echo $id_pers; ?>" /> 
                <input type="hidden" name="id_reg" value="<?php echo $id_reg; ?>" />
                <center>Observaciones</center>
                <textarea rows="10" cols="50" type="text" name="observaciones"></textarea><br>
                <br><input type="submit" name="btnasignar" value="Asignar" class="button" /><br>
            </form>
        </center>
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

        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '10') {
        ?>
        
        <script type="text/javascript" language="javascript" class="init">
            $(document).ready(function() {
                $('#resultado').DataTable();
            } );
        </script>
        <br><br><br><br>
        <center>
            <table><tr><td class="titulo">DEVOLUCION DE ACTIVOS</td></tr></table>
        
            <form action="mod_cert/devuelve_activo.php" method="post">
                <table id="resultado" class="display" width="90%" height="55" style="border:1px;" align="center">
                    <thead>
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">N°</th>
                            <th class="colEnc">Nombre del Activo</th>
                            <th class="colEnc">Codigo</th>
                            <th class="colEnc">Descripcion</th>
                            <th class="colEnc">Marca</th>
                            <th class="colEnc">Modelo</th>
                            <th class="colEnc">Serie</th>
                            <th class="colEnc">Estado</th>
                            <th class="colEnc">Observaciones</th>
                            <th class="colEnc">Devolución</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr bgcolor='#CCCFF1'>
                            <th align="center" class="colDat">N°</th>
                            <th align="center" class="colDat">Nombre del Activo</th>
                            <th align="center" class="colDat">Codigo</th>
                            <th align="center" class="colDat">Descripcion</th>
                            <th align="center" class="colDat">Marca</th>
                            <th align="center" class="colDat">Modelo</th>
                            <th align="center" class="colDat">Serie</th>
                            <th align="center" class="colDat">Estado</th>
                            <th align="center" class="colDat">Observaciones</th>
                            <th align="center" class="colDat">Asignacion</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                    <?php
                    $db = Core::Conectar();
                    $id_pers = $_GET["id"];
                    $id = $_SESSION['id'];
                    $consulta = "SELECT ga.cod_resumen, ri.id_activo, ri.id_registro_individual, a.nombre, ri.gestion, ri.descripcion_act, ri.marca, ri.modelo, ri.serie, e.est_tec, 
                        ri.observaciones, ra.n_adjuntos, aa.id_usuario_asig
                        FROM registro_individual ri, activo a, estado_activo e, registro_activos ra, grupo_contable ga, asignacion_activos aa
                        WHERE ri.estado=1 and ri.id_activo=a.id_activo and ri.id_estado_activo=e.id_estado_activo and ri.id_registro_activos=ra.id_registro_activos 
                        and ra.id_grupo_contable=ga.id_grupo_contable and ri.id_registro_individual=aa.id_registro_individual and aa.estado=1 and aa.id_usuario_asig=$id_pers
                        order by ri.id_registro_individual";
                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $i = 0;
                    if (count($resultado) > 0) {
                        foreach ($resultado as $fila) {

                            $i = $i + 1;
                            ?>
                                <tr>
                                    <th align="center" class="colDat"><?php echo $i; ?></th>
                                <th align="center" class="colDat"><?php echo $fila["nombre"]; ?></th>
                                <th align="center" class="colDat"><?php echo "dbo-";
                                echo $fila["cod_resumen"];
                                echo "-";
                                echo $fila["id_activo"];
                                echo "-";
                                echo $fila["id_registro_individual"];
                                echo "-";
                                echo $fila["gestion"]; ?></th>
                                <th align="center" class="colDat"><?php echo $fila["descripcion_act"]; ?></th>
                                <th align="center" class="colDat"><?php echo $fila["marca"]; ?></th>
                                <th align="center" class="colDat"><?php echo $fila["modelo"]; ?></th>
                                <th align="center" class="colDat"><?php echo $fila["serie"]; ?></th>
                                <th align="center" class="colDat"><?php echo $fila["est_tec"]; ?></th> 
                                <th align="center" class="colDat"><?php echo $fila["observaciones"]; ?></th> 
                                <th align="center" class="colDat"><input type="checkbox" name="asignados[]" value="<?php echo $fila["id_registro_individual"]; ?>">
                                </th></tr>
                        <?php
                        }
                    }
                    $db = null;
                    ?>   
                    </tbody><br>
                </table>
                <input type="hidden" name="id_persona" value="<?php echo $id_pers; ?>" />
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <center>Observaciones</center>
                <textarea rows="10" cols="50" type="text" name="observaciones"></textarea>
                <br><br>
                <input type="submit" name="btnasignar" value="Devuelve" class="button" />
            </form>       
        </center>
        <style>
            .button{
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

            .button:hover{
                background: #365D9D;
                background: linear-gradient(left, #365D9D, #436CAD);
                background: -moz-linear-gradient(left, #365D9D, #436CAD);
                background: -webkit-linear-gradient(left, #365D9D, #436CAD);
                background: -o-linear-gradient(left, #365D9D, #436CAD);
                color: #FFFFFF;
                border-color: #FBFFAD;
            }
            .estilo_div{
                border:solid 10px #ccc;
                border-radius:15px;
                box-shadow: 8px 8px 10px 0px #818181;
                width:850px;
            }
            .titulo{
                font-family: algerian;
                color: #001459;
            font-size: 180%;
            }
            .subtitulo{
                font-family: algerian;
            /*color: lightblue;*/
                color: #001459;
            font-size: 120%;
            }

            .estilo_subdiv{
                border:solid 3px #ccc;
                border-radius:15px;
                width:450px;
            }
            .inputs{
                float: none;
            padding: 0px;
            font-size: small;
                font-family: verdana;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            border: 1px solid rgb(182, 182, 182);
            color: rgb(51,51,51);
            }
    
            .colEnc{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
                background: #CED4D9;
            }
            .colDat{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
            }
        </style>

        <?php
    }
    if (isset($_REQUEST["op"]) && $_REQUEST["op"] == '11') {
        ?>
        <script language="javascript">        
                function visibilidadDiv(id) {
                    div = document.getElementById(id);
                    document.getElementById("tipo_activos").value='';
            
                    if (div.style.display == "block") {
                        div.style.display = "none";
                    } else {
                        div.style.display = "block";
                    }
                }
        </script>
        <br><br><br><br>
        <?php
        $db = Core::Conectar();
        $id = $_REQUEST["id"];
        //echo ($id);
        $resultado = "SELECT id_activo, descripcion, case estado when 1 then 1 else 0 end estado FROM tipo_activos where id_tipo_activos=$id";
        $resultado = $db->query($resultado);
        foreach ($resultado as $fila) {
            $id_activo = $fila[0];
            $descripcion = $fila[1];
            $estado = $fila[2];
        }
        ?>    
        <form name="match_form" method="post" action="mod_cert/guardar.php?op=20&d=<?= $id ?>">
            <center>
            <div class="estilo_div" >
                <table><tr><td class="titulo">TIPO DE ACTIVO</td></tr>   
                </table><br>
        
                <div id="nuevo" class="estilo_subdiv">        
                    <center>
                    <table>
                        <tr><td colspan="2" class="subtitulo" style="text-align: center">Modificar</td></tr>
                        <tr style="height: 10px"></tr>
                        </tr>                                        
                            <td>Activo:</td>
                            <td>
                                <select id="id_activo" name="id_activo" style="height: 20px; width: 82%; text-align: center;"
                                    class="inputs" required>
                                    <option value="">-SELECCIONAR-</option>
                                    <?php
                                    $consulta = "SELECT id_activo, nombre FROM activo where estado=1;";
                                    $resultado = $db->query($consulta);
                                    foreach ($resultado as $fila) {
                                        $p = "";
                                        if ($fila["id_activo"] == $id_activo)
                                            $p = "selected";
                                            echo ($p);
                                        ?>
                                        <option value="<?php echo $fila["id_activo"]; ?>" <?= $p; ?>><?php echo $fila["nombre"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr><td>Descripcion:</td><td><textarea name="descripcion" id="descripcion" rows="3" cols="20" ><?= $descripcion ?></textarea></td></tr>
                        <tr><td>&nbsp;</td><td><input type="radio" name="activo" value="1" <?= $estado == 1 ? 'checked' : '' ?>> Activo<br><input type="radio" name="activo" value="0" <?= $estado == 0 ? 'checked' : '' ?>> Inactivo</td></tr>
                    </table>
                    </center>
                    <br>
                    <center>
                        <input type="submit" value="GUARDAR" class="button">
                        <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_p")) ?>"><input id="CANCELAR" type="button" value="CANCELAR" class="button"></a>
                    </center>
            
                    <br>
                </div>       
                <br>
            </div>
            </center>
        </form>
        <style>
            .button{
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

            .button:hover{
                background: #365D9D;
                background: linear-gradient(left, #365D9D, #436CAD);
                background: -moz-linear-gradient(left, #365D9D, #436CAD);
                background: -webkit-linear-gradient(left, #365D9D, #436CAD);
                background: -o-linear-gradient(left, #365D9D, #436CAD);
                color: #FFFFFF;
                border-color: #FBFFAD;
            }
            .estilo_div{
                border:solid 10px #ccc;
                border-radius:15px;
                box-shadow: 8px 8px 10px 0px #818181;
                width:850px;
            }
            .titulo{
                font-family: algerian;
                color: #001459;
            font-size: 180%;
            }
            .subtitulo{
                font-family: algerian;
            /*color: lightblue;*/
                color: #001459;
            font-size: 120%;
            }

            .estilo_subdiv{
                border:solid 3px #ccc;
                border-radius:15px;
                width:450px;
            }
            .inputs{
                float: none;
            padding: 0px;
            font-size: small;
                font-family: verdana;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
            border: 1px solid rgb(182, 182, 182);
            color: rgb(51,51,51);
            }
    
            .colEnc{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
                background: #CED4D9;
            }
            .colDat{
                display: table-cell;
                padding: 5px;
                font-family: monospace; 
                font-size: 14px;
                color: #063b82;
            }
        </style>
        <?php
        $db = null;
        
    }
    require("theme/footer_inicio.php");
} else
    header('Location: index.php');
?>