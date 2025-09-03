<?php
//session_start();
include_once("clases/conexion.php");

// Cargar PHPMailer manualmente (sin Composer)
require '../libs/PHPMailer/PHPMailer.php';
require '../libs/PHPMailer/SMTP.php';
require '../libs/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!empty($_POST['usuario']) && !empty($_POST['correo'])) {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $nuevaPassword = bin2hex(random_bytes(4)); // Ej: 8 caracteres aleatorios
    $nuevaPasswordHash = md5($nuevaPassword);

    $db = Core::Conectar();

    // Verificar que el usuario y correo existen
    $consulta = "SELECT * FROM [dbo].[usuarios] u inner join [dbo].[personal] p on p.id_personal = u.id_personal WHERE CAST(u.usuario AS VARCHAR(MAX)) = trim('$usuario') AND CAST(p.correo AS VARCHAR(MAX)) = trim('$correo') ";
    
    $resultado = $db->query($consulta);
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultado) > 0) {
        // Actualizar la contraseña
        $sql = "UPDATE dbo.usuarios SET pws_usuario = '$nuevaPasswordHash' WHERE CAST(usuario AS VARCHAR(MAX)) = trim('$usuario')";
        
        $datos = $db->query($sql);

        // Enviar correo
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sabor.gaucho.25@gmail.com'; // TU GMAIL
            $mail->Password   = 'wueflgfowlecpwza'; // CONTRASEÑA DE APLICACIÓN
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('sabor.gaucho.25@gmail.com', 'Soporte - Sistema Activos');
            $mail->addAddress($correo, $usuario);

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo Password de Ingreso - Sistema de Activos Fijos';
            $mail->Body    = "Hola <b>$usuario</b>,<br><br>Tu nuevo Password es: <b>$nuevaPassword</b><br><br>Por favor cambia el Password.";

            $mail->send();

            setcookie("mensaje", "Password enviado correctamente al correo.", time() + 5, "/");
        } catch (Exception $e) {
            setcookie("mensaje", "Error al enviar el correo: " . $mail->ErrorInfo, time() + 5, "/");
        }

    } else {
        setcookie("mensaje", "El usuario o correo no existen.", time() + 5, "/");
    }

    header("Location: ../index.php");
    exit();
} else {
    setcookie("mensaje", "Todos los campos son requeridos.", time() + 5, "/");
    header("Location: ../index.php");
}