<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("../theme/header_reportes.php");
    ?>
    <script language="javascript">
        function visibilidadDiv(id) {
            div = document.getElementById(id);
            document.getElementById("completo").value = '';
            document.getElementById("simple").value = '';
            document.getElementById("des").value = '';
            document.getElementById("anio").value = '';
            document.getElementById("porcentaje").value = '';

            if (div.style.display == "block") {
                div.style.display = "none";
            } else {
                div.style.display = "block";
            }
        }
    </script>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <link rel="stylesheet" type="text/css" href="../theme/css/jquery.dataTables.css">

    <style type="text/css" class="init">

    </style>
    <script type="text/javascript" language="javascript" src="../theme/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

    <script type="text/javascript">
        function imprSelec(imprime) { var ficha = document.getElementById(imprime); var ventimp = window.open(' ', 'popimpr'); ventimp.document.write(ficha.innerHTML); ventimp.document.close(); ventimp.print(); ventimp.close(); }
    </script>
    <br><br><br><br>
    <center>
        <div id="imprime" style='overflow-y:auto;width:95%;'>
            <img src="../theme/images/sabor/gaucho.png" width="15%" align="left">
            <table>
                <tr>
                    <td class="titulo">REPORTE DE PERSONAL ADMINISTRATIVO Y CONTRATO</td>
                </tr>
                <tr>
                    <td class="subtitulo" style="text-align: center">AL <?php echo date("d-m-Y"); ?></td>
                </tr>
            </table><br>

            <br>
            <div style='overflow-y:auto;width:100%;'>
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
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
                    </thead>
                    <tbody>
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
                                $i = $i + 1;
                                ?>
                                <tr>
                                    <th>
                                        <?php echo $i; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["nom_departamento"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["nom_area"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["descripcion"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["ci"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["apaterno"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["amaterno"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["nombres"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["direccion"]; ?>
                                    </th>
                                    <th>
                                        <?php echo $fila["telefonos"]; ?>
                                    </th>
                                </tr>
                                <?php
                            }
                        }
                        $db = null;
                        ?>
                    </tbody>
                </table>
                <br>
                <p><a class="button" href="listado_personalpdf.php">Reporte PDF</a></p>
            </div>
            <br><br>
        </div>
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