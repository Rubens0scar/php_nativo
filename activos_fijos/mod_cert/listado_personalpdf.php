<?php
// Inicia el buffer de salida
ob_start();
$path = '../theme/images/sabor/gaucho.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>

<!-- Contenido HTML del reporte -->
<br><br>
<center>
    <img src="<?php echo $base64?>" width="15%" align="left">
    <table style="margin: 0 auto;">
        <tr>
            <th class="titulo">REPORTE DE PERSONAL ADMINISTRATIVO Y CONTRATO</th>
        </tr>
        <tr>
        <td class="subtitulo" style="text-align: center">AL <?php echo date("d-m-Y"); ?></td>
        </tr>
    </table>
</center>
<br><br>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<table border="0.1" style="text-align:center; font-size:10px">
    <tr>
        <th>N°</th>
        <th>DEPARTAMENTO</th>
        <th>AREA</th>
        <th>CARGO</th>
        <th>C.I.</th>
        <th>AP. PATERNO</th>
        <th>AP.MATERNO</th>
        <th>NOMBRE</th>
        <th>DIRECCIÓN</th>
        <th>TELÉFONOS</th>
    </tr>

<?php
include_once '../mod_configuracion/clases/conexion.php';
$db = Core::Conectar();

$consulta = "SELECT d.id_departamento, d.codigo_departamento, d.nom_departamento, a.codigo_area, a.nom_area, p.ubicacion, p.ci, p.nombres, p.apaterno, p.amaterno, c.descripcion, p.direccion, p.telefonos, p.estado, c.id_cargo 
                FROM personal p, departamentos d, area a, cargo  c
                WHERE p.estado=1 and d.codigo_departamento=a.codigo_area and a.id_area=p.id_area and c.id_cargo=p.id_cargo
                order by a.id_area";

$resultado = $db->query($consulta);
$resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

$i = 0;
if (count($resultado) > 0) {
    foreach ($resultado as $fila) {
        //$id = $fila[0];
        $i++;
?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $fila["nom_departamento"]; ?></td>
            <td><?php echo $fila["nom_area"]; ?></td>
            <td><?php echo $fila["descripcion"]; ?></td>
            <td><?php echo $fila["ci"]; ?></td>
            <td><?php echo $fila["apaterno"]; ?></td>
            <td><?php echo $fila["amaterno"]; ?></td>
            <td><?php echo $fila["nombres"]; ?></td>
            <td><?php echo $fila["direccion"]; ?></td>
            <td><?php echo $fila["telefonos"]; ?></td>
        </tr>
<?php
    }
}
$db = null;
?>
</table>

<?php
// Obtener el contenido HTML generado
$html = ob_get_clean();

// Importar Dompdf directamente desde la carpeta descomprimida
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Configuración de Dompdf
$dompdf = new Dompdf();
$dompdf->setPaper("letter", "landscape"); // Configurar el tamaño y la orientación de la página

// Cargar HTML en Dompdf
$dompdf->loadHtml($html);

// Renderizar el PDF
$dompdf->render();

// Opcional: Guardar el PDF en el servidor
$filename = "Reporte_Personal_" . date('Y-m-d') . ".pdf";
file_put_contents($filename, $dompdf->output());

// Enviar el archivo PDF al navegador
$dompdf->stream($filename, ["Attachment" => 0]); // Attachment = 0 para mostrar en el navegador
?>