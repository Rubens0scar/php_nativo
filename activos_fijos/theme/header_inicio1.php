
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de activos</title>
        <link rel="stylesheet" href="../theme/css/style.css" type="text/css">
            <link rel="stylesheet" type="text/css" href="../theme/css/superfish.css" media="screen">
                <script type="text/javascript" src="../theme/js/jQuery.js"></script>
                <script type="text/javascript" src="../theme/slide/slide.js"></script>
                <!--<script type="text/javascript" src="../theme/js/funciones.js"></script>-->
                <script type="text/javascript" src="../theme/js/hoverIntent.js"></script>
                <script type="text/javascript" src="../theme/js/superfish.js"></script>
                <script type="text/javascript" src="../mod_cert/js/jquery-1.3.2.min.js"></script>
                <!-- <script type="text/javascript" src="../mod_cert/js/combos.js"></script>-->
                <!--<script src="../mod_cert/js/jquery-ui.js" type="text/javascript"></script>-->
                <script src="../mod_cert/js/calendarDateInput.js" type="text/javascript"></script>
                <script src="../mod_cert/js/fondo.js" type="text/javascript"></script>
                <script src="../mod_cert/js/jquery.datetimepicker.full.js" type="text/javascript"></script>
                <script src="../mod_usuarios/js/jquery-2.2.3.min.js" type="text/javascript"></script>
                </head>
                <?php
                
                ?>

                <html>
                    <body>

                        <table id="header" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="1">
                                                <div style="position:absolute; width:345px; top:43px; background:url(../theme/images/cn-bg.gif); left: 1px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="1"><img src="../theme/images/logo.jpg" alt="" width="61" height="61" class="logo"/></td>
                                                            <td class="company_name"><center>"SISTEMA DE INFORMACIÓN PARA EL CONTROL Y SEGUIMIENTO DE ACTIVOS FIJOS - SIdboF"</center></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div id="slogan">
                                                    <div style="position:absolute; top:10px; left:378px; margin-left:-400px; width:681px; height:25px; font-size:25px; color:#000; font-family:'Courier New', Courier, monospace;">
                                                        <marquee direction="left" width="100%" scrollamount="7">
                                                            <span class="Estilo9"><?php echo "BIENVENIDO " . $_SESSION["usuario_nombre"] . " " . $_SESSION["usuario_paterno"] . " AL SIdboF DE LA COOPERATIVA SAN ANDRÉS LTDA."; ?></span>
                                                        </marquee></div>
                                                </div>
                                                <img src="../theme/images/con7.jpg" alt="" width="666" height="178"></td>
                                            <td class="hbg">&nbsp;</td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>

                        <!-- Menu -->
                        <div id="navigator">
<ul class="sf-menu">
			<li class="current">
				<a href="">Inicio</a>
				<ul>
					<li>
						<a href="../mod_inicio/index.php">Principal</a>
					</li>
					<li>
                                            <a href="../mod_inicio/logout.php">Salir</a>
					</li>
				</ul>
			</li>
			
			<li><a href="">Registros</a>
				<ul>
					<li>
						<a href="../mod_usuarios/reg_personal.php">Administracion del Personal</a>
						
					</li>		
					<li>
						<a href="#">Administracion del Sistema</a>
						<ul>
							<li><a href="../mod_inicio/regsis.php">Registros</a></li>
							<li><a href="../mod_inicio/repsis.php">Reportes</a></li>
							
						</ul>
					</li>					
				</ul>			
                        </li>
                        <li>
                            <a href="#">Activos</a>
                            <ul>
				<li><a href="../mod_cert/activos.php">Registrar Adquisiciones</a></li>
                                <li><a href="../mod_cert/asignacion.php">Asignación de Activos</a></li>
                                <li><a href="#">Recepcion Activos</a></li>
                                <li><a href="#">Transferencia Activos</a></li>
                                <li><a href="#">Devolución Activos</a></li>
                            </ul>
			</li>
			 <li><a href="../mod_cert/etiquetas.php">Etiquetación</a></li>
			 <li>
                            <a href="#">Reportes</a>
                            <ul>
							<li><a href="../mod_cert/listado_personal.php">Clasificador Directorio y Funcionarios</a></li>
							<li><a href="../mod_cert/listado.php">Reporte General de Activos según Intérvalo de Fechas</a></li>
                            <li><a href="../mod_cert/reportegam.php">Reporte Extendido de Activos según Intérvalo de Fechas y Grupo Contable</a></li>
							<li><a href="../mod_cert/reportecomfac.php">Reporte Extendido de Activos según Intérvalo de Fechas y Comprobante de Factura</a></li>
                                
                            </ul>
			</li>
		</ul>

                        </div>
                        <!-- Final del menu -->

