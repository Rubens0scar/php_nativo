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
                var textoBusqueda = $("input#ci").val();
                if (textoBusqueda != "") {
                    $.post("mod_usuarios/buscar.php?op=1", { valorBusqueda: textoBusqueda }, function (mensaje) {
                        if (mensaje != "") {
                            //alert(mensaje);
                            var res = mensaje.split("%");
                            //alert(res[0]);
                            $("#codigo_personal").val(res[0]);
                            $("#id_area").val(res[1]);
                            $("#nom_personal").val(res[5]);
                            $("#paterno_personal").val(res[6]);
                            $("#materno_personal").val(res[7]);
                            $("#ci_personal").val(res[4]);
                            $("#cd_ubicacion").val(res[2]);
                            $("#cargo_personal").val(res[8]);
                            $("#dir_personal").val(res[9]);
                            $("#fn_personal").val(res[10]);
                            if (res[11] == 'true') {
                                $("#activo2").removeAttr("checked");
                                $("#activo1").attr('checked', 'checked');
                            } else {
                                $("#activo1").removeAttr("checked");
                                $("#activo2").attr('checked', 'checked');
                            }
                            $("#modificar").show();
                            $("#registrar").hide();
                            $.post("mod_usuarios/buscar.php?op=3", { valorBusqueda: $("#codigo_personal").val() }, function (mensaje) {
                                if (mensaje != "") {
                                    $("#usuarios").show();
                                    $("#usuario").attr('checked', true);
                                    var res = mensaje.split("%");
                                    //alert(res[0]);
                                    $("#usr").val(res[2]);
                                    //$("#pass1").val(res[3]);
                                    //$("#pass2").val(res[3]);
                                    if (res[4] == 'true') {
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
        });
        $("#limpiar").click(function () {
                    $("#registrar").show();
                    $("#modificar").hide();
        });
        $("#modificar").click(function () {
            var aux = 0;
            if ($("#usuario").prop('checked')) {
                aux = 1;
            }
            //alert(aux);
            var estado = true;
            if ($('#activo2').is(':checked')) {
                estado = false;
            }

            var estado_usuario = true;
            if ($('#activo_usu1').is(':checked')) {
                estado_usuario = false;
            }

            var data = {};
            data.id_personal = $("#codigo_personal").val();
            data.id_area = $("#id_area").val();
            data.cd_ubicacion = $("#cd_ubicacion").val();
            //data.cd_ubi3 = id;
            data.ci_personal = $("#ci_personal").val();
            data.nom_personal = $("#nom_personal").val();
            data.paterno_personal = $("#paterno_personal").val();
            data.materno_personal = $("#materno_personal").val();
            data.cargo_personal = $("#cargo_personal").val();
            data.dir_personal = $("#dir_personal").val();
            data.fn_personal = $("#fn_personal").val();
            data.estado = estado;

            data.usr = $("#usr").val();
            data.pass1 = $("#pass1").val();
            data.estado_usuario = estado_usuario;
            data.usuario = aux;

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
        $("#registrar").click(function () {
            if ($("#ci_personal").val() != '') {
                var textoBusqueda = $("#ci_personal").val();
                $.post("buscar.php?op=1", { valorBusqueda: textoBusqueda }, function (mensaje) {
                    if (mensaje == "") {
                        $("#usuario_contraseña").submit();
                    } else {
                        alert("Personal ya existente");
                        $("#ci_personal").focus();
                    }
                });
            } else {
                $("#usuario_contraseña").submit();
            }
        });
        $("#pass2").keyup(function () {
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
        });
    </script><br />
    <div class="titulo">
        <center>Registro de Usuarios</center>
    </div><br />
    <center><table width="90%" height="55" style="border:1px;" align="center">
        <tr bgcolor='#CCCFF1'>
            <th class="colEnc">N°</th>
            <th class="colEnc">C.I.</th>
            <th class="colEnc">Paterno</th>
            <th class="colEnc">Materno</th>
            <th class="colEnc">Nombres</th>
            <th class="colEnc">Cargo</th>
            <th class="colEnc">Código de Ubicación</th>
            <th class="colEnc">Rol</th>
            <th class="colEnc">Acciones</th>
        </tr>
        <?php 
            $consulta = "SELECT d.id_departamento, d.nom_departamento, a.codigo_area, a.nom_area, p.id_personal, p.ubicacion, p.ci, p.apaterno, p.amaterno, p.nombres, c.descripcion as cargo, p.direccion, p.telefonos, 
            case p.estado when 1 then 'ACTIVO' else 'NO ACTIVO' end estado, p.ubicacion, u.usuario, r.descripcion, concat(substring(p.nombres, 1,1),p.apaterno) usuario, concat('casg@',p.ci) clave
            FROM personal p 
            left join area a on a.id_area=p.id_area
            left join departamentos d on d.id_departamento=a.id_departamento
            left join cargo c on c.id_cargo=p.id_cargo
            left join usuarios u on u.id_personal=p.id_personal and u.estado=1
            left join rol r on r.id_rol=u.id_rol
            order by p.id_personal desc";

            $resultado = $db->query($consulta);
            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $i = 0;
            if (count($resultado) > 0) {
                foreach ($resultado as $fila) {
                    $id = $fila['id_departamento'];
                    $i = $i + 1;
        ?>
            <tr bgcolor="#F2F9FF">
                <td align="center" class="colDat">
                    <?php echo $i; ?>
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
                    <?php echo $fila["cargo"]; ?>
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
                <td align="center" class="colDat">
                    <?php
                    echo $fila["descripcion"];
                    ?>
                </td>
                <td align="center" class='button3'>
                <?php 
                    $id_u = $fila["id_personal"];
                    $consulta2 = "SELECT * FROM usuarios WHERE estado=1 and id_personal='$id_u'";
                    $resultado2 = $db->query($consulta2);
                    $i = 0;
                    foreach ($resultado2 as $fil) {
                        $i = $i + 1;
                    }
                    if ($i == 1) {
                        $consulta3 = "SELECT * FROM usuarios WHERE id_personal='$id_u'";
                        $resultado3 = $db->query($consulta3);
                        $estadousu = '';
                        foreach ($resultado3 as $fila3) {
                            if ($fila3["estado"] != FALSE) {
                                $id = $fila['id_personal'];
                                echo "<a href='mod_usuarios/desactivar_usu.php?id=$id'>Desactivar Usuario</a>";                                       
                            } else {
                                /*$id = $fila['id_personal'];
                                echo "<a href='mod_usuarios/activar_usu.php?id=$id'>Activar Usuario</a>";*/
                            }
                        }
                    } else{
                       ?>
                        <form id="crear_usu" name="crear_usu" action="mod_usuarios/crear_usu.php" method="post">
                            <input type="hidden" name="id_personal" id="id_personal"
                                value="<?php echo $fila['id_personal']; ?>">
                            <input type="hidden" name="usuario" id="usuario" value="<?php echo $fila["usuario"]; ?>">
                            <input type="hidden" name="password" id="password" value="<?php echo $fila["clave"]; ?>">
                            <select id="id_rol" name="id_rol" style="height: 20px; width: 40%; text-align: center;"
                                class="inputs" required>
                                <option value="">-SELECCIONAR-</option>
                                <?php
                                $consulta = "SELECT id_rol, descripcion FROM rol where estado=1;";
                                $resultado = $db->query($consulta);
                                foreach ($resultado as $fila) {
                                    ?>
                                    <option value="<?php echo $fila["id_rol"]; ?>"><?php echo $fila["descripcion"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="submit" value="Guardar" class="button">
                        </form>
                       <?php 
                    }
                ?>
                </td>
            </tr>
        <?php
                }
            }
        ?>
    </table></center><br /><br />
<?php
    $db = null;
    require("theme/footer_inicio.php");
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

    .button2:hover {
        background: #EE0B0B;

        color: #EE0B0B;
        border-color: #FBFFAD;
    }

    .button3:hover {
        background: #F8E803;
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