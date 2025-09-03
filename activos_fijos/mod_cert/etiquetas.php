<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
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

        function toggleSelectAll(source) {
                const checkboxes = document.querySelectorAll('.seleccionar');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = source.checked;
                });
            }

        document.addEventListener('DOMContentLoaded', function() {
            

            function generarCodigosQR() {
                // Obtener todos los checkboxes con la clase 'seleccionar'
                const checkboxes = document.querySelectorAll('.seleccionar');
                const idsSeleccionados = [];

                // Recorrer los checkboxes y verificar cuáles están seleccionados
                checkboxes.forEach((checkbox) => {
                    if (checkbox.checked) {
                        idsSeleccionados.push(checkbox.id);
                    }
                });

                if (idsSeleccionados.length === 0) {
                    alert('No se ha seleccionado ningún checkbox');
                    return;
                }

                let popupContent = `
                    <html>
                    <head>
                        <title>Códigos QR para imprimir</title>
                        <style>
                            .qr-container {
                                display: grid;
                                grid-template-columns: repeat(3, 1fr); /* Ajusta el número de columnas aquí */
                                gap: 15px;
                                padding: 20px;
                            }
                            .qr-item {
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                align-items: center;
                                border: 1px solid #000;
                                padding: 10px;
                                box-sizing: border-box;
                                width: 210px;
                                height: 140px; /* Aumentar el alto para incluir el texto */
                            }
                            .qr-text {
                                margin-top: 5px;
                                font-size: 8px;
                                text-align: center;
                                font-family: verdana;
                            }
                        </style>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"><\/script>
                    </head>
                    <body>
                        <div class="qr-container">`;
                let i=0;
                idsSeleccionados.forEach((id) => {
                    popupContent += `
                        <div class="qr-item">
                            <table>
                                <tr>
                                 <td><img src="mod_cert/images/gaucho.jpg" style="height: 90;width: 100;" /></td>
                                 <td>
                                    <div id="qr-${i}"></div>
                                    <div class="qr-text">${id}</div> <!-- Texto corto debajo del QR -->
                                 </td>
                                </tr>
                            </table>
                        </div>`;
                    i=i+1;
                });

                popupContent += `
                        </div>
                        <script>
                            const idsSeleccionados = ${JSON.stringify(idsSeleccionados)};
                            let i=0;
                            idsSeleccionados.forEach((id) => {
                                new QRCode(document.getElementById('qr-' + i), {
                                    text: id,
                                    width: 100,
                                    height: 90
                                });
                                i=i+1;
                            });
                        <\/script>
                    </body>
                    </html>`;

                // Abrir el popup y escribir el contenido HTML
                const popupWindow = window.open('', '_blank', 'width=800,height=600');
                popupWindow.document.open();
                popupWindow.document.write(popupContent);
                popupWindow.document.close();
            }

            // Hacer la función accesible globalmente
            window.generarCodigosQR = generarCodigosQR;
        });
    </script>
    <br><br><br><br>
    <center>
        <div class="estilo_div">
            <table>
                <tr>
                    <td class="titulo">ETIQUETADO DE ACTIVOS</td>
                </tr>
                <tr>
                    <td class="subtitulo" style="text-align: center">Etiquetado de la Institución</td>
                </tr>
            </table>
            <br>

            <div id="nuevo" style="display: none;" class="estilo_subdiv">
                <br>
            </div>
            <br>
            <div style='overflow-y:auto;width:95%;'>
                <p><input type="text" id="buscador" placeholder="Buscar..." onkeyup="filtrarTabla()" /></p><br/>

                <table id="etiquetado" name="etiquetado" width="90%" height="55" style="border:1px;" align="center">
                    <thead>
                        <tr bgcolor="#F2F9FF" >
                            <th>COD RESUMEN</th>  
                            <th>CODIGO ACTIVO</th>  
                            <th>IDENTIFICADOR</th>  
                            <th>COD SUBGRUPO</th>  
                            <th>DESCRIPCION</th>  
                            <th>GESTION</th>  
                            <th>GENERAR QR PARA IMPRESION <br><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">Todo</th>  
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include_once 'mod_configuracion/clases/conexion.php';
                    $db = Core::Conectar();
                    $consulta = "SELECT isnull(ri.id_tipo_activos,0) as id_tipo_activos,isnull(ta.descripcion,'SIN TIPO') as descripcion,g.cod_resumen,a.id_activo,a.cod_subgrupo,ri.id_registro_activos,ri.id_registro_individual,ri.descripcion_act,ra.id_registro_activos,ra.descripcion,a.nombre,ri.gestion
                    FROM registro_individual ri
                    left join registro_activos ra on ra.id_registro_activos=ri.id_registro_activos
                    left join activo a on a.id_activo=ri.id_activo
                    left join grupo_contable g on g.id_grupo_contable=ra.id_grupo_contable
					left join [dbo].[tipo_activos] ta on ta.id_tipo_activos = ri.id_tipo_activos
                    order by ra.id_registro_activos";

                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $i = 0;
                    if (count($resultado) > 0) {
                        foreach ($resultado as $fila) {
                            ?>
                            <tr bgcolor="#F2F9FF">
                                <td align="center" class="colDat">
                                    <?php echo $fila["cod_resumen"];?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["id_tipo_activos"];?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["id_activo"];?>
                                </td>                                                        
                                <td align="center" class="colDat">
                                    <?php echo $fila["cod_subgrupo"];?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["descripcion_act"];?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["gestion"]; ?>
                                </td>

                                <td align="center" class="colDat">
                                    <input type="checkbox" id="<?php echo $fila["id_activo"].'-'.$fila["id_tipo_activos"].'-'.$fila["descripcion_act"];?>" class="seleccionar" >
                                </td>

                            </tr>
                            <?php
                    }

                }
                $db = null;
                ?>
                    </tbody>
                </table>
                <br>
                <button onclick="generarCodigosQR()" class="button">Imprimir QR seleccionados</button>    
            </div>
            <br>
        </div>
    </center>
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
            height: 600px; /* o la altura que necesites */
            overflow-y: auto; /* activa scroll vertical si es necesario */
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
        .qr-container {
            display: flex;
            flex-wrap: wrap;
        }
        .qr-item {
            margin: 10px;
        }
    </style>
    <script>
        function filtrarTabla() {
            let input = document.getElementById("buscador");
            let filtro = input.value.toLowerCase();
            let tabla = document.getElementById("etiquetado");
            let filas = tabla.getElementsByTagName("tr");

            for (let i = 1; i < filas.length; i++) {
                let celdas = filas[i].getElementsByTagName("td");
                let mostrar = false;

                for (let j = 0; j < celdas.length; j++) {
                    let texto = celdas[j].textContent || celdas[j].innerText;
                    if (texto.toLowerCase().indexOf(filtro) > -1) {
                        mostrar = true;
                        break;
                    }
                }

                filas[i].style.display = mostrar ? "" : "none";
            }
        }
    </script>

<?php
    require("theme/footer_inicio.php");
} else
    header('Location: index.php');
?>