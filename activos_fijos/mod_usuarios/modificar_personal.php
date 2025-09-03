<?php
session_start();
if($_SESSION["usuario_nombre"])
{
    //require("../mod_configuracion/clases/conexion.php");
    require("../theme/header_inicio.php");
    include_once '../mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#modificar").hide();
            $("#buscar").click(function (e) {
                //alert('holas');
                var textoBusqueda = $("input#ci").val();
                if (textoBusqueda != "") {
                    $.post("buscar.php?op=1", {valorBusqueda: textoBusqueda}, function (mensaje) {
                        //$("#resultadoBusqueda").html(mensaje);
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

                            $.post("buscar.php?op=3", {valorBusqueda: $("#codigo_personal").val()}, function (mensaje) {
                                //$("#resultadoBusqueda").html(mensaje);
                                //alert(mensaje);
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
                    url: "guardar_usu.php?op=3",
                    data: data,
                    //typedata:text,
                    success: function (text) {
                        alert(text);
                        location.reload();
                    }
                });
            });
        });
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
        width:92%;
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
    .error{
        font-family: Tahoma, Verdana, Arial;
        font-size: 11px;
        color: #707070;
        /*background-color: #ff0000;*/
        color: red;
        border-width:0;
    }
    .sinerror{
        font-family: Tahoma, Verdana, Arial;
        font-size: 11px;
        color: #707070;
        /*background-color: #FFFFFF;*/
        color: green;
        border-width:0;
    }
</style>
<script>
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
<div class="titulo">Modificacion de Personal</div><br /><br />

<form id="usuario_contraseña" name="usuario_contraseña" action="modificar_usu.php?op=1" method="post">
    <input type="hidden" id="codigo_personal">
    <?php
    $idpersonal=$_GET['id'];
    $consulta = "SELECT * FROM dbo.personal WHERE id_personal='$idpersonal'";
    $resultado = $db->query($consulta);
    foreach ($resultado as $fila) {
        ?>
        <input type="hidden" id="id_personal" name="id_personal" style="height: 20px; width:82%; text-align: center;" maxlength="4" class="inputs" value="<?php echo $idpersonal; ?>" readonly=""></td></tr>
        <?php
    }
    ?>

    <table class="tabla" align="center" width="500">

        <!-- Add data to Table Professional -->
        <tr>
            <td colspan="2" class="tdatos" align="center"><h3>DATOS DE LA PERSONA</h3></td>
        </tr>

        <tr>
            <td class="tdatos">Nombres:</td>
            <td><input type="text" name="nom_personal" id="nom_personal" size="45" value="<?php echo $fila["nom_personal"]; ?>" required ></td>
        </tr>
        <tr><td class="tdatos">Apellido Paterno:</td>
            <td><input type="text" name="paterno_personal" id="paterno_personal" size="45" value="<?php echo $fila["paterno_personal"]; ?>" required/></td></tr>
        <tr><td class="tdatos">Apellido Materno:</td>
            <td><input type="text" name="materno_personal" id="materno_personal" size="45" value="<?php echo $fila["materno_personal"]; ?>" required/></td>
        </tr>
        <tr>
            <td class="tdatos">Cedula de Identidad:</td>
            <td><input type="text" name="ci_personal" id="ci_personal" size="45" value="<?php echo $fila["ci_personal"]; ?>" required/></td>
        </tr>
        <tr><td class="tdatos">Área:</td>
            <td>
                <select id="id_area" name="id_area" style="height: 20px; width: 82%; text-align: center;" class="inputs" required>
                    <option value="">-SELECCIONAR-</option>
                    <?php
                    $consulta2 = "SELECT id_area, nom_area FROM dbo.area where estado=true;";
                    $resultado2 = $db->query($consulta2);
                    foreach ($resultado2 as $fila2) {
                        ?>
                        <option value="<?php echo $fila2["id_area"]; ?>"><?php echo $fila2["nom_area"]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td></tr>
        <tr>
            <td class="tdatos">Codigo de cargo:</td>
            <td><input type="text" name="cd_ubicacion" id="cd_ubicacion" size="45" onkeypress="return NumCheck(event, this)" value="<?php echo $fila["cd_ubicacion"]; ?>" required/></td>
        </tr>

        <tr>
            <td class="tdatos">Cargo:</td>
            <td><input type="text" name="cargo_personal" id="cargo_personal" size="45" value="<?php echo $fila["cargo_personal"]; ?>" required/></td>
        </tr>
        <tr>
            <td class="tdatos">Dirección:</td>
            <td><input type="text" name="dir_personal" id="dir_personal" size="45" value="<?php echo $fila["dir_personal"]; ?>" required/></td>
        </tr>
        <tr>
            <td class="tdatos">Telefono:</td>
            <td><input type="text" name="fn_personal" id="fn_personal" size="45" onkeypress="return numeros(event)" value="<?php echo $fila["fn_personal"]; ?>" required></td>
        </tr>
        <tr>
            <td class="tdatos">Estado:</td><td><input type="radio" id="activo1" name="activo" value="true" checked>
                Activo
                &nbsp; 
                <input type="radio" name="activo" id="activo2" value="false"> 
                Inactivo </td>
        </tr>
        

        <tr>
            <td colspan="2" align="center"><br>
                <input type="submit" value="MODIFICAR" id="registrar" size="20" class="button">
                <input value="CANCELAR" type="button" class='button ' onclick="window.location.href='reg_personal.php'" />
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</form>
<br>
<center>
    <br><br>

</center>

<br /><br />
<?php
$db = null;
require("../theme/footer_inicio.php");
}
else
header('Location: ../index.php');
?>
