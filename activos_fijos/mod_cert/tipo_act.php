<?php
session_start();
if($_SESSION["usuario_nombre"])
{
    require("theme/header_inicio.php");
    ?>
    <script language="javascript">        
        function visibilidadDiv(id) {
            div = document.getElementById(id); 
            document.getElementById("id_activo").value='';
            document.getElementById("descripcion").value='';
            
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

    if(!isset($_REQUEST["id"])){
    ?>
    <form name="match_form" method="post" action="mod_cert/guardar.php?op=19">
        <center>
        <div class="estilo_div" >
            <div align="right"><a href="<?php echo "index.php?ruta=".urlencode(generarCodigoSeguro("pagina_3")) ?>"><img src="theme/images/volver.jpg" width="30" height="30"/><strong>VOLVER</strong></a></div>
                <table><tr><td class="titulo">TIPO DE ACTIVOS</td></tr> 
                    <tr>
                        <td class="subtitulo" style="text-align: center">Agregar el Tipo de Activos</td>
                    </tr>
                </table><br>
                <button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registrar Tipo de Activos</button><br><br>
                
                <div id="nuevo" style="display: none;" class="estilo_subdiv">        
                    <center>
                    <table>
                        <tr><td colspan="2" class="subtitulo" style="text-align: center">Registrar</td></tr>
                        <tr>
                            <td>Activo:</td>
                            <td>
                                <select id="id_activo" name="id_activo" style="height: 20px; width: 82%; text-align: center;"
                                    class="inputs" required>
                                    <option value="">-SELECCIONAR-</option>
                                    <?php
                                    $consulta = "SELECT id_activo, nombre FROM activo where estado=1;";
                                    $resultado = $db->query($consulta);
                                    foreach ($resultado as $fila) {
                                        ?>
                                        <option value="<?php echo $fila["id_activo"]; ?>"><?php echo $fila["nombre"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr><td>Descripción:</td><td><textarea name="descripcion" id="descripcion" rows="3" cols="20" required></textarea></td></tr>                
                    </table>
                    </center><br>
                    <center>
                        <input type="submit" value="GUARDAR" class="button">
                        <input id="cancelar" type="button" value="CANCELAR" class="button" onclick="javascript: visibilidadDiv('nuevo');">
                    </center>
                    <br>
                </div>
                <br>
                <div style='overflow-y:auto;width:95%;'>
                    <table width="90%" height="55" style="border:1px;" align="center">
                        <tr bgcolor='#CCCFF1'>
                            <th class="colEnc">Nº</th>
                            <th class="colEnc">ACTIVO</th>
                            <th class="colEnc">DESCRIPCIÓN</th>
                            <th class="colEnc">ESTADO</th>
                            <th class="colEnc" colspan="2">ACCIONES</th>
                        </tr> 
                        <?php
                        $resultado ="SELECT id_tipo_activos, a.nombre, t.descripcion, t.id_activo, case t.estado when 1 then 'ACTIVO' else 'NO ACTIVO' end estado 
                                        FROM tipo_activos t, activo a
                                        WHERE t.id_activo=a.id_activo
                                        order by id_tipo_activos desc";
                        $resultado =$db->query($resultado);
                        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $i=0;
                        if(count($resultado)>0){
                        
                            foreach($resultado as $fila){
                                $i=$i+1;		
                        ?>
                        <tr bgcolor="#F2F9FF">   
                            <th scope="row" class="colDat"><?php echo $i;?></th>
                            <td align="center" class="colDat"><?php echo $fila["nombre"]; ?></td>
                            <td align="center" class="colDat"><?php echo $fila["descripcion"]; ?></td>
                            <td align="center" class="colDat"><?php echo $fila["estado"]; ?></td>
                            <td align="center" class="colDat">
                                <a href="attached.php?op=11&id=<?php echo $fila["id_tipo_activos"]; ?>"><img src="mod_cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a>
                            </td>
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
        </div>
        </center>
    </form>
    <?php
} else {
}
$db = null;
require("theme/footer_inicio.php");
}
else
header('Location: index.php');    
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