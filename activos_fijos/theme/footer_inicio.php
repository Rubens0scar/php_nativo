<script language="javascript">
  function visibilidadDiv(id) {
    div = document.getElementById(id);
    if (div.style.display == "block") {
      div.style.display = "none";
    } else {
      div.style.display = "block";
    }
  }
</script>
<div class="container">
  <input type="checkbox" id="btn-mas">
  <div class="redes">
    <a href="<?php echo "index.php?ruta=" . urlencode(generarCodigoSeguro("pagina_q")) ?>" class="far fa-comments">Chat</a>
    
  </div>  
  <div class="btn-mas">
    <label for="btn-mas" class="fa fa-plus"></label>
  </div>
</div>

<table width="100%" id="footer" >
  <tr>
    <td bgcolor="#0b7ca9" class="bot-bg">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="bottom_menu"></td>
        </tr>
        <tr>
          <td class="bottom_addr">
            Todos los derechos reservados - Universidad Salesiana de Bolivia &copy;
            <?php echo date("Y"); ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>

</html>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  #btn-mas {
    display: none;
  }

  .container {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }

  .redes a,
  .btn-mas label {
    display: block;
    text-decoration: none;
    background: #2784d1;
    color: #05459d;
    width: 65px;
    height: 55px;
    line-height: 55px;
    text-align: center;
    border-radius: 50%;
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.4);
    transition: all 500ms ease;
  }

  .redes a:hover {
    background: #fff;
    color: #2784d1;
  }

  .redes a {
    margin-bottom: -15px;
    opacity: 0;
    visibility: hidden;
  }

  #btn-mas:checked~.redes a {
    margin-bottom: 10px;
    opacity: 1;
    visibility: visible;
  }

  .btn-mas label {
    cursor: pointer;
    background: #abcbf6;
    font-size: 23px;
  }

  #btn-mas:checked~.btn-mas label {
    transform: rotate(135deg);
    font-size: 25px;
  }

  ::selection {
    color: #fff;
    background: #007bff;
  }

  ::-webkit-scrollbar {
    width: 3px;
    border-radius: 25px;
  }

  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  ::-webkit-scrollbar-thumb {
    background: #ddd;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: #ccc;
  }

  .wrapper {
    width: 370px;
    background: #fff;
    border-radius: 5px;
    border: 1px solid lightgrey;
    border-top: 0px;
  }

  .wrapper .title {
    background: #007bff;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    line-height: 60px;
    text-align: center;
    border-bottom: 1px solid #006fe6;
    border-radius: 5px 5px 0 0;
  }

  .wrapper .form {
    padding: 20px 15px;
    min-height: 400px;
    max-height: 400px;
    overflow-y: auto;
  }

  .wrapper .form .inbox {
    width: 100%;
    display: flex;
    align-items: baseline;
  }

  .wrapper .form .user-inbox {
    justify-content: flex-end;
    margin: 13px 0;
  }

  .wrapper .form .inbox .icon {
    height: 40px;
    width: 40px;
    color: #fff;
    text-align: center;
    line-height: 40px;
    border-radius: 50%;
    font-size: 18px;
    background: #007bff;
  }

  .wrapper .form .inbox .msg-header {
    max-width: 53%;
    margin-left: 10px;
  }

  .form .inbox .msg-header p {
    color: #fff;
    background: #007bff;
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 14px;
    word-break: break-all;
  }

  .form .user-inbox .msg-header p {
    color: #333;
    background: #efefef;
  }

  .wrapper .typing-field {
    display: flex;
    height: 60px;
    width: 100%;
    align-items: center;
    justify-content: space-evenly;
    background: #efefef;
    border-top: 1px solid #d9d9d9;
    border-radius: 0 0 5px 5px;
  }

  .wrapper .typing-field .input-data {
    height: 40px;
    width: 335px;
    position: relative;
  }

  .wrapper .typing-field .input-data input {
    height: 100%;
    width: 100%;
    outline: none;
    border: 1px solid transparent;
    padding: 0 80px 0 15px;
    border-radius: 3px;
    font-size: 15px;
    background: #fff;
    transition: all 0.3s ease;
  }

  .typing-field .input-data input:focus {
    border-color: rgba(0, 123, 255, 0.8);
  }

  .input-data input::placeholder {
    color: #999999;
    transition: all 0.3s ease;
  }

  .input-data input:focus::placeholder {
    color: #bfbfbf;
  }

  .wrapper .typing-field .input-data button {
    position: absolute;
    right: 5px;
    top: 50%;
    height: 30px;
    width: 65px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    outline: none;
    opacity: 0;
    pointer-events: none;
    border-radius: 3px;
    background: #007bff;
    border: 1px solid #007bff;
    transform: translateY(-50%);
    transition: all 0.3s ease;
  }

  .wrapper .typing-field .input-data input:valid~button {
    opacity: 1;
    pointer-events: auto;
  }

  .typing-field .input-data button:hover {
    background: #006fef;
  }
</style>