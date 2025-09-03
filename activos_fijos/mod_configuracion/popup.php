<?php

$id = $_POST['id'] ?? '';
$valor = $_POST['valor'] ?? '';
$codigo = $_POST['codigo'] ?? '';
$grupo = $_POST['grupo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$area = $_POST['area'] ?? '';

?>

<div class="popup-content" >
    <center>
        <span style="float: right; cursor: pointer;" onclick="cerrarPopup()">✕</span>
        <center><h3>REVALORIZACIÓN DEL ACTIVO</h3></center>
        <h4>Grupo Contable: </h4><?= $grupo; ?>
        <h4>Descripción: </h4><?= $descripcion; ?>
        <h4>Codigo Contable: </h4><?= $codigo; ?>
        <h4>Ubicación Actual: </h4><?= $area; ?>
        <h4>Valor Actual: </h4><?= $valor; ?>
    </center>
    
    <form id="formRegistro" method="post" action="mod_configuracion/guardar.php">
        <input type="hidden" name="valor_id" value="<?= $id ?>">
        <input type="hidden" name="valor_residual" value="<?= htmlspecialchars($valor) ?>">
        
        <div style="margin: 5px 0;">
            <label>Nuevo Valor:</label>
            <input name="valor_nuevo" type="text" class="form-control" onkeypress='return AllowOnlyAmountAndDot(this,event,true);' require/>
        </div>

        <center><button type="submit">Guardar Registro</button></center>
    </form>
    
    <script>
        // Manejar el envío del formulario con AJAX
        document.getElementById('formRegistro').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener el valor del input
            const valorNuevo = this.elements['valor_nuevo'].value.trim();
            
            // Validar que no esté vacío
            if (!valorNuevo) {
                alert('El campo "Nuevo Valor Residual" es requerido');
                return; // Detener el envío del formulario
            }

            fetch('mod_configuracion/guardar.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Registro guardado correctamente');
                    cerrarPopup();
                    // Opcional: recargar la tabla
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

    
        
    </script>
</div>