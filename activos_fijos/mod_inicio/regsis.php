<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
	require_once("theme/header_inicio.php");
	?>
	<div id="centercontent" align="center">
		<br />
		<div class="titulo">Registros del Sistema</div>
		<table width="200" align="center" border="0" style="margin-top:50px; margin-bottom:50px;">
			<tr align="center">
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_e")) ?>"><img
							src="theme/images/con1.jpg" width="250" height="180" /><strong>DEPARTAMENTOS</strong></a>
				</td>
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_f")) ?>"><img
							src="theme/images/act (5).jpg" width="250" height="180" /><strong>AREAS</strong></a></td>
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_j")) ?>"><img
							src="theme/images/imagenes22.jpg" width="250" height="180" /><strong>CLASIFICADOR DE
							ACTIVOS</strong></a></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr align="center">
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_g")) ?>"><img
							src="theme/images/act (3).jpg" width="250" height="180" /><strong>EMPRESAS
							PROVEEDORAS</strong></a></td>
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_d")) ?>"><img
							src="theme/images/cambio.png" width="250" height="180" /><strong>TIPO DE CAMBIO</strong></a>
				</td>
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_h")) ?>"><img
							src="theme/images/act (4).jpg" width="250" height="180" /><strong>MOTIVO DE BAJA</strong></a>
				</td>
			</tr>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr align="center">
				<td><a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_i")) ?>"><img
							src="theme/images/act (2).jpg" width="250" height="180" /><strong>GRUPO CONTABLE</strong></a>
				</td>
			</tr>
		</table>

	</div>

	<?php
	require("theme/footer_inicio.php");
} else
	header('Location: index.php');
?>