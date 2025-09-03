
<script language="javascript">
    $(document).ready(function () {
        $("#costo").change(function () {
            var a = $("#costo").val();
            var cr = (13 * a) / 100;
            var costo_sin_cr = a - cr;
            $("#cr").val(cr);
            $("#costo_sin_cr").val(costo_sin_cr);
        });

    });
    function visibilidadDiv(id) {
        div = document.getElementById(id);

        if (div.style.display == "block") {
            div.style.display = "none";
        } else {
            div.style.display = "block";
        }
    }

    function changeAction() {
        document.miformulario.action = "mod_cert/cBuscar.php"
        document.miformulario.submit()
    }
    function enforceNumberValidation(ele) {
        if ($(ele).data('decimal') != null) {
            // found valid rule for decimal
            var decimal = parseInt($(ele).data('decimal')) || 0;
            var val = $(ele).val();
            if (decimal > 0) {
                var splitVal = val.split('.');
                if (splitVal.length == 2 && splitVal[1].length > decimal) {
                    // user entered invalid input
                    $(ele).val(splitVal[0] + '.' + splitVal[1].substr(0, decimal));
                }
            } else if (decimal == 0) {
                // do not allow decimal place
                var splitVal = val.split('.');
                if (splitVal.length > 1) {
                    // user entered invalid input
                    $(ele).val(splitVal[0]); // always trim everything after '.'
                }
            }
        }
    }
</script>
<script language="javascript">
    // Función para cargar las subcategorías dependiendo de la categoría seleccionada
    function cargarSubcategorias(id) {
        var categoria_id = id;
        console.log('funciona');
        console.log(id);
        var subcategoriaSelect = document.getElementById('subcategoria');
        // Limpiar las opciones anteriores
        subcategoriaSelect.innerHTML = '<option value="">Seleccione el tipo de activo</option>';

        // Si se seleccionó una categoría
        if (categoria_id) {
            var url = "?categoria_id=" + categoria_id;

            fetch(url)
            .then(response => response.text())  // Cambiado a text() para ver la respuesta cruda
            .then(data => {
                console.log('Respuesta del servidor:', data); // Ver la respuesta cruda

                // Verificar si la respuesta es un JSON válido
                try {
                    var subcategorias = JSON.parse(data);
                    subcategorias.forEach(function(subcategoria) {
                        var option = document.createElement('option');
                        option.value = subcategoria.id;  // Asegúrate de que el campo id esté en el resultado
                        option.text = subcategoria.nombre;  // Asegúrate de que el campo nombre esté en el resultado
                        subcategoriaSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error al parsear JSON:', error);
                }
                })
                .catch(error => console.error('Error al cargar las subcategorías:', error));
        }
    }
</script>
<br><br><br><br>
<form name="match_form" method="post" action="mod_cert/guardar_ind.php">
<?php
    $db = Core::Conectar();
    $sqlActivos = "SELECT id_activo, nombre FROM activo WHERE estado=1";
    $resultActivos = $db->query($sqlActivos);
    //$categorias = $resultActivos->fetchAll(PDO::FETCH_ASSOC);
    //$categoria_id = isset($_POST['categoria_id']);
    
    if (isset($_GET['categoria_id'])) {
        $categoria_id = $_GET['categoria_id'];
        var_dump('sera que llega');
        // Consulta para obtener las subcategorías basadas en el ID de la categoría
        try {
            $sqlTactivos = "SELECT * FROM tipo_activos WHERE estado=1 AND id_activo = :categoria_id";
            
            // Preparar la consulta
            $stmt = $db->prepare($sqlTactivos);
            
            // Vincular el parámetro
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener los resultados
            $subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Asegurarse de que la respuesta es un array de subcategorías, si no, enviar un error
            if ($subcategorias) {
                echo json_encode($subcategorias);
            } else {
                echo json_encode(["error" => "No se encontraron subcategorías"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error en la consulta: " . $e->getMessage()]);
        }
        exit;
    }                        

?>        
    <center>
        <div class="estilo_div">
            <table>
                <tr>
                    <td class="titulo">Registro de compra de Activos</td>
                </tr>
                <tr>
                    <td class="subtitulo" style="text-align: center">Dfgel Restaurante</td>
                </tr>
            </table><br />
            <div id="nuevo" class="estilo_subdiv">
                <center>
                    <table>
                        <tr>
                            <center><br />
                                <input type="radio" name="activo" value="1" checked="checked">
                                activo
                                &nbsp;
                                <input type="radio" name="activo" value="0">
                                inactivo
                            </center>
                            <td style="width: 48%">
                                <div class="subdiv">
                                    &nbsp;&nbsp;Informacion General:<br><br>
                                    <table>
                                        <tr>
                                            <td>Codigo:</td>
                                            <td><input type="text" id="id_registro_activos" name="id_registro_activos"
                                                    value="<?php echo $_REQUEST["id"]; ?>"
                                                    style="height: 20px; width:50%; text-align: center;" class="inputs"
                                                    readonly>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Paginación:</td>
                                            <?php
                                            $id_regact = $_REQUEST["id"];
                                            $consultas = "SELECT n_adjuntos, id_urecibido, YEAR ( fecha_compra ) as anio FROM registro_activos where id_registro_activos=" . $id_regact;
                                            //echo $consultas;
                                            $resultados = $db->query($consultas);
                                            foreach ($resultados as $filas) {
                                                $n_adjuntos = $filas['n_adjuntos'];
                                                $id_personal = $filas['id_urecibido'];
                                                $anio_compra = $filas['anio'];

                                                $consultap = "SELECT concat(nombres,' ', apaterno,' ',amaterno) as nom_personal FROM personal where id_personal=" . $id_personal;
                                                $resultadop = $db->query($consultap);
                                                $resultadop = $resultadop->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($resultadop as $filap) {
                                                    $nom_personal = $filap['nom_personal'];
                                                    echo $nom_personal;
                                                    $cantidad = "SELECT count(id_activo) as correl, count(id_registro_activos) as total FROM registro_individual where id_registro_activos=$id_regact and estado=1 ;";
                                                    $resultadoc = $db->query($cantidad);
                                                    //$resultadoc = $resultadoc->fetchAll(PDO::FETCH_ASSOC);
                                    
                                                    foreach ($resultadoc as $filac) {

                                                        $cant = $filac['total'] + 1;
                                                        $entero = $filac['correl'] + 1;

                                                        if ($cant > $n_adjuntos) {
                                                            $cant = 1;
                                                            $entero = 1;
                                                            // echo "<script type=\"text/javascript\">" . "window.alert('Se registraron todos los activos de esta adquisición gracias.');" . "top.location = 'activos.php';" . "</script>";
                                                            echo "<script-- type=\"text/javascript\">" . "window.alert('Se registraron todos los activos de esta adquisición gracias.');" . "top.location = 'index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_k")) . "';" . "</script->";

                                                        }
                                                    }
                                                }
                                            } ?>
                                            <input type="hidden" id="n_adjuntos" name="n_adjuntos"
                                                value="<?php echo $n_adjuntos; ?>">

                                            <td><input type="text" id="paginacion" name="paginacion"
                                                    style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                    class="inputs" value="<?php echo $cant;
                                                    echo '-';
                                                    echo $n_adjuntos; ?>" readonly=""></td>
                                        </tr>

                                        <input type="hidden" id="correlativo" name="correlativo"
                                            style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                            class="inputs" value="<?php echo $entero; ?>" readonly="">


                                        <tr>
                                            <td><label for="categoria">Activo:</label></td>
                                            <td><select id="categoria" name="categoria" onchange="cargarSubcategorias(categoria.value)"
                                                    style="height: 20px; width: 82%; text-align: center;" class="inputs"
                                                    required>
                                                    <option value="">Seleccione un Activo</option>
                                                    <?php
                                                    foreach ($resultActivos as $categoria) { ?>
                                                            <option value="<?php echo $categoria["id_activo"]; ?>"><?php echo $categoria["nombre"]; ?></option>
                                                            <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="subcategoria">Tipo de activo</label></td>
                                            <td><select id="subcategoria" name="subcategoria"
                                                    style="height: 20px; width: 82%; text-align: center;"
                                                    required>
                                                    <option value="">Seleccione un tipo... </option> 
                                                    <?php
                                                    /*$consulta = "SELECT * FROM tipo_activos WHERE estado=1 and id_activo=1";
                                                    $resultado = $db->query($consulta);
                                                    foreach ($resultado as $fila) { ?>
                                                            <option value="<?php echo $fila["id_tipo_activos"]; ?>"><?php echo $fila["descripcion"]; ?></option>
                                                            <?php
                                                    }*/
                                                    foreach ($resultTactivos as $categoria) { ?>
                                                        <option value="<?php echo $categoria["id_tipo_activos"]; ?>"><?php echo $categoria["descripcion"]; ?></option>
                                                        <?php
                                                        
                                                }
                                                    ?>                                                                 
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Gestion:</td>
                                            <td><input type="text" id="gestion" name="gestion"
                                                    style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                    class="inputs" value="<?php echo $anio_compra; ?>" readonly /></td>
                                        </tr>
                                        <tr>
                                            <td>Recibido por:</td>
                                            <td><input type="hidden" id="recibido" name="recibido"
                                                    style="height: 20px; width:82%; text-align: center;" maxlength="4"
                                                    class="inputs" value="<?php echo $id_personal; ?>"><?php echo $nom_personal; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Descripcion Activo:</td>
                                            <td><textarea id="descripcion_act" rows="2" cols="30" name="descripcion_act"
                                                    class="inputs"></textarea></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td style="width: 10px"></td>
                            <td style="width: 49%">
                                <div class="subdiv">
                                    &nbsp;&nbsp;Informacion Detallada:<br><br>
                                    <table>
                                        <tr>
                                            <td>Marca:</td>
                                            <td><input type="text" id="marca" name="marca"
                                                    style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                    required /></td>
                                        </tr>
                                        <tr>
                                            <td>Modelo:</td>
                                            <td><input type="text" id="modelo" name="modelo"
                                                    style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                    required /></td>
                                        </tr>
                                        <tr>
                                            <td>Serie:</td>
                                            <td><input type="text" id="serie" name="serie"
                                                    style="height: 20px; width:82%; text-align: center;" class="inputs"
                                                    required /></td>
                                        </tr>
                                        <tr>
                                            <td>Costo Bs.</td>
                                            <td><input type="text" id="costo" name="costo"
                                                    style="height: 20px; width:82%; text-align: center;" maxlength="10"
                                                    class="inputs" onkeypress="return NumCheckD(event,this)" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Estado Activo:</td>
                                            <td>
                                                <select id="estado_activo" name="estado_activo"
                                                    style="height: 20px; width: 200px; text-align: center;"
                                                    class="inputs" required>
                                                    <option value="">-SELECCIONAR-</option>
                                                    <?php
                                                    $consulta = "SELECT id_estado_activo, est_tec FROM estado_activo where estado=1;";
                                                    $resultado = $db->query($consulta);
                                                    foreach ($resultado as $fila) { ?>
                                                            <option value="<?php echo $fila["id_estado_activo"]; ?>"><?php echo $fila["est_tec"]; ?></option>
                                                            <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td style="width: 1px"></td>
                        </tr>
                        <input type="hidden" id="correlativo" name="correlativo"
                            style="height: 20px; width:82%; text-align: center;" maxlength="4" class="inputs"
                            value="<?php echo $entero; ?>" readonly="">
                    </table>
                </center>
                <br /><br />
                <table>
                    <tr>
                        <td>Observaciones:</td>
                        <td><textarea id="observaciones" rows="2" cols="30" name="observaciones"
                                class="inputs"></textarea></td>
                    </tr>
                </table>
                <br>
                <div class="mi-div">
                    <p style="padding-top: 15px; ">Valor Residual</p>
                    <!-- <input type="text" id="residual" name="residual" style="height: 20px; width:90px; text-align: center;" class="inputs" onkeypress="return validarDecimales(this)" required /> -->
                    <input id="residual" name="residual" type="number" data-decimal="2"
                        oninput="enforceNumberValidation(this)" value=""
                        style="height: 25px; width:120px; text-align: center;" class="inputs" required minlength="4"
                        maxlength="8" />
                </div>
                <br />
                <center>
                    <input type="submit" value="GUARDAR" class="button">
                    <!--<input id="cancelar" type="button" value="Cancelar" class="button" onclick="javascript: visibilidadDiv('nuevo');">-->
                </center>
                <br>
            </div>
            <br />
            <div style='overflow-y:auto;width:95%;'>
                <table width="90%" height="55" style="border:1px;" align="center">
                    <tr bgcolor='#CCCFF1'>
                        <th class="colEnc">Correlativo</th>
                        <th class="colEnc">Descripción</th>
                        <th class="colEnc">Marca</th>
                        <th class="colEnc">Modelo</th>
                        <th class="colEnc">Serie</th>
                        <th class="colEnc">Costo</th>
                        <th class="colEnc">Observaciones</th>
                        <th class="colEnc" colspan="2">ACCIONES</th>
                    </tr>
                    <?php

                    $consulta = "SELECT ri.*, e.est_tec FROM registro_individual ri, estado_activo e WHERE ri.id_estado_activo=e.id_estado_activo and ri.estado=1 and ri.id_registro_activos=$id_regact;";
                    $resultado = $db->query($consulta);
                    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    if (count($resultado) > 0) {
                        foreach ($resultado as $fila) {
                            ?>
                                    <tr bgcolor="#F2F9FF">
                                        <td align="center" class="colDat">
                                            <?php echo $fila["correlativo_cantidad"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["descripcion_act"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["marca"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["modelo"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["serie"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["costo"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo $fila["observaciones"]; ?>
                                        </td>
                                        <td align="center" class="colDat">
                                            <?php echo "<a href='mod_cert/guardar.php?id_regind=" . $fila["id_registro_individual"] . "&id_regact=" . $fila["id_registro_activos"] . "&op=10'title='eliminar';>" ?>
                                            <img src="theme/images/borrar.png" width="30" height="30" />
                                            <?php "</a>"; ?>
                                        </td>
                                    </tr>
                                    <?php
                        }
                    }
                    $db = null;
                    ?>
                </table>
                <br>
            </div>
        </div>
    </center>
</form>  
                                      
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
        width: 95%;
    }

    .subdiv {
        border: solid 3px #ccc;
        /*border-radius:15px;*/
        width: 100%;
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

    .mi-div {
        width: 200px;
        height: 90px;
        border: 2px solid gray;
        /* Borde sólido de 2 píxeles de grosor y color negro */
    }
</style>