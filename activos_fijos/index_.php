
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Activos dbo</title>
	
	<!--*********** cambio de hojas de estilo ***************-->
    <link rel="stylesheet" href="theme/css/style.css" type="text/css">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
</head>
<html>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1">
		<div style="position:absolute; width:345px; top:43px; background:url(theme/images/cn-bg.gif); left: 1px;">
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                     <td width="1"><img src="theme/images/logo.jpg" alt="" width="61" height="61" class="logo"/></td>
                      <td class="company_name"><center>"SISTEMA DE INFORMACIÓN PARA EL CONTROL Y SEGUIMIENTO DE ACTIVOS FIJOS - SIdboF"</center></td>
                 </tr>
                 </table>
        </div>
       <div id="slogan">
       <div style="position:absolute; top:10px; left:550px; margin-left:-400px; width:681px; height:25px; font-size:30px; color:#000; font-family:'Courier New', Courier, monospace;">
  <marquee direction="left" width="100%" scrollamount="7">
    <span class="Estilo9">ACTIVOS FIJOS - SABOR GAUCHO</span>
  </marquee></div>
</div>
 <td><img src="theme/images/con7.jpg" alt="" width="666" height="196"></td>
      <td class="hbg">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <div id="centercontent">
  <form action="mod_configuracion/login.php" method="post">
    <h1 class="titulo">Entrada al Sistema</h1>
    <table width="200"  align="center" border="0">
      <tr>
        <td align="center"><img src="theme/images/sabor/gaucho.png" alt="Hidrofalcon" width="600" height="350"  align="right"/></td>
      </tr>
    </table>
    <div align="center">
      <table width="259" align="center">
        <tr>
          <td width="70" bordercolor="#333333"><span class="Estilo10">Usuario:</span></td>
          <td width="177" bordercolor="#333333"><input type="text" name="usuario" size="15" /></td>
        </tr>
        <tr>
          <td bordercolor="#F0F0F0"><span class="Estilo12">Contraseña</span>:</td>
          <td><input type="password" name="contrasenia" size="15" /></td>
        </tr>
        <tr>
          <td bordercolor="#F0F0F0"></td>
          <td><input name="submit" type="submit" value="Entrar" />
          <input name="Restablecer" type="reset" value="Limpiar" /></td>
        </tr>
      </table>
      <table style="font-size: 11px;">
        <tr>          
          <td>
            <a href="#" onclick="mostrarPopup('1')">
              Cambia tu Contraseña
            </a>
          </td>
          <td>&nbsp;</td>
          <td colspan="2" align="center">
            <a href="#" onclick="mostrarPopupOlvido(1)">
              ¿Olvidaste tu contraseña?
            </a>
          </td>
        </tr>
      </table>
    </div>
  </form>
  </div>
<table width="100%">
<tr>
    <td bgcolor="#0b7ca9" class="bot-bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">      
      <tr>
        <td class="bottom_addr">
          Todos los derechos reservados - Universidad Salesiana de Bolivia&copy; <?php echo date("Y");?>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
    <!-- Popup (se carga dinámicamente) -->
    <div id="popupContainer" class="popup">
        <!-- Aquí se cargará el contenido del popup -->
    </div>
   
    <!-- Popup (se carga dinámicamente) -->
    <div id="popupContainerOlvido" class="popup">
            <!-- Aquí se cargará el contenido del popup -->
    </div>

  <script>
    // Para cambiar contraseña
    function mostrarPopup(id) {
        // Crear un formulario oculto para enviar los datos
        const form = document.createElement('form');
        form.method = 'post';
        form.action = 'mod_configuracion/cambiar_password.php';
        form.style.display = 'none';
       
        document.body.appendChild(form);
       
        // Enviar el formulario para cargar el popup
        fetch('mod_configuracion/cambiar_password.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: ``
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

    // Para Olvido Contraseña
    function mostrarPopupOlvido(id) {
        // Crear un formulario oculto para enviar los datos
        const form = document.createElement('form');
        form.method = 'post';
        form.action = 'mod_configuracion/password_olvidado.php';
        form.style.display = 'none';
       
        document.body.appendChild(form);
       
        // Enviar el formulario para cargar el popup
        fetch('mod_configuracion/password_olvidado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: ``
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('popupContainerOlvido').innerHTML = html;
            document.getElementById('popupContainerOlvido').style.display = 'block';
        });
    }
   
    function cerrarPopupOlvido() {
        document.getElementById('popupContainerOlvido').style.display = 'none';
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
            width: 17%;
            max-width: 500px;
            color:rgb(42, 98, 187);
        }
    </style>
<body>
</html>
