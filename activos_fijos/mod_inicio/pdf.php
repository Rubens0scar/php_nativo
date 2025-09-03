<?php
ob_start();
require_once("../mod_configuracion/clases/conexion.php");
$db = Core::Conectar();
session_start();
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<div id="centercontent" align="center">
    <?php
    $opcion = $_REQUEST["op"];
    $id = $_SESSION["id"];
/////////////////////////////////////////
if ($opcion == "76") {
	$id_personal = $_REQUEST["id_personal"];
            ?>	
            <div id="imprime" style='overflow-y:auto;width:95%;'>

                <?php
				$consuu="SELECT numero, max(numero) as maximo FROM dbo.asignacion_activos WHERE id_personal=$id_personal group by numero ";
				$resuu = $db->query($consuu);
				  if ($resuu->rowCount() > 0) {
                    foreach ($resuu as $filu) {
                        $maximo = $filu["maximo"];
			
				$consa="SELECT * FROM dbo.personal WHERE id_personal=$id_personal ";
				$resa = $db->query($consa);
				  if ($resa->rowCount() > 0) {
                    foreach ($resa as $filaa) {
                      
				
				?>
				 <div align="center">
				 		<table width="90%">
                            <tr>
                                <td><img src="../theme/img/manual_Cooperativas.jpg" width="186" height="100" /></td>
                                <td align="center"><h3>FORMULARIO DE ASIGNACIÓN</h3><p>INDIVIDUAL DE ACTIVOS FIJOS</p></td>
								<td></td><td></td><td></td>
                                <td align="right"><h2><?php echo $maximo; ?></h2></td>
                            </tr>
                        </table>
                 </div>
				 				 
                        <h4 align="right">FECHA ACTUAL: <?php echo date('d/m/Y') ?></h4>
                        <table width="90%" height="55" style="border:1px;" align="center">
                            <tr>  
                                <td><h4> RESPONSABLE: <?php
                                        echo $filaa["paterno_personal"];
                                        echo " ";
                                        echo $filaa["materno_personal"];
                                        echo " ";
                                        echo $filaa["nom_personal"];
                                        ?></h4><h4> CARGO: <?php echo $filaa["cargo_personal"]; ?></h4></td>
                            </tr>    
                        </table>
						<table width="90%" height="55" style="border:1px;" align="center" border="1">
                            <tr bgcolor='#CCCFF1'>
                                <th class="colEnc">N°</th>
                                <th class="colEnc">CÓDIGO </th>
                                <th class="colEnc">DESCRIPCIÓN</th >
                                <th class="colEnc">ESTADO </th>
                                <th class="colEnc">OBSERVACIONES</th>
                            </tr>

				<?php
                $consulta1 = "SELECT p.id_personal, p.nom_personal,  p.paterno_personal,  p.materno_personal, p.cargo_personal, a.od_clas_am, a.codigo, ra.id_regact, aa.numero, extract(year from ra.fecha_compra::date) as anio, ri.descripcion_act, ea.est_tec, aa.observaciones
FROM dbo.personal p, dbo.activo a, dbo.registro_activos ra, dbo.asignacion_activos aa, dbo.estado_activo ea, dbo.registro_individual ri
WHERE ri.id_act=a.codigo and ra.id_regact=ri.id_regact and ri.id_regind=aa.id_regact and p.id_personal=aa.id_personal and ri.estado_activo=ea.id_estado and aa.estado=true and ri.estado=true and p.id_personal=$id_personal and aa.numero=$maximo";

                $resultado1 = $db->query($consulta1);
                $i = 0;
                if ($resultado1->rowCount() > 0) {
                    foreach ($resultado1 as $fila1) {
                        $id = $fila1[0];
                        $i = $i + 1;
                        ?>   
                              <tr bgcolor="#F2F9FF">  
                                <td align="center"><h5><?php echo $i; ?></h5></td>
                                <td align="center"><h5><?php echo $fila1["od_clas_am"]; echo '-'; echo $fila1["codigo"]; echo '-'; echo $fila1["id_regact"]; echo '-'; echo $fila1["anio"]; ?></h5></td>
                                <td align="center"><h5><?php echo $fila1["descripcion_act"]; ?></h5></td>
                                <td align="center"><h5><?php echo $fila1["est_tec"]; ?></h5></td>
                                <td align="center"><h5><?php echo $fila1["observaciones"]; ?></h5></td></tr>
<?php
						 }
        }
						?>
                        </table><br />
					<h5 align="justify">NOTA: A PARTIR DE LA FECHA QUEDA COMO DEPOSITARIO DE TODOS LOS ITEMS QUE SE DETALLAN EN EL FORMULARIO, CUALQUIER PERDIDA DESTRUCCION O MALTRATO QUE PUEDA SUFRIR, SERA IMPUTADA A SU PERSONA MIENTRAS NO DEMUESTRE LO CONTRARIO.</h5>
                    <table width="60%" style="border:1px;" align="center" border="1">
                        <tr>
                        <th align="center" width="15%"><p>Firma</p></th>
                        <th align="center" width="15%"><p>Firma</p></th>
                        <th align="center" width="15%"><p>Firma</p></th>
                        <th align="center" width="15%"><p>Firma</p></th></tr>

                        <tr>
                            <td align="center" style="padding-top: 50px;" width="15%"><h6>RECIBIDO POR</h6></td>
                            <td align="center" style="padding-top: 50px;" width="15%"><h6>ENTREGADO POR</h6></td>
                            <td align="center" style="padding-top: 50px;" width="15%"><h6>Vo.Bo. TESORERO</h6></td>
                            <td align="center" style="padding-top: 50px;" width="15%"><h6>Vo.Bo. JEFE AREA CONTABLE</h6></td></tr>
                    </table>
                    </div>
                    </div>
                    <?php
					}
					}
                }
            }
        }
////////////////////////////////
    $db = null;
    require_once("../dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
    $dompdf->set_paper("letter", $orientation = "portrait");
    $dompdf->load_html(ob_get_clean());
    $dompdf->render();
    $pdf = $dompdf->output();
    $filename = "Asignacion_" . $fila1["id_personal"] . "_" . date('Y-m-d') . '.pdf';
    file_put_contents($filename, $pdf);
    $dompdf->stream($filename);
    ?>