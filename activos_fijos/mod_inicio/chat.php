<?php
session_start();
if($_SESSION["usuario_nombre"])
{
    require("theme/header_inicio.php");
    ?>
    <br><br><br><br>
    <?php
    include_once 'mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();

    if(!isset($_REQUEST["id"])){
    ?>
    <div class="container1">
        <center><div class="wrapper">
            <div class="header1">
                    <h4> <img src='theme/images/perfil.jpg' class='imgRedonda'/> SaborGauchoBot </h4>
            </div>
            <div class="form">
                <div class="bot-inbox inbox">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="msg-header">
                        <p>Hola, ¿cómo puedo ayudarte?</p>
                    </div>
                </div>
            </div>
            <div class="typing-field">
                <div class="input-data">
                    <input id="data" type="text" placeholder="Preguntale algo.." required>
                    <button id="send-btn">Enviar</button>
                </div>
            </div>
        </div></center>
    </div>
    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                
                // start ajax code
                $.ajax({
                    url: 'mod_inicio/message.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>

    <?php
} else {
}
$db = null;
require("theme/footer_inicio.php");
}
else
header('Location: index.php');    
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
    /* aca empieza el bot */
    body {
        background-image: url(theme/images/fondo_chat.png);
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        font-size: 16px;
        line-height: 16px;
    }
    .body {
        background: rgb(31, 8, 86);
        height: 100%;
        width: 100%;
        overflow-y: auto;
    }
    .header1 {
        background: #000000;
        padding: 10px;
        color: aliceblue;
        font-size: 20px;
    }
    .imgRedonda {
        width: 40px;
        height: 40px;
        border-radius: 150px;
    }
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');  

    .wrapper{
        width: 600px;
        height: 570px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid lightgrey;
        border-top: 0px;
    }
    .wrapper .title{
        background: #007bff;
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        line-height: 60px;
        text-align: center;
        border-bottom: 1px solid #006fe6;
        border-radius: 5px 5px 0 0;
    }
    .wrapper .form{
        padding: 20px 15px;
        min-height: 400px;
        max-height: 400px;
        overflow-y: auto;
    }
    .wrapper .form .inbox{
        width: 100%;
        display: flex;
        align-items: baseline;
    }
    .wrapper .form .user-inbox{
        justify-content: flex-end;
        margin: 13px 0;
    }
    .wrapper .form .inbox .icon{
        height: 40px;
        width: 40px;
        color: #fff;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        font-size: 18px;
        background: #0b7ca9;
    }
    .wrapper .form .inbox .msg-header{
        max-width: 53%;
        margin-left: 10px;
    }
    .form .inbox .msg-header p{
        color: #fff;
        background: #0b7ca9;
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 14px;
        word-break: break-all;
    }
    .form .user-inbox .msg-header p{
        color: #333;
        background: #efefef;
    }
    .wrapper .typing-field{
        display: flex;
        height: 60px;
        width: 100%;
        align-items: center;
        justify-content: space-evenly;
        background: #efefef;
        border-top: 1px solid #d9d9d9;
        border-radius: 0 0 5px 5px;
    }
    .wrapper .typing-field .input-data{
        height: 40px;
        width: 335px;
        position: relative;
    }
    .wrapper .typing-field .input-data input{
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
    .typing-field .input-data input:focus{
        border-color: rgba(0,123,255,0.8);
    }
    .input-data input::placeholder{
        color: #999999;
        transition: all 0.3s ease;
    }
    .input-data input:focus::placeholder{
        color: #bfbfbf;
    }
    .wrapper .typing-field .input-data button{
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
    .wrapper .typing-field .input-data input:valid ~ button{
        opacity: 1;
        pointer-events: auto;
    }
    .typing-field .input-data button:hover{
        background: #006fef;
    }
</style>