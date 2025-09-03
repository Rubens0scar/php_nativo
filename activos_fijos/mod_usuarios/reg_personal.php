<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    //require("../mod_configuracion/clases/conexion.php");
    require("theme/header_inicio.php");
    include_once 'mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();
    ?>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#modificar").hide();
            $("#buscar").click(function (e) {
                //alert('holas');
                var textoBusqueda = $("input#ci").val();
                if (textoBusqueda != "") {
                    $.post("mod_usuarios/buscar.php?op=1", { valorBusqueda: textoBusqueda }, function (mensaje) {
                        //$("#resultadoBusqueda").html(mensaje);
                        if (mensaje != "") {
                            //alert(mensaje);
                            var res = mensaje.split("-");
                            //alert(res);
                            $("#codigo_personal").val(res[0]);
                            $("#id_area").val(res[1]);
                            $("#nom_personal").val(res[4]);
                            $("#paterno_personal").val(res[5]);
                            $("#materno_personal").val(res[6]);
                            $("#ci_personal").val(res[3]);
                            $("#ubicacion").val(res[2]);
                            $("#id_cargo").val(res[7]);
                            $("#dir_personal").val(res[8]);
                            $("#fn_personal").val(res[9]);
                            if (res[11] == 1) {
                                $("#activo2").removeAttr("checked");
                                $("#activo1").attr('checked', 'checked');
                            } else {
                                $("#activo1").removeAttr("checked");
                                $("#activo2").attr('checked', 'checked');
                            }
                            $("#correo_personal").val(res[12]);

                            $("#modificar").show();
                            $("#registrar").hide();

                            $.post("mod_usuarios/buscar.php?op=3", { valorBusqueda: $("#codigo_personal").val() }, function (mensaje) {
                                //$("#resultadoBusqueda").html(mensaje);
                                //alert(mensaje);
                                if (mensaje != "") {
                                    $("#usuarios").show();
                                    $("#usuario").attr('checked', 1);
                                    var res = mensaje.split("%");
                                    //alert(res[0]);
                                    $("#usr").val(res[2]);
                                    //$("#pass1").val(res[3]);
                                    //$("#pass2").val(res[3]);
                                    if (res[4] == 1) {
                                        $("#activo_usu1").removeAttr("checked");
                                        $("#activo_usu").attr('checked', 'checked');
                                    } else {
                                        $("#activo_usu").removeAttr("checked");
                                        $("#activo_usu1").attr('checked', 'checked');
                                    }
                                }
                            });
                        }
                    });
                }
            });

            $("#limpiar").click(function () {
                $("#registrar").show();
                $("#modificar").hide();
            });

            $("#modificar").click(function () {
                /*var aux = 0;
                if ($("#usuario").prop('checked')) {
                    aux = 1;
                } */

                var estado = 1;
                if ($('#activo2').is(':checked')) {
                    estado = false;
                }

                /*var estado_usuario = true;
                if ($('#activo_usu1').is(':checked')) {
                    estado_usuario = false;
                } */

                var data = {};
                data.id_personal = $("#codigo_personal").val();
                data.id_area = $("#id_area").val();
                data.ubicacion = $("#ubicacion").val();
                data.ci = $("#ci_personal").val();
                data.nombres = $("#nom_personal").val();
                data.apaterno = $("#paterno_personal").val();
                data.amaterno = $("#materno_personal").val();
                data.id_cargo = $("#id_cargo").val();
                data.direccion = $("#dir_personal").val();
                data.telefonos = $("#fn_personal").val();
                data.correo_personal = $("#correo_personal").val();
                data.estado = estado;

                /*data.usr = $("#usr").val();
                data.pass1 = $("#pass1").val();
                data.estado_usuario = estado_usuario;
                data.usuario = aux;  */

                $.ajax({
                    type: "POST",
                    url: "mod_usuarios/guardar_usu.php?op=3",
                    data: data,
                    //typedata:text,
                    success: function (text) {
                        alert(text);
                        location.reload();
                    }
                });
            });

            /*$("#usuario").click(function () {
                if ($('#usuario').prop('checked')) {
                    $("#usuarios").show();
                } else {
                    $("#usuarios").hide();
                }
            }); */

            $("#registrar").click(function () {
                /*if (($("#usr").val() == '' && $("#pass1").val() != '') || ($("#usr").val() != '' && $("#pass1").val() == '')) {
                    alert('Debe ingresar un usuario y contraseña valida !!!!');
                } else {
                    if ($("#usr").val() != '') {
                        var textoBusqueda = $("#usr").val();
                        $.post("buscar.php?op=2", {valorBusqueda: textoBusqueda}, function (mensaje) {
                            if (mensaje == "0") {
                                $("#usuario_contraseña").submit();
                            } else {
                                alert("Usuario ya registrado, debe seleccionar otro.");
                                $("#usr").focus();
                            }
                        });
                    } else {*/
                $("#usuario_contraseña").submit();
                //}
                // }
            });

            /*$("#pass2").keyup(function () {
                $("#confirmacion").show();
                if ($("#pass2").val() == $("#pass1").val()) {
                    $("#confirmacion").removeClass("error");
                    $("#confirmacion").addClass("sinerror");
                    $("#confirmacion").val('Contraseña correcta');
                } else {
                    $("#confirmacion").removeClass("sinerror");
                    $("#confirmacion").addClass("error");
                    $("#confirmacion").val('Contraseñas no son iguales');
                }
            });  */
        });
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

    <br />
    <div class="titulo">Registro y/o Modificación de Personal</div><br />

    <form name="match_form" method="post" action="mod_usuarios/guardar_usu.php?op=1">
        <input type="hidden" id="codigo_personal">
        <?php
        $consulta = "SELECT MAX(id_personal) AS id FROM personal";
        $resultado = $db->query($consulta);
        foreach ($resultado as $fila) {
            ?>
            <input type="hidden" id="id_personal" name="id_personal" style="height: 20px; width:82%; text-align: center;"
                maxlength="4" class="inputs" value="<?php echo $fila["id"] + 1; ?>" readonly=""></td>
            </tr>
            <?php
        }
        ?>

        <center>
            <table class="tabla" width="500">
                <tr>
                    <td colspan="2" class="tdatos" align="center">
                        <h3>DATOS DE LA PERSONA</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="tdatos" align="center">
                        <table style="border: none">
                            <tr style="height: 40px">
                                <td class="tdatos">CI a buscar:</td>
                                <td><input type="text" name="ci" id="ci" size="45" style="width: 200px" /></td>
                                <td><input type="button" name="buscar" id="buscar" class="button" value="BUSCAR" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="tdatos">Nombres:</td>
                    <td><input type="text" name="nom_personal" id="nom_personal" size="35" required></td>
                </tr>
                <tr>
                    <td class="tdatos">Apellido Paterno:</td>
                    <td><input type="text" name="paterno_personal" id="paterno_personal" size="35" required></td>
                </tr>
                <tr>
                    <td class="tdatos">Apellido Materno:</td>
                    <td><input type="text" name="materno_personal" id="materno_personal" size="35" required></td>
                </tr>
                <tr>
                    <td class="tdatos">Cedula de Identidad:</td>
                    <td><input type="text" name="ci_personal" id="ci_personal" size="35" required></td>
                </tr>
                <tr>
                    <td class="tdatos">Área:</td>
                    <td>
                        <select id="id_area" name="id_area" style="height: 20px; width: 82%; text-align: center;"
                            class="inputs" required>
                            <option value="">-SELECCIONAR-</option>
                            <?php
                            $consulta = "SELECT id_area, nom_area FROM area where estado=1;";
                            $resultado = $db->query($consulta);
                            foreach ($resultado as $fila) {
                                ?>
                                <option value="<?php echo $fila["id_area"]; ?>"><?php echo $fila["nom_area"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="tdatos">Cargo:</td>
                    <td>
                        <select id="id_cargo" name="id_cargo" style="height: 20px; width: 82%; text-align: center;"
                            class="inputs" required>
                            <option value="">-SELECCIONAR-</option>
                            <?php
                            $consulta = "SELECT id_cargo, descripcion FROM cargo where estado=1;";
                            $resultado = $db->query($consulta);
                            foreach ($resultado as $fila) {
                                ?>
                                <option value="<?php echo $fila["id_cargo"]; ?>"><?php echo $fila["descripcion"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="tdatos">Dirección:</td>
                    <td><input type="text" name="dir_personal" id="dir_personal" size="35" required /></td>
                </tr>
                <tr>
                    <td class="tdatos">Telefono:</td>
                    <td><input type="text" name="fn_personal" id="fn_personal" size="35"
                            onkeypress="return numeros(event)" required></td>
                </tr>
                <tr>
                    <td class="tdatos">Correo:</td>
                    <td><input type="text" name="correo_personal" id="correo_personal" size="35" required></td>
                </tr>
                <tr>
                    <td class="tdatos">Estado:</td>
                    <td><input type="radio" id="activo1" name="activo" value="1" checked>
                        Activo
                        &nbsp;
                        <input type="radio" name="activo" id="activo2" value="0">
                        Inactivo
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center"><br>
                        <input type="submit" value="REGISTRAR" id="registrar" size="20" class="button">
                        <input type="button" value="MODIFICAR" id="modificar" name="modificar" size="20" class="button"
                            style="display: none">
                        <input name="Restablecer" type="reset" id="limpiar" value="Limpiar" class="button" />
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </center>
    </form>
    <br>
    <center>
        <table>
            <tr>
                <td class="subtitulo" style="text-align: center">Reporte General</td>
            </tr>
        </table><br>
        <table width="80%" height="55" style="border:1px;" align="center">
            <tr bgcolor='#CCCFF1'>
                <th class="colEnc">N°</th>
                <th class="colEnc">Código Area</th>
                <th class="colEnc">C.I.</th>
                <th class="colEnc">Paterno</th>
                <th class="colEnc">Materno</th>
                <th class="colEnc">Nombres</th>
                <th class="colEnc">Cargo</th>
                <th class="colEnc">Estado</th>
                <th class="colEnc">Código de Ubicación</th>
                <!--<th class="colEnc">Acciones</th>-->
            </tr>
            <?php

            $db = Core::Conectar();

            $consulta = "SELECT top 10 d.id_departamento, d.nom_departamento, a.codigo_area, a.nom_area, p.id_personal, p.ubicacion, p.ci, p.apaterno, p.amaterno, p.nombres, 
                        c.descripcion, p.direccion, p.telefonos, case p.estado when 1 then 'ACTIVO' else 'NO ACTIVO' end estado, p.ubicacion, 
                        (select usuario from usuarios where id_personal=p.id_personal) usuario 
                        FROM personal p, departamentos d, area a, cargo c 
                        WHERE d.id_departamento=a.id_departamento and a.id_area=p.id_area and c.id_cargo=p.id_cargo
                        --ORDER BY CAST(p.apaterno AS varchar(max))
                        ORDER BY id_personal desc";

            $resultado = $db->prepare($consulta);
            $resultado->execute();
            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $i = 0;
            if (count($resultado) > 0) {
                foreach ($resultado as $fila) {
                    $id = $fila['ci'];
                    //echo 'llega';
                    $i = $i + 1;
                    ?>
                    <tr bgcolor="#F2F9FF">
                        <td align="center" class="colDat">
                            <?php echo $i; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["codigo_area"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["ci"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["apaterno"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["amaterno"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["nombres"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["descripcion"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["estado"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php
                            echo $fila["id_departamento"];
                            echo '.';
                            echo $fila["codigo_area"];
                            echo '.';
                            echo $fila["ubicacion"];
                            ?>
                        </td>
                        <!--<td align="center" class="colDat"><?php echo "<a href='reg_usu.php?id_personal=" . $fila["id_personal"] . "'title='registrar'>REGISTRO USUARIO</a>"; ?></td>-->
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

    </center>

    <br /><br />
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
        width: 92%;
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

    .error {
        font-family: Tahoma, Verdana, Arial;
        font-size: 11px;
        color: #707070;
        /*background-color: #ff0000;*/
        color: red;
        border-width: 0;
    }

    .sinerror {
        font-family: Tahoma, Verdana, Arial;
        font-size: 11px;
        color: #707070;
        /*background-color: #FFFFFF;*/
        color: green;
        border-width: 0;
    }
</style>