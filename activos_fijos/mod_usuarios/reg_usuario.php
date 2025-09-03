<?php
session_start();
if($_SESSION["usuario_nombre"])
{
require("theme/header_inicio.php");
?>

<style>
    .button{
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

    .button:hover{
        background: #365D9D;
        background: linear-gradient(left, #365D9D, #436CAD);
        background: -moz-linear-gradient(left, #365D9D, #436CAD);
        background: -webkit-linear-gradient(left, #365D9D, #436CAD);
        background: -o-linear-gradient(left, #365D9D, #436CAD);
        color: #FFFFFF;
        border-color: #FBFFAD;
    }
    .estilo_div{
        border:solid 10px #ccc;
        border-radius:15px;
        box-shadow: 8px 8px 10px 0px #818181;
        width:850px;
    }
    .titulo{
        font-family: algerian;
        color: #001459;
        font-size: 180%;
    }
    .subtitulo{
        font-family: algerian;
        /*color: lightblue;*/
        color: #001459;
        font-size: 120%;
    }

    .estilo_subdiv{
        border:solid 3px #ccc;
        border-radius:15px;
        width:450px;
    }
    .inputs{
        float: none;
        padding: 0px;
        font-size: small;
        font-family: verdana;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border: 1px solid rgb(182, 182, 182);
        color: rgb(51,51,51);
    }

    .colEnc{
        display: table-cell;
        padding: 5px;
        font-family: monospace; 
        font-size: 14px;
        color: #063b82;
        background: #CED4D9;
    }
    .colDat{
        display: table-cell;
        padding: 5px;
        font-family: monospace; 
        font-size: 14px;
        color: #063b82;
    }
</style><br><br><br><br>
<center>

    <table><tr><td class="titulo">PERSONAL</td></tr>            
        <tr><td class="subtitulo" style="text-align: center">Reporte General</td></tr>
    </table><br>

    <div id="nuevo" style="display: none;" class="estilo_subdiv">        

        <br>
    </div>
    <br>

    <table width="90%" height="55" style="border:1px;" align="center">
        <tr bgcolor='#CCCFF1'>
            <th class="colEnc">N°</th>
            <th class="colEnc">Código de Ubicación</th>
            <th class="colEnc">C.I.</th>			
            <th class="colEnc">Paterno</th>
            <th class="colEnc">Materno</th>
            <th class="colEnc">Nombres</th>
            <th class="colEnc">Cargo</th>
            <th class="colEnc">Estado</th>
            <th class="colEnc">Código de Ubicación</th>
            <th class="colEnc">Acciones</th>
        </tr> 
        <?php
        include_once '../mod_configuracion/clases/conexion.php';
        $db = Core::Conectar();

        $consulta = "SELECT d.id_dpto, d.nom_dpto, a.cd_cnt_area, a.nom_area, p.id_personal, p.cd_ubicacion, p.ci_personal, p.paterno_personal, p.materno_personal, p.nom_personal, p.cargo_personal, p.dir_personal, p.fn_personal, case p.estado when true then 'ACTIVO' else 'NO ACTIVO' end estado, p.cd_ubi3 FROM dbo.personal p, dbo.departamento d, dbo.area a WHERE d.id_dpto=a.id_dpto and a.id_area=p.id_area order by p.paterno_personal";
        $resultado = $db->query($consulta);
        $i = 0;
        if ($resultado->rowCount() > 0) {

            foreach ($resultado as $fila) {
                $id = $fila[0];
                $i = $i + 1;
                ?>
                <tr bgcolor="#F2F9FF">   
                    <td align="center" class="colDat"><?php echo $i; ?></td>
                    <td align="center" class="colDat"><?php echo $fila["cd_ubicacion"]; ?></td>
                    <td align="center" class="colDat"><?php echo $fila["ci_personal"]; ?></td>
                    <td align="center" class="colDat"><?php echo $fila["paterno_personal"]; ?></td>
                    <td align="center" class="colDat"><?php echo $fila["materno_personal"]; ?></td>
                    <td align="center" class="colDat"><?php echo $fila["nom_personal"]; ?></td>
                    <td align="center" class="colDat"><?php echo $fila["cargo_personal"]; ?></td>  
                    <td align="center" class="colDat"><?php echo $fila["estado"]; ?></td>     
                    <td align="center" class="colDat"><?php echo $fila["id_dpto"];
        echo '.';
        echo $fila["cd_cnt_area"];
        echo '.';
        echo $fila["cd_ubicacion"]; ?></td>     
                    <td align="center" class="colDat"><?php echo "<a href='reg_usu.php?id_personal=" . $fila["id_personal"] . "'title='registrar'>REGISTRO USUARIO</a>"; ?></td>           
                </tr>
                <?php
            }
        }
        $db = null;
        ?>       
    </table>

</center>

<?php
require("../theme/footer_inicio.php");
}
else
header('Location: ../index.php');
?>
