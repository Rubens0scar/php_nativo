<?php
session_start();
if($_SESSION["usuario_nombre"])
{
require("../theme/header_reportes.php");
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
<script type="text/javascript">
    function imprSelec(imprime)
    {var ficha=document.getElementById(imprime);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();}
</script>
    <center>
	  <a href="javascript:imprSelec('imprime')"><img src="../theme/images/print.png" width="30" height="30"/ align="right"></a>
        <div id="imprime" style='overflow-y:auto;width:95%;'>        
        <img src="../theme/images/sabor/gaucho.png" width="160" height="100" align="left">
		<table><tr><td class="titulo">REPORTE EXTENDIDO SEGÚN INTÉRVALO DE FECHAS Y COMPROBANTE O FACTURA</td></tr>            
            <tr>
                <td class="subtitulo" style="text-align: center">Reporte Restaurante "SABOR GAUCHO"</td></tr>
        </table><br>
        <div id="nuevo" style="display: none;" class="estilo_subdiv">        
          
            <br>
        </div>
        <br>
        <div style='overflow-y:auto;width:95%;'>
            <table width="90%" height="55" style="border:1px;" align="center">
            <tr bgcolor='#CCCFF1'>
            <th class="colEnc">N°</th>
			<th class="colEnc">DESCRIPCIÓN</th>
			<th class="colEnc">INSTITUCIÓN</th>
			<th class="colEnc">GRUPO CONTABLE</th>
			<th class="colEnc">SUB-GRUPO</th>
			<th class="colEnc">CORRELATIVO</th>
			<th class="colEnc">AÑO DE COMPRA</th>
			<th class="colEnc">FECHA DE COMPRA</th>	
            <th class="colEnc">ACTIVO O BIEN</th>
			<th class="colEnc">UFV</th>
			<th class="colEnc">CANTIDAD</th>
			<th class="colEnc">DESCRIPCIÓN DETALLADA</th>
            <th class="colEnc">VALOR ACTUAL EN BS.</th>
            <th class="colEnc">ESTADO ACTUAL</th>
            <th class="colEnc">RESPONSABLE</th>
            <th class="colEnc">UBICACIÓN</th>
			<th class="colEnc">DISPONIBILIDAD</th>
			<th class="colEnc">OBSERVACIONES</th>
            </tr> 
<?php
include_once '../mod_configuracion/clases/conexion.php';
$db = Core::Conectar();


 $consulta ="SELECT gam.cod_contable, gam.descripcion, gam.cod_resumen, ri.id_activo, ri.id_registro_individual, year(ra.fecha_compra) as anio, ra.fecha_compra, 
                ac.nombre, ra.n_adjuntos, ri.descripcion_act, ri.costo, e.est_tec, ri.observaciones, p.nombres, p.apaterno, p.amaterno, c.descripcion as cargo_personal, 
                p.ubicacion, case ra.estado when 1 then 'ACTIVO' else 'INACTIVO' end estado, tc.ufv_venta
                FROM dbo.registro_activos ra 
                inner join dbo.grupo_contable gam on gam.id_grupo_contable=ra.id_grupo_contable
                inner join dbo.registro_individual ri on ri.id_registro_activos=ra.id_registro_activos 
                inner join dbo.tipo_cambio tc on tc.id_tipo_cambio=ra.id_tipo_cambio 
                inner join dbo.personal p on p.id_personal=ra.id_urecibido 
                inner join dbo.estado_activo e on e.id_estado_activo=ri.id_estado_activo
                inner join dbo.activo ac on ac.id_activo=ri.id_activo
                inner join dbo.cargo c on c.id_cargo=p.id_cargo
                order by ra.id_registro_activos";
 $resultado =$db->query($consulta);
 $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC); 

 $i=0;
 if(count($resultado)>0){
 
	 foreach($resultado as $fila){	 
		//$id = $fila[0];
		$i=$i+1;		
?>
            <tr bgcolor="#F2F9FF"> 
			<td align="center" class="colDat"><?php echo $fila["cod_contable"]; ?></td>
			<td align="center" class="colDat"><?php echo $fila["descripcion"]; ?></td>
			<td align="center" class="colDat"><?php echo 'dbo'; ?></td>
			<td align="center" class="colDat"><?php echo $fila["cod_resumen"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["id_activo"]; ?></td>
			<td align="center" class="colDat"><?php echo $fila["id_registro_individual"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["anio"]; ?></td>
			<td align="center" class="colDat"><?php echo $fila["fecha_compra"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["nombre"]; ?></td> 
            <td align="center" class="colDat"><?php echo $fila["ufv_venta"]; ?></td> 
			<td align="center" class="colDat"><?php echo $fila["n_adjuntos"]; ?></td>
            <td align="center" class="colDat"><?php echo $fila["descripcion_act"]; ?></td>
			<td align="center" class="colDat"><?php echo $fila["costo"]; ?></td> 
			<td align="center" class="colDat"><?php echo $fila["est_tec"]; ?></td>    
			<td align="center" class="colDat"><?php echo $fila["nombres"]; echo ' '; echo $fila["apaterno"];  echo ' '; echo $fila["amaterno"]; ?></td>  
			<td align="center" class="colDat"><?php echo $fila["ubicacion"]; ?></td> 
			<td align="center" class="colDat"><?php echo 'EN USO'; ?></td> 
            <td align="center" class="colDat"><?php echo $fila["observaciones"]; ?></td>          
        </tr>
<?php
         }
 }
 $db = null;
?>       
    </table>
        
        <br>
    </div>
	</div>
    </center>

<?php
require("../theme/footer_inicio.php");
}
else
header('Location: ../index.php');    
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
