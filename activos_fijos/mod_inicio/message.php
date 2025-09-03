<?php
    include_once '../mod_configuracion/clases/conexion.php';
    $db = Core::Conectar();

    // getting user message through ajax
    $getMesg = $_POST['text'];
    $resultado = "SELECT respuestas FROM chatbot WHERE consultas LIKE '%$getMesg%'";
    $resultado = $db->query($resultado);
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);
    // if user query matched to database query we'll show the reply otherwise it go to else statement
    if(count($resultado) > 0){
        foreach ($resultado as $fila) {
            $replay = $fila["respuestas"];
            echo $replay;
        }
    }else{
        echo "Lo siento, Las preguntas deben estar relacionadas con activos del Restaurante";
    }

?>