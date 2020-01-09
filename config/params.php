<?php

return [
    'adminEmail' => 'admin@example.com',
    'parsers' => [
        \app\commands\Parser\Provider\Peerfly::class => 'Peerfly',
        \app\commands\Parser\Provider\Offerdollar::class => 'Offerdollar'
    ]
];
