<?php
session_start();
if($_SESSION["usuario_nombre"])
{
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
                var textoBusqueda = $("input#cargo_b").val();
                if (textoBusqueda != "") {
                    $.post("mod_usuarios/buscar.php?op=4", { valorBusqueda: textoBusqueda }, function (mensaje) {
                        $("#resultadoBusqueda").html(mensaje);
                        if (mensaje != "") {
                            //alert(mensaje);
                            var res = mensaje.split("-");
                            $("#id_cargo").val(res[0]);
                            $("#cargo").val(res[1]);
                            if (res[2] == 1) {
                                $("#activo2").removeAttr("checked");
                                $("#activo1").attr('checked', 'checked');
                            } else {
                                $("#activo1").removeAttr("checked");
                                $("#activo2").attr('checked', 'checked');
                            }

                            $("#modificar").show();
                            $("#registrar").hide();
                        }
                    });
                }
            });

            $("#limpiar").click(function () {
                $("#registrar").show();
                $("#modificar").hide();
            });

            $("#modificar").click(function () {                

                var estado = 1;
                if ($('#activo2').is(':checked')) {
                    estado = false;
                }


                var data = {};
                data.id_cargo = $("#id_cargo").val();
                data.descripcion = $("#cargo").val();
                data.estado = estado;

                $.ajax({
                    type: "POST",
                    url: "mod_usuarios/guardar_usu.php?op=5",
                    data: data,
                    success: function (text) {
                        alert(text);
                        location.reload();
                    }
                });
            });

            $("#registrar").click(function () {
                $("#usuario_contraseña").submit();                
            });
        });
        </script>
    <br />
    <div class="titulo">Registro de Cargo del Personal</div><br />

    <form name="usuario" action="mod_usuarios/guardar_usu.php?op=4" method="post">
        <input type="hidden" id="id_cargo">
        <center>
            <table class="tabla" width="500">
                <tr>
                    <td colspan="2" class="tdatos" align="center"><h3>DATOS DEL CARGO</h3></td>
                </tr>
                <tr>
                    <td colspan="2" class="tdatos" align="center">
                        <table style="border: none">
                            <tr style="height: 40px">
                                <td class="tdatos">Cargo a buscar:</td>
                                <td><input type="text" name="cargo_b" id="cargo_b" size="45" style="width: 200px" /></td>
                                <td><input type="button" name="buscar" id="buscar" class="button" value="BUSCAR" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="tdatos">Descripción:</td>
                    <td><input type="text" name="cargo" id="cargo" size="45" required/></td>
                </tr>

                <tr>
                    <td class="tdatos">Estado:</td><td><input type="radio" name="activo" value="true"  checked="checked">
                                Activo
                                &nbsp; 
                        <input type="radio" name="activo" value="false"> 
                        Inactivo </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="REGISTRAR" id="registrar" size="20" class="button">
                        <input type="button" value="MODIFICAR" id="modificar" name="modificar" size="20" class="button" style="display: none">
                        <input name="Restablecer" type="reset" id="limpiar" value="LIMPIAR" class="button" />
                    </td>
                </tr>
            </table>
        </center>
    </form>
    <br>
    <center><table width="90%" height="55" style="border:1px;">
        <thead>
            <tr bgcolor='#CCCFF1'>
                <th class="colEnc">CARGO</th>
                <th class="colEnc">FECHA DE REGISTRO</th>
        </thead>
        <tbody>
            <?php
            $resultado = "SELECT top 10 *FROM cargo WHERE estado=1 order by CAST(fecha_reg AS varchar(max)) desc";
            $resultado = $db->query($resultado);
            $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

            $i = 0;
            if (count($resultado) > 0) {
                foreach ($resultado as $fila) {
                    $i = $i + 1;
                    ?>
                    <tr bgcolor="#F2F9FF">
                        <td align="center" class="colDat">
                            <?php echo $fila["descripcion"]; ?>
                        </td>
                        <td align="center" class="colDat">
                            <?php echo $fila["fecha_reg"]; ?>
                        </td>
                        
                        <!--<td align="center" class="colDat">MODIFICAR</td>-->
                    </tr>
                    <?php
                }
            }

            ?>
        </tbody>
    </table></center>

    <br /><br />
    <?php
    require("theme/footer_inicio.php");
}
else
    header('Location: index.php');
?>
