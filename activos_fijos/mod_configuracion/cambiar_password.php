<div class="popup-content" >
    <center>
        <span style="float: right; cursor: pointer;" onclick="cerrarPopup()">✕</span>
        <center><h3>CAMBIAR CONTRASEÑA</h3></center>
    </center>
    
    <form id="formRegistro" method="post" action="mod_configuracion/guardar_nueva_password.php">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>
        
        <label>Anterior contraseña:</label><br>
        <input type="password" name="anterior_password" required><br><br>

        <label>Nueva contraseña:</label><br>
        <input type="password" name="nueva_password" required><br><br>
        
        <center><button type="submit">Guardar Contraseña</button></center>
    </form>
    
    <script>
        // Manejar el envío del formulario con AJAX
        document.getElementById('formRegistro').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener el valor del input
            const usuario = this.elements['usuario'].value.trim();
            const anteriorPassword = this.elements['anteriorPassword'].value.trim();
            const password = this.elements['password'].value.trim();
            
            // Validar que no esté vacío
            if (!usuario && !password && !anteriorPassword) {
                alert('Los tres campos son requeridos.');
                return; // Detener el envío del formulario
            }

            fetch('mod_configuracion/guardar_nueva_password.php', {
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