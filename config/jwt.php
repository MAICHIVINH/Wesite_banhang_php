<?php
return [
    'secret_key' => 'RANDOM_SECRET_KEY',
    'issuer' => 'your-app.com',  // tên ứng dụng
    'audience' => 'your-app.com',
    'issued_at' => time(),
    'not_before' => time(),
    'expire' => time() + 3600 // token hiệu lực 1 giờ
];
