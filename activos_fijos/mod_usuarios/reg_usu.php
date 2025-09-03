<?php
session_start();
if($_SESSION["usuario_nombre"])
{
//require("../mod_configuracion/clases/conexion.php");
require(".theme/header_inicio.php");
include_once 'mod_configuracion/clases/conexion.php';
$db = Core::Conectar();

$id_personal=$_REQUEST["id_personal"];
?>
<br />
<div class="titulo">Registro de Usuarios</div><br /><br />

<form name="usuario" action="mod_usuarios/guardar_usu.php?op=2" method="post">

                           
<table class="tabla" align="center" width="500">
<input type="hidden" name="id_personal" value="<?php echo $id_personal; ?>">
<tr>
	<td colspan="2" class="tdatos" align="center"><h3>DATOS DEL USUARIO</h3></td>
</tr>
<tr>
	<td class="tdatos">Usuario:</td>
	<td><input type="text" name="usuario"  size="45" required/></td>
</tr>

<tr>
	<td class="tdatos">Password:</td>
	<td><input type="password" name="pass1" size="45" required></td>
</tr>
<tr>
	<td class="tdatos">Repetir Password:</td>
	<td><input type="password" name="pass2" size="45" required></td>
</tr>

<!-- Add data to Table Professional -->

<tr>
	<td class="tdatos">Estado:</td><td><input type="radio" name="activo" value="true"  checked="checked">
                Activo
                &nbsp; 
                <input type="radio" name="activo" value="false"> 
                Inactivo </td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="REGISTRAR" size="20" class="button">
	<input name="Restablecer" type="reset" value="Limpiar" /></td>
</tr>
</table>
</form>

<br /><br />
<?php
require("theme/footer_inicio.php");
}
else
header('Location: index.php');
?>
