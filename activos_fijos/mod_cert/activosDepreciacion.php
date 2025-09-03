<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
    require("theme/header_inicio.php");
?>

    <br><br><br><br>
    <center>
        <div class="estilo_div">
            <table>
                <tr>
                    <td class="titulo">DEPRECIACION DE ACTIVOS</td>
                </tr>
                <tr>
                    <td class="subtitulo" style="text-align: center">Depreciacion de los Activos de la Institucion</td>
                </tr>
            </table>
            <br>

            <div id="nuevo" style="display: none;" class="estilo_subdiv">
                <br>
            </div>
            <br>
            <div style='overflow-y:auto;width:95%;'>
                <p><input type="text" id="buscador" placeholder="Buscar..." onkeyup="filtrarTabla()" /></p><br/>

                <table id="depreciacion" name="depreciacion" width="90%" height="55" style="border:1px;" align="center">
                    <thead>
                        <tr bgcolor="#F2F9FF" >
                            <th>Accion</th>
                            <th>Costo de Compra</th>
                            <th>Coeficiente</th>
                            <th>Valor Residual</th>
                            <th>Antiguedad en Años</th>
                            <th>Depreciacion Acumulada con Valor Residual</th>
                            <th>Depreciacion Acumulada sin Valor Residual</th>
                            <th>Nombre Activo</th>  
                            <!-- <th>Codigo Activo</th>   -->
                            <th>Marca</th>  
                            <th>Descripcion</th>  
                            <th>Modelo</th>  
                            <th>Serie</th>
                            <th>Gestion Compra</th>
                            <th>Observacion</th>
                            <th>Grupo Contable</th>
                            <th>Codigo Contable</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include_once 'mod_configuracion/clases/conexion.php';
                    $db = Core::Conectar();
                    $consulta = "select ri.id_registro_individual, a.nombre, ri.marca,ri.descripcion_act,ri.modelo,ri.serie, ri.gestion,ri.costo,ri.valor_residual, ri.observaciones, gc.descripcion grupo_contable,gc.cod_contable,gc.vida_util,year(GETDATE())-gestion anios_pasados, ea.coeficiente, isnull(dbo.ObtenerArea(ri.id_registro_individual),'SIN LUGAR') area
                                    from [dbo].[registro_individual] ri
                                    inner join [dbo].[estado_activo] ea on ea.id_estado_activo=ri.id_estado_activo
                                    inner join [dbo].[activo] a on a.id_activo=ri.id_activo
                                    inner join [dbo].[grupo_contable] gc on gc.id_grupo_contable=a.id_activo
                                    order by ri.id_registro_activos";

                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $i = 0;
                    if (count($resultado) > 0) {
                        foreach ($resultado as $fila) {
                            $valorInicial = $fila['costo'];
                            $valorResidual = $fila['valor_residual'];
                            $vidaUtilAnios = $fila['vida_util'];
                            $anios = $fila['anios_pasados'];
                            $coeficiente = $fila['coeficiente'];
                            //calculo con valor residual
                            $depreciacionAnual = ($valorInicial - $valorResidual) / $vidaUtilAnios;
                            $depreciacionAcumulada = $depreciacionAnual * $anios;
                            $porcentajeDepreciacion = ($depreciacionAcumulada / $valorInicial) * 100;
                            if ($porcentajeDepreciacion < 33) {
                                $color = "green"; // Nuevo
                            } elseif ($porcentajeDepreciacion < 66) {
                                $color = "yellow"; // Cerca del tope
                            } else {
                                $color = "red"; // Totalmente depreciado
                            }
                            //calculo sin valor residual
                            $depreciacionAcumuladaSV = ($valorInicial*$coeficiente)*$anios;

                            $marca = "Nombre: ".$fila['nombre']." - Marca: " . $fila['marca'];
                            ?>
                            <tr bgcolor="<?php echo $color; ?>" >
                                <td bgcolor="#F2F9FF">
                                    <button class="btn-ver" onclick="mostrarPopup(<?= $fila['id_registro_individual'] ?>, '<?= $fila['valor_residual'] ?>','<?= $fila['cod_contable'] ?>','<?= $fila['grupo_contable'] ?>','<?=$fila['descripcion_act']?>','<?=$fila['area']?>')">
                                        Seleccionar
                                    </button>
                                </td>
                                <td align="center" style="color: white">
                                    <?php echo round($fila["costo"],2); ?>
                                </td>
                                <td align="center" style="color: white">
                                    <?php echo $fila["coeficiente"];?>
                                </td>
                                <td align="center" style="color: white">
                                    <?php echo $fila["valor_residual"];?>
                                </td>
                                <td align="center" style="color: white">
                                    <?php echo $fila["anios_pasados"];?>
                                </td>
                                <td align="center" style="color: white">
                                    <?php echo round($depreciacionAcumulada); ?>
                                </td>
                                <td align="center" style="color: white">
                                    <?php echo round($depreciacionAcumuladaSV,2); ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["nombre"];?>
                                </td>
                                <!-- <td align="center" class="colDat">
                                    <?php //echo $fila["id_tipo_activos"];?>
                                </td> -->
                                <td align="center" class="colDat">
                                    <?php echo $fila["marca"];?>
                                </td>                                                        
                                <td align="center" class="colDat">
                                    <?php echo $fila["descripcion_act"];?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["modelo"];?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["serie"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["gestion"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["observaciones"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["grupo_contable"]; ?>
                                </td>
                                <td align="center" class="colDat">
                                    <?php echo $fila["cod_contable"]; ?>
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
            </div>
            <br>
        </div>
    </center>

    <!-- Popup (se carga dinámicamente) -->
    <div id="popupContainer" class="popup">
        <!-- Aquí se cargará el contenido del popup -->
    </div>
   
    <script>
        function filtrarTabla() {
            let input = document.getElementById("buscador");
            let filtro = input.value.toLowerCase();
            let tabla = document.getElementById("depreciacion");
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

        function mostrarPopup(id, valor, codigo_contable, grupo_contable, descripcion, area) {
            // Crear un formulario oculto para enviar los datos
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'mod_configuracion/popup.php';
            form.style.display = 'none';
        
            // Agregar campos con los datos
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = id;
        
            const inputValor = document.createElement('input');
            inputValor.type = 'hidden';
            inputValor.name = 'valor';
            inputValor.value = valor;

            const inputCodigo = document.createElement('input');
            inputCodigo.type = 'hidden';
            inputCodigo.name = 'codigo_contable';
            inputCodigo.value = codigo_contable;

            const inputGrupo = document.createElement('input');
            inputGrupo.type = 'hidden';
            inputGrupo.name = 'grupo_contable';
            inputGrupo.value = grupo_contable;

            const inputDescripcion = document.createElement('input');
            inputDescripcion.type = 'hidden';
            inputDescripcion.name = 'descripcion';
            inputDescripcion.value = descripcion;

            const inputArea = document.createElement('input');
            inputArea.type = 'hidden';
            inputArea.name = 'area';
            inputArea.value = area;
        
            form.appendChild(inputId);
            form.appendChild(inputValor);
            form.appendChild(inputCodigo);
            form.appendChild(inputGrupo);
            form.appendChild(inputDescripcion);
            form.appendChild(inputArea);
            document.body.appendChild(form);
        
            // Enviar el formulario para cargar el popup
            fetch('mod_configuracion/popup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&valor=${valor}&codigo=${codigo_contable}&grupo=${grupo_contable}&descripcion=${descripcion}&area=${area}`
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('popupContainer').innerHTML = html;
                document.getElementById('popupContainer').style.display = 'block';
            });
        }
    
        function cerrarPopup() {
            document.getElementById('popupContainer').style.display = 'none';
        }


        function AllowOnlyAmountAndDot(id, e, decimalbool) {    
            if(decimalbool == true) {   
                var t = id.value;
                var arr = t.split(".");
                var lastVal = arr.pop();
                var arr2 = lastVal.split('');
                if (arr2.length > '7') {
                    e.preventDefault();
                } 
            }
        }
    </script>
    
    <style>
        /* .btn-ver {
             background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        } */
        /* Estilos para el popup */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        .popup-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 50%;
            max-width: 500px;
            color:rgb(42, 98, 187);
        }

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
            overflow-y: auto;
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

<?php
    require("theme/footer_inicio.php");
} else
    header('Location: index.php');
?>
