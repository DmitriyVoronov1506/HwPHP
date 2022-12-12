<?php
$smtp = [
    'host'    => 'smtp.gmail.com',
    'port'    => 587,
    'secure'  => 'tls',
    'user'    => 'dmitriy.azure1506@gmail.com',
    'pass'    => 'specman3241',
    'options' => [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ]
    ],
] ;