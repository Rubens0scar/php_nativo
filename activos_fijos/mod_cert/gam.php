<?php
session_start();
if($_SESSION["usuario_nombre"])
{
require("theme/header_inicio.php");
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

if(!isset($_REQUEST["id"])){
?>
<form name="match_form" method="post" action="mod_cert/guardar.php?op=6">
    <center>
    <div class="estilo_div" >
	<div align="right"><a href="<?php echo "index.php?ruta=".urlencode(generarCodigoSeguro("pagina_3")) ?>"><img src="theme/images/volver.jpg" width="30" height="30"/><strong>VOLVER</strong></a></div>
        <table><tr><td class="titulo">GRUPO CONTABLE DE ACTIVOS FIJOS</td></tr>  
        </table><br>
        <button type="button" class="button" onclick="javascript: visibilidadDiv('nuevo');">Registar Activos y/o Materiales</button><br><br>
        
        <div id="nuevo" style="display: none;" class="estilo_subdiv">        
            <center>
            <table>
                <tr><td colspan="2" class="subtitulo" style="text-align: center">Registrar</td></tr>
                <tr style="height: 10px"><td></td><td></td></tr>                
                
                <tr><td>Código Contable Completo: </td><td><input type="text" id="completo" name="completo" style="height: 20px; width:82%; text-align: center;" maxlength="20" onkeypress="return numeros(event)" class="inputs" required/></td></tr>
                <tr><td>Código Contable Simple: </td><td><input type="text" id="simple" name="simple" style="height: 20px; width:82%; text-align: center;" maxlength="100" class="inputs" onkeypress="return numeros(event)" required/></td></tr>
                <tr><td>Descripción: </td><td><input type="text" id="des" name="des" style="height: 20px; width:82%; text-align: center;" maxlength="100" class="inputs" required/></td></tr>
                <tr><td>Años de Depreciación: </td><td><input type="text" id="anio" name="anio" style="height: 20px; width:82%; text-align: center;" maxlength="20" class="inputs" required/></td></tr>
                <tr><td>Porcentaje de Depreciación: </td><td><input type="text" id="porcentaje" name="porcentaje" style="height: 20px; width:82%; text-align: center;" maxlength="20" class="inputs" required/></td></tr>
                <tr><td>&nbsp;</td><td><input type="radio" name="activo" value="1"  checked="checked"> Activo<br><input type="radio" name="activo" value="0"> Inactivo</td></tr>
            </table>
            </center>
            <br>
            <center>
                <input type="submit" value="GUARDAR" class="button">
                <input id="cancelar" type="button" value="Cancelar" class="button" onclick="javascript: visibilidadDiv('nuevo');">
            </center>
            
            <br>
        </div>
        <br>
        <div style='overflow-y:auto;width:95%;'>
            <table width="90%" height="55" style="border:1px;" align="center">
            <tr bgcolor='#CCCFF1'>
            <th class="colEnc">Código Contable Completo</th>
            <th class="colEnc">Código Contable Simple</th>
            <th class="colEnc">Descripción</th>
            <th class="colEnc">Años de Depreciación</th>
            <th class="colEnc">Porcentaje de Depreciación</th>
            <th class="colEnc">Fecha Registro</th>
            <th class="colEnc" colspan="2">ACCIONES</th>
            </tr> 
<?php
 $consulta ="SELECT g.id_grupo_contable, g.cod_contable, g.cod_resumen, g.descripcion, g.vida_util, g.depcoef, g.fecha_reg, 
                case g.estado when 1 then 'ACTIVO' else 'INACTIVO' end estado 
                FROM grupo_contable g
                order by CAST(g.cod_contable AS varchar(max))";
 $resultado =$db->query($consulta);
 $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
 $i=0;
 if(count($resultado)>0){
 
	 foreach($resultado as $fila){
		$i=$i+1;		
?>
            <tr bgcolor="#F2F9FF">   
            <td align="center" class="colDat"><?php echo $fila["cod_contable"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["cod_resumen"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["descripcion"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["vida_util"]; ?></td>
            <td align="center" class="colDat"><?php echo round(($fila["depcoef"]*100),2); echo ' %'; ?></td>
            <td align="center" class="colDat"><?php echo $fila["fecha_reg"]; ?></td>
            <td align="center" class="colDat">
                <!-- <a href="gam.php?id=<?php echo $fila["id_grupo_contable"];?>"><img src="images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px"/></a> -->
                <a href="attached.php?op=6&id=<?php echo $fila["id_grupo_contable"]; ?>"><img src="mod_cert/images/6.png" alt="" title="MODIFICAR" style="width: 20px; height: 20px" /></a>
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
}else{
    $id=$_REQUEST["id"];
    $resultado ="SELECT cod_contable, cod_resumen, descripcion, vida_util, depcoef, case estado when 1 then 1 else 0 end estado FROM grupo_contable where id_grupo_contable=$id;";
    $resultado =$db->query($resultado);
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $fila){
        $gc_cnta_cm=$fila['cod_contable'];
        $gc_cnta_sp=$fila['cod_resumen'];
        $descripcion=$fila['descripcion'];
        $depvidut=$fila['vida_util'];
        $depcoef=round($fila['depcoef'],2);
        $estado=$fila['estado'];
    }
?>    
<form name="match_form" method="post" action="guardar.php?op=17&d=<?=$id?>">
    <center>
    <div class="estilo_div" >
        <table><tr><td class="titulo">GRUPO CONTABLE DE ACTIVOS FIJOS</td></tr>   
        </table><br>
        
        <div id="nuevo" class="estilo_subdiv">        
            <center>
            <table>
                <tr><td colspan="2" class="subtitulo" style="text-align: center">Modificar</td></tr>
                <tr style="height: 10px"><td></td><td></td></tr>                
               
                <tr><td>Código Contable Completo: </td><td><input type="text" id="completo" name="completo" style="height: 20px; width:82%; text-align: center;" maxlength="20" onkeypress="return numeros(event)" class="inputs" required value="<?=$gc_cnta_cm?>"/></td></tr>
                <tr><td>Código Contable Simple: </td><td><input type="text" id="simple" name="simple" style="height: 20px; width:82%; text-align: center;" maxlength="100" class="inputs" onkeypress="return numeros(event)" required value="<?=$gc_cnta_sp?>"/></td></tr>
                <tr><td>Descripción: </td><td><input type="text" id="des" name="des" style="height: 20px; width:82%; text-align: center;" maxlength="100" class="inputs" required value="<?=$descripcion?>"/></td></tr>
                <tr><td>Años de Depreciación: </td><td><input type="text" id="anio" name="anio" style="height: 20px; width:82%; text-align: center;" maxlength="20" class="inputs" required value="<?=$depvidut?>"/></td></tr>
                <tr><td>Porcentaje de Depreciación: </td><td><input type="text" id="porcentaje" name="porcentaje" style="height: 20px; width:82%; text-align: center;" maxlength="20" class="inputs" required value="<?=$depcoef?>"/></td></tr>
                <tr><td>&nbsp;</td><td><input type="radio" name="activo" value="1" <?=$estado==1?'checked':''?>> Activo<br><input type="radio" name="activo" value="0" <?=$estado==0?'checked':''?>> Inactivo</td></tr>
            </table>
            </center>
            <br>
            <center>
                <input type="submit" value="MODIFICAR" class="button">
                <a href="gam.php"><input id="cancelar" type="button" value="CANCELAR" class="button"></a>
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