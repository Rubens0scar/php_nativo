<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("../theme/header_reportes.php");
    ?>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <title>DataTables example - Zero configuration</title>
    <link rel="stylesheet" type="text/css" href="../theme/css/jquery.dataTables.css">

    <script type="text/javascript" language="javascript" src="../theme/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" language="javascript" class="init">

        $(document).ready(function () {
            $('#resultado').DataTable();
        });

    </script>
    <br><br><br><br>
    <center>
        <table>
            <tr>
                <td class="titulo">TRANSFERENCIA DE ACTIVOS</td>
            </tr>
        </table>

        <form action="transfiere_activo.php" method="post">
            <table id="resultado" class="display" width="90%" height="55" style="border:1px;" align="center">
                <thead>
                    <tr bgcolor='#CCCFF1'>
                        <th class="colEnc">N°</th>
                        <th class="colEnc">Nombre del Activo</th>
                        <th class="colEnc">Codigo</th>
                        <th class="colEnc">Descripcion</th>
                        <th class="colEnc">Marca</th>
                        <th class="colEnc">Modelo</th>
                        <th class="colEnc">Serie</th>
                        <th class="colEnc">Estado</th>
                        <th class="colEnc">Observaciones</th>
                        <th class="colEnc">Transferencia</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    include_once '../mod_configuracion/clases/conexion.php';
                    $db = Core::Conectar();

                    $id_transfierea = $_GET["id_personal"];
                    $id_transfiere = $_GET["id_personal2"];
                    $id=$_SESSION["id"];

                    $consulta = "SELECT ga.cod_resumen, ri.id_activo, ri.id_registro_individual, a.nombre, ri.gestion, ri.descripcion_act, ri.marca, ri.modelo, ri.serie, e.est_tec, ri.observaciones, ra.n_adjuntos, aa.id_usuario_asig
                    FROM registro_individual ri, activo a, estado_activo e, registro_activos ra, grupo_contable ga, asignacion_activos aa
                    WHERE ri.estado=1 and ri.id_activo=a.id_activo and ri.id_estado_activo=e.id_estado_activo and ri.id_registro_activos=ra.id_registro_activos and ra.id_grupo_contable=ga.id_grupo_contable and ri.id_registro_individual=aa.id_registro_individual and aa.id_usuario_asig='$id_transfiere' and aa.estado='1'
                    order by ri.id_registro_individual";
                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $i = 0;
                    if (count($resultado) > 0) {
                        foreach ($resultado as $fila) {
                            $i = $i + 1;
                            ?>
                            <tr>
                                <th align="center" class="colDat">
                                    <?php echo $i; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["nombre"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo "CSA-";
                                    echo $fila["cod_resumen"];
                                    echo "-";
                                    echo $fila["id_activo"];
                                    echo "-";
                                    echo $fila["id_registro_individual"];
                                    echo "-";
                                    echo $fila["gestion"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["descripcion_act"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["marca"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["modelo"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["serie"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["est_tec"]; ?>
                                </th>
                                <th align="center" class="colDat">
                                    <?php echo $fila["observaciones"]; ?>
                                </th>
                                <th align="center" class="colDat"><input type="checkbox" name="asignados[]"
                                        value="<?php echo $fila["id_registro_individual"]; ?>">
                                </th>
                            </tr>
                            <?php
                        }
                    }
                    $db = null;
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="id_transfierea" value="<?php echo $id_transfierea; ?>" />
            <input type="hidden" name="id_transfiere" value="<?php echo $id_transfiere; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <center>Observaciones</center>
            <textarea rows="10" cols="50" type="text" name="observaciones"></textarea>
            <br><br><input type="submit" name="btntransferir" value="Asignar" class="button" />
        </form>
    </center>

    <?php
    require("../theme/footer_inicio.php");
} else
    header('Location: ../index.php');
?>
<style>
    .button {
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

    .button:hover {
        background: #365D9D;
        background: linear-gradient(left, #365D9D, #436CAD);
        background: -moz-linear-gradient(left, #365D9D, #436CAD);
        background: -webkit-linear-gradient(left, #365D9D, #436CAD);
        background: -o-linear-gradient(left, #365D9D, #436CAD);
        color: #FFFFFF;
        border-color: #FBFFAD;
    }

    .estilo_div {
        border: solid 10px #ccc;
        border-radius: 15px;
        box-shadow: 8px 8px 10px 0px #818181;
        width: 850px;
    }

    .titulo {
        font-family: algerian;
        color: #001459;
        font-size: 180%;
    }

    .subtitulo {
        font-family: algerian;
        /*color: lightblue;*/
        color: #001459;
        font-size: 120%;
    }

    .estilo_subdiv {
        border: solid 3px #ccc;
        border-radius: 15px;
        width: 450px;
    }

    .inputs {
        float: none;
        padding: 0px;
        font-size: small;
        font-family: verdana;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border: 1px solid rgb(182, 182, 182);
        color: rgb(51, 51, 51);
    }

    .colEnc {
        display: table-cell;
        padding: 5px;
        font-family: monospace;
        font-size: 14px;
        color: #063b82;
        background: #CED4D9;
    }

    .colDat {
        display: table-cell;
        padding: 5px;
        font-family: monospace;
        font-size: 14px;
        color: #063b82;
    }
</style>