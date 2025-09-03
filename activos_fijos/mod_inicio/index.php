<?php
session_start();
if ($_SESSION["usuario_nombre"]) {
  require_once("theme/header_inicio.php");

  ?>
  <!-- Content Center -->
  <div id="centercontent" align="center">
    <br />
    <h1 class="titulo">Principal</h1>
    <table width="200" align="center" border="0" style="margin-top:50px; margin-bottom:50px;">
      <tr>
        <td align="center">
          <img alt="slide show" src="theme/images/sabor/princi.jpg" width="500" height="450">
        </td>
      </tr>

    </table>
  </div>

  <?php
  require("theme/footer_inicio.php");
} else
  header('Location: index.php');
?>