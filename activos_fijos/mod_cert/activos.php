<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
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
            document.miformulario.action = "cBuscar.php"
            document.miformulario.submit()
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
    <form name="match_form" method="post" action="mod_cert/guardar.php?op=7">
        <?php
        include_once 'mod_configuracion/clases/conexion.php';
        $db = Core::Conectar();
        ?>
        <center>
            <div class="estilo_div">
                <table>
                    <tr>
                        <td class="titulo">Registro de ACTIVOS</td>
                    </tr>
                    <tr>
                        <td class="subtitulo" style="text-align: center">DEL RESTAURANTE </td>
                    </tr>
                </table><br>


                <div id="nuevo" class="estilo_subdiv">
                    <center>
                        <br>
                        <table align="left">
                            <tr>
                                <td>Estado del Activo:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                        type="radio" name="activo" value="true" checked="checked">
                                    Activo
                                    &nbsp;
                                    <input type="radio" name="activo" value="false">
                                    Inactivo
                                </td>
                            </tr>

                            <br>
                            <tr>
                                <td>Antiguedad del Activo:&nbsp;&nbsp;&nbsp;<input type="radio" name="antiguedad"
                                        value="NUEVO" checked="checked">
                                    Nuevo
                                    &nbsp;
                                    <input type="radio" name="antiguedad" value="ANTIGUO">
                                    Antiguo
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 48%">
                                    <div class="subdiv">
                                        &nbsp;&nbsp;Informacion del Producto:<br><br>
                                        <table>
                                            <tr>
                                                <td>Proveedor:</td>
                                                <td>
                                                    <select id="id_emp" name="id_emp"
                                                        style="height: 20px; width:100%; text-align: center;" class="inputs"
                                                        required>
                                                        <option value="">-Seleccione-</option>
                                                        <?php
                                                        $consulta = "SELECT id_empresa, empresa FROM empresas where estado=1 ORDER BY CAST(empresa AS VARCHAR(MAX)) ASC;";
                                                        $resultado = $db->query($consulta);
                                                        foreach ($resultado as $fila) { ?>
                                                            <option value="<?php echo $fila["id_empresa"]; ?>"><?php echo $fila["empresa"]; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Descripcion Item:</td>
                                                <td><textarea id="descripcion" rows="2" cols="30" name="descripcion"
                                                        class="inputs"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>Nº Adjuntos:</td>
                                                <td><input type="number" id="cantidad" name="cantidad"
                                                        style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                        class="inputs" onkeypress="return numeros(event)" required />
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </td>
                                <td style="width: 10px"></td>
                                <td style="width: 49%">
                                    <div class="subdiv">
                                        &nbsp;&nbsp;Informacion Contable:<br><br>
                                        <table>
                                            <tr>
                                                <td>Fecha Actual:</td>
                                                <td><input type="text" id="fecha_registro" name="fecha_registro"
                                                        style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                        required value='<?php echo date('d/m/Y') ?>' /></td>
                                            </tr>
                                            <tr>
                                                <td>Fecha de Compra:</td>
                                                <td>
                                                    <div class="date_input">
                                                        <script>DateInput('fecha_compra', true, 'DD-MM-YYYY') </script>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Fecha Recepción:</td>
                                                <td>
                                                    <input type="text" class="date_input" id="fecha_inicial" name="fecha_inicial">
                                                    <script>
                                                        flatpickr("#fecha_inicial", {
                                                            enableTime: true,           // Habilita la selección de hora
                                                            dateFormat: "d-m-Y H:i",    // Formato de fecha y hora
                                                            time_24hr: true,            // Usa formato de 24 horas
                                                        });
                                                    </script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Código CBTE:</td>
                                                <td><input type="text" id="cbte" name="cbte"
                                                        style="height: 20px; width:82%; text-align: center;" maxlength="8"
                                                        class="inputs" required />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grupo de trabajo:</td>
                                                <td>
                                                    <select id="id_gam" name="id_gam"
                                                        style="height: 20px; width: 250px; text-align: center;"
                                                        class="inputs" required>
                                                        <option value="">-Seleccione-</option>
                                                        <?php
                                                        $consulta = "SELECT id_grupo_contable, descripcion FROM grupo_contable where estado=1 ORDER BY CAST(descripcion AS VARCHAR(MAX)) ASC;";
                                                        $resultado = $db->query($consulta);
                                                        foreach ($resultado as $fila) { ?>
                                                            <option value="<?php echo $fila["id_grupo_contable"]; ?>"><?php echo $fila["descripcion"]; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td style="width: 1px"></td>
                            </tr>
                        </table>
                    </center>
                    <br><br>
                    <table>
                        <tr>
                            <td style="width: 33%">
                                <table>
                                    <tr>
                                        <td>Nº Factura:</td>
                                        <td><input type="text" id="factura" name="factura"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="10"
                                                class="inputs" onkeypress="return numeros(event)" required /></td>
                                    </tr>
                                    <tr>
                                        <td>Costo Bs.</td>
                                        <td><input type="text" id="costo" name="costo"
                                                style="height: 20px; width:82%; text-align: center;" maxlength="10"
                                                class="inputs" onkeypress="return NumCheckD(event,this)" required /></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 116px">CR Fiscal 13%:</td>
                                        <td><input type="text" id="cr" name="cr"
                                                style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                readonly="true" /></td>
                                    </tr>
                                    <tr>
                                        <td>Menos 13%:</td>
                                        <td><input type="text" id="costo_sin_cr" name="costo_sin_cr"
                                                style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                readonly="true" /></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 33%">
                                <div class="subdiv">
                                    <table>
                                        <tr>
                                            <td>
                                                Fecha Tipo de Cambio:
                                                <select id="id_tc" name="id_tc"
                                                    style="height: 20px; width: 200px; text-align: center;" class="inputs"
                                                    required>
                                                    <option value="">-Seleccione-</option>
                                                    <?php
                                                    $consulta = "SELECT id_tipo_cambio, FORMAT(fecha_reg, 'dd/MM/yyyy') AS fecha_reg FROM tipo_cambio where estado=1 order by CAST(fecha_reg AS varchar(max)) desc;";
                                                    $resultado = $db->query($consulta);
                                                    foreach ($resultado as $fila) { ?>
                                                        <option value="<?php echo $fila["id_tipo_cambio"]; ?>"><?php echo $fila["fecha_reg"]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </td>
                            <td style="width: 33%">
                                <div class="subdiv">
                                    <table>
                                        <tr>
                                            <td>
                                                Recibido por:
                                                <select id="id_personal" name="id_personal"
                                                    style="height: 20px; width: 90%; text-align: center;" class="inputs"
                                                    required>
                                                    <option value="">-Seleccione-</option>
                                                    <?php
                                                    $consulta = "SELECT id_personal, concat(apaterno,' ',amaterno,' ',nombres) as nom_personal FROM personal where estado=1 ORDER BY CAST(apaterno AS VARCHAR(MAX)) ASC;";
                                                    $resultado = $db->query($consulta);
                                                    foreach ($resultado as $fila) { ?>
                                                        <option value="<?php echo $fila["id_personal"]; ?>"><?php echo $fila["nom_personal"]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td style="width: 1px"></td>
                        </tr>
                    </table>
                    <br>
                    <center>
                        <input type="submit" value="GUARDAR" class="button">
                        <!--<input id="cancelar" type="button" value="Cancelar" class="button" onclick="javascript: visibilidadDiv('nuevo');">-->
                    </center>

                    <br>
                </div>
                <br>
                <div style='overflow-y:auto;width:95%;'>
                    <table width="90%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">ID</th>
                            <th class="colEnc">Fecha Compra</th>
                            <th class="colEnc">Fecha Adquisición</th>
                            <th class="colEnc">Descripcion</th>
                            <th class="colEnc">Nº Adjuntos</th>
                            <th class="colEnc">factura</th>
                            <th class="colEnc">Costo</th>
                            <th class="colEnc">Responsable</th>
                            <th class="colEnc" colspan="2">Opciones</th>
                        </tr>
                        <?php

                        $consulta = "SELECT TOP 10 ra.id_registro_activos, concat(p.nombres,' ',p.apaterno,' ',p.amaterno) as nom_personal, ra.fecha_compra, ra.descripcion, ra.n_adjuntos, ra.factura, ra.costo, ra.c_cred_fiscal, ra.s_cred_fiscal, gam.cod_resumen, ra.n_cbt, 
                                        case ra.estado when 1 then 'ACTIVO' else 'INACTIVO' end estado, tc.sus_venta,tc.sus_compra, FORMAT(ra.fecha_inicial, 'dd-MM-yyyy HH:mm') AS fecha_inicial 
                                        FROM registro_activos ra  
                                        inner join grupo_contable gam on gam.id_grupo_contable=ra.id_grupo_contable
                                        inner join tipo_cambio tc on tc.id_tipo_cambio=ra.id_tipo_cambio
                                        inner join personal p on p.id_personal=ra.id_urecibido
                                        order by ra.id_registro_activos DESC";
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
                                        <?php echo $fila["fecha_compra"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["fecha_inicial"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["descripcion"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["n_adjuntos"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["factura"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["costo"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo $fila["nom_personal"]; ?>
                                    </td>
                                    <td align="center" class="colDat">
                                        <!-- <?php echo "<a href='registro_ind.php?id_registro_activos=" . $fila["id_registro_activos"] . "'title='registrar'>REGISTRO INDIVIDUAL</a>"; ?> -->
                                        <a href="attached.php?op=8&id=<?php echo $fila["id_registro_activos"]; ?>" title="registrar">REGISTRO INDIVIDUAL</a>
                                    </td>
                                    <td align="center" class="colDat">
                                        <?php echo "<a href='mod_inicio/reportes.php?id_regact=" . $fila["id_registro_activos"] . "&op=77'title='detalle'>DETALLE COMPRA</a>"; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </table>
                </div>
                <br>
            </div>
        </center>
    </form>
    <?php
    require("theme/footer_inicio.php");
} else
    header('Location: index.php');
?>
<script>
        $(document).ready(function() {
            $('#id_tc').select2();
            $.ajax({
                dataType: 'json',
                success: function() {
                    data.forEach(function(id_tc) {
                        $('#id_tc').append(new Option(id_tc, id_tc));
                    });
                },
            });
        });
    </script>
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
</style>
