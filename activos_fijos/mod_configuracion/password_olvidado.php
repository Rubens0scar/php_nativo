<div class="popup-content" >
    <center>
        <span style="float: right; cursor: pointer;" onclick="cerrarPopupOlvido()">✕</span>
        <center><h3>CAMBIAR CONTRASEÑA OLVIDADA</h3></center>
    </center>
    
    <form id="formRegistro" method="post" action="mod_configuracion/guardar_password_olvidado.php">
        <label>Ingrese Usuario:</label><br><br>
        <input type="text" name="usuario" required><br><br>
        <label>Ingrese Correo Registrado:</label><br><br>
        <input type="text" name="correo" required><br><br>
        
        <center><button type="submit">Recuperar Contraseña</button></center>
    </form>
    
    <script>
        // Manejar el envío del formulario con AJAX
        document.getElementById('formRegistro').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener el valor del input
            const usuario = this.elements['usuario'].value.trim();
            const correo = this.elements['correo'].value.trim();
            
            // Validar que no esté vacío
            if (!usuario && !correo) {
                alert('Los dos campos son requeridos.');
                return; // Detener el envío del formulario
            }

            fetch('mod_configuracion/guardar_password_olvidado.php', {
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