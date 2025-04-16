<?php

$cipher = 'AES-256-CBC'; // encrypt type
$key = hash('sha256', 'some data for key crypt'); //encrypt key
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));//initialization vector for random encrypt

// Сохраняем в JSON формате
$data = [
    'key' => base64_encode($key),
    'iv'  => base64_encode($iv),
];

file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/conf/crypto_keys.json', json_encode($data));