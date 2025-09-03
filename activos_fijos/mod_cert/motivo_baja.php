<?php
session_start();
if($_SESSION["usuario_nombre"])
{
require("theme/header_inicio.php");
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
include_once 'mod_configuracion/clases/conexion.php';
$db = Core::Conectar();

if(!isset($_REQUEST["id"])){
?>
<form name="match_form" method="post" action="mod_cert/guardar.php?op=2">
    <center>
    <div class="estilo_div" >
	<div align="right"><a href="<?php echo "index.php?ruta=".urlencode(generarCodigoSeguro("pagina_3")) ?>"><img src="theme/images/volver.jpg" width="30" height="30"/><strong>VOLVER</strong></a></div>
        <table><tr><td class="titulo">MOTIVO DE LA BAJA</td></tr>            
            <tr><td class="subtitulo" style="text-align: center">Motivos para dar baja</td></tr>
        </table><br>
        <button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registar Motivo de Baja</button><br><br>
        
        <div id="nuevo" style="display: none;" class="estilo_subdiv">        
            <center>
            <table>
                <tr><td colspan="2" class="subtitulo" style="text-align: center">Registrar</td></tr>
                <tr style="height: 10px"><td></td><td></td></tr>
                <tr><td>Motivo:</td><td><textarea name="motivo" id="motivo" rows="5" cols="20" ></textarea></td></tr>                
            </table>
            </center>
            <br>
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
	    <th class="colEnc">ID</th>
            <th class="colEnc">MOTIVO</th>
            <th class="colEnc">ESTADO</th>
            <th class="colEnc" colspan="2">ACCIONES</th>
            </tr> 
<?php
 $resultado ="SELECT id_motivo, motivo, case estado when 1 then 'ACTIVO' else 'NO ACTIVO' end estado FROM motivo_baja order by id_motivo asc";
 $resultado =$db->query($resultado);
 $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
 $i=0;
 if(count($resultado)>0){
 
	 foreach($resultado as $fila){
		$i=$i+1;		
?>
            <tr bgcolor="#F2F9FF">   
            <th scope="row" class="colDat"><?php echo $fila["id_motivo"];?></th>
            <td align="center" class="colDat"><?php echo $fila["motivo"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["estado"]; ?></td>
            <td align="center" class="colDat">
                <!-- <a href="motivo_baja.php?id=<?php echo $fila["id_motivo"];?>"><img src="images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px"/></a> -->
                <a href="attached.php?op=5&id=<?php echo $fila["id_motivo"]; ?>"><img src="mod_cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a>
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
    </center>
<?php
} else {
    $id=$_REQUEST["id"];
    $resultado ="SELECT motivo, case estado when 1 then 1 else 0 end estado FROM motivo_baja where id_motivo=$id";
    $resultado =$db->query($resultado);
    foreach($resultado as $fila){
        $motivo=$fila[0];
        $estado=$fila[1];
    }
?>    
<form name="match_form" method="post" action="guardar.php?op=18&d=<?=$id?>">
    <center>
    <div class="estilo_div" >
        <table><tr><td class="titulo">MOTIVO DE LA BAJA</td></tr>            
            <tr><td class="subtitulo" style="text-align: center">Motivos para dar baja</td></tr>
        </table><br>
        
        <div id="nuevo" class="estilo_subdiv">        
            <center>
            <table>
                <tr><td colspan="2" class="subtitulo" style="text-align: center">Modificar</td></tr>
                <tr style="height: 10px"><td></td><td></td></tr>
                <tr><td>Motivo:</td><td><textarea name="motivo" id="motivo" rows="5" cols="20" ><?=$motivo?></textarea></td></tr>
                <tr><td>&nbsp;</td><td><input type="radio" name="activo" value="1" <?=$estado==1?'checked':''?>> Activo<br><input type="radio" name="activo" value="0" <?=$estado==0?'checked':''?>> Inactivo</td></tr>
            </table>
            </center>
            <br>
            <center>
                <input type="submit" value="GUARDAR" class="button">
                <a href="motivo_baja.php"><input id="CANCELAR" type="button" value="CANCELAR" class="button"></a>
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
}
else
header('Location: index.php');    
?>
