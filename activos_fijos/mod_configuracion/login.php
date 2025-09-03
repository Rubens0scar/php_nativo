<?php
include_once("clases/conexion.php");
include_once("../theme/function.php");

session_start();

// Inicializar intentos si no existen
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

// Si se ingresó un nuevo usuario, reiniciar contador
if (isset($_POST['usuario'])) {
    $usuarioIngresado = $_POST['usuario'];

    // Si el usuario es diferente al último, reiniciar contador
    if (isset($_SESSION['ultimo_usuario']) && $_SESSION['ultimo_usuario'] !== $usuarioIngresado) {
        $_SESSION['intentos'] = 0;
        unset($_SESSION['bloqueado_hasta']); // También quitamos bloqueo si había
    }

    // Guardar el usuario actual en sesión
    $_SESSION['ultimo_usuario'] = $usuarioIngresado;
}

// Verificar si está bloqueado por tiempo
if (isset($_SESSION['bloqueado_hasta']) && time() < $_SESSION['bloqueado_hasta']) {
    $segundos_restantes = $_SESSION['bloqueado_hasta'] - time();
    $minutos = floor($segundos_restantes / 60);
    $segundos = $segundos_restantes % 60;
    ?>
    <script type="text/javascript">
        alert("Has excedido los intentos. Intenta nuevamente en <?= $minutos ?> minuto(s) y <?= $segundos ?> segundo(s).");
        window.location = "../index.php";
    </script>
    <?php
    exit;
}

// Comprobación del login
if ($_POST["usuario"]) {
    $db = Core::Conectar();
    $usuario = $_POST["usuario"];
    $contrasenia = md5($_POST["contrasenia"]);

    $sql = "SELECT u.id_usuario, u.usuario, p.nombres, p.apaterno, p.amaterno, c.descripcion as cargo, p.ci, u.pws_usuario, u.estado, u.id_rol
            FROM usuarios u, personal p, cargo c
            WHERE u.estado=1 AND u.id_personal=p.id_personal 
              AND c.id_cargo=p.id_cargo 
              AND u.usuario LIKE '$usuario' 
              AND u.pws_usuario LIKE '$contrasenia'";

    $datos = $db->query($sql);
    $datos = $datos->fetchAll(PDO::FETCH_ASSOC);

    if (count($datos) == 1) {
        // Login exitoso
        $_SESSION['intentos'] = 0;
        unset($_SESSION['bloqueado_hasta']);
        unset($_SESSION['ultimo_usuario']);

        foreach ($datos as $row) {
            $_SESSION["usuario"] = $row['usuario'];
            $_SESSION["contrasenia"] = $row['pws_usuario'];
            $_SESSION["usuario_nombre"] = $row['nombres'];
            $_SESSION["usuario_paterno"] = $row['apaterno'];
            $_SESSION["usuario_materno"] = $row['amaterno'];
            $_SESSION["cargo"] = $row['cargo'];
            $_SESSION["id"] = $row['id_usuario'];
            $_SESSION["ci"] = $row['ci'];
            $_SESSION["rol"] = $row['id_rol'];
        }

        $pagina = urlencode(generarCodigoSeguro("pagina_a"));
        header("Location: ../index.php?ruta=" . $pagina);
    } else {
        $_SESSION['intentos']++;

        if ($_SESSION['intentos'] >= 3) {
            $_SESSION['bloqueado_hasta'] = time() + (5 * 60); // 5 minutos
            ?>
            <script type="text/javascript">
                alert("Has fallado 3 veces. Usuario bloqueado por 5 minutos.");
                window.location = "../index.php";
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                alert("Usuario o Password incorrecto. Intento Nro: <?= $_SESSION['intentos'] ?> de 3");
                window.location = "../index.php";
            </script>
            <?php
        }
    }
}
?>