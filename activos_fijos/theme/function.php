<?php

function generarCodigoSeguro($url) {
    $key = "4ct1v052024";
    $method = 'AES-256-CBC';

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

    // Encriptar los datos
    $encrypted = openssl_encrypt($url, $method, $key, 0, $iv);

    // Combinar el IV y los datos encriptados para almacenarlos juntos
    $encrypted_data = base64_encode($iv . $encrypted);

    return $encrypted_data;
    //return base64_encode($url); // Encriptar la URL
}

function decodificarCodigoSeguro($codigo) {
    $key = "4ct1v052024";
    $method = 'AES-256-CBC';

    $iv_decoded = base64_decode($codigo);
    $iv = substr($iv_decoded, 0, openssl_cipher_iv_length($method));
    $encrypted = substr($iv_decoded, openssl_cipher_iv_length($method));
    
    $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $iv);

    return $decrypted;
    //return base64_decode($codigo); // Decodificar la URL
}


?>