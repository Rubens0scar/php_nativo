<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
    ?>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <title>DataTables example - Zero configuration</title>
    <link rel="stylesheet" type="text/css" href="theme/css/jquery.dataTables.css">

    <style type="text/css" class="init">

    </style>
    <script type="text/javascript" language="javascript" src="theme/js/jquery.dataTables.js">
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
                <td class="titulo">Personal para Transferencia de Activos</td>
            </tr>
        </table><br>

        <div id="nuevo" style="display: none;" class="estilo_subdiv">

            <br>
        </div>
        <br>

        <table id="resultado" class="display" width="90%" height="55" style="border:1px;" align="center">
            <thead>
                <tr bgcolor='#CCCFF1'>
                    <th class="colEnc">N°</th>
                    <th class="colEnc">C.I.</th>
                    <th class="colEnc">Nombres</th>
                    <th class="colEnc">Cargo</th>
                    <th class="colEnc">Estado</th>
                    <th class="colEnc">Código de Ubicación</th>
                    <th class="colEnc">Transferencia</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once 'mod_configuracion/clases/conexion.php';
                $db = Core::Conectar();
                $consulta = "SELECT d.id_departamento, codigo_departamento, d.nom_departamento, a.codigo_area, a.nom_area, p.id_personal, p.ubicacion, p.ci, concat(p.nombres,' ',p.apaterno,' ', p.amaterno) nom_personal, c.descripcion cargo, p.direccion, p.telefonos, p.estado 
                FROM personal p, departamentos d, area a, cargo c
                WHERE p.estado=1 and d.codigo_departamento=a.id_departamento and a.id_area=p.id_area and c.id_cargo=p.id_cargo
                AND p.id_personal in (select id_usuario_asig from asignacion_activos where estado=1)
                order by a.id_area";
                $resultado = $db->query($consulta);                
                $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $i = 0;

                if (count($resultado) > 0) {
                    foreach ($resultado as $fila) {

                        $i = $i + 1;
                        ?>
                        <tr bgcolor="#F2F9FF">
                            <th align="center" class="colDat">
                                <?php echo $i; ?>
                            </th>
                            <th align="center" class="colDat">
                                <?php echo $fila["ci"]; ?>
                            </th>
                            <th align="center" class="colDat">
                                <?php echo $fila["nom_personal"]; ?>
                            </th>
                            <th align="center" class="colDat">
                                <?php echo $fila["cargo"]; ?>
                            </th>
                            <th align="center" class="colDat">
                                <?php echo $fila["estado"]; ?>
                            </th>
                            <th align="center" class="colDat">
                                <?php
                                echo $fila["id_departamento"];
                                echo '.';
                                echo $fila["codigo_area"];
                                echo '.';
                                echo $fila["ubicacion"];
                                ?>
                            </th>
                            <th align="center" class="colDat">
                                <?php echo "<a href='mod_cert/asignacion2.php?id_personal=" . $fila["id_personal"] . "'title='transferencia'>TRANSFERENCIA</a>"; ?>
                            </th>
                        </tr>
                        <?php
                    }
                }
                $db = null;
                ?>
            </tbody>
        </table>

    </center>

    <?php
    require("theme/footer_inicio.php");
} else
    header('Location: i
    ndex.php');
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