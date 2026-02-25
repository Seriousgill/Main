<?php

return [
    'format' => env('QR_FORMAT', 'png'),
    'size' => (int) env('QR_SIZE', 320),
    'expiration_minutes' => (int) env('QR_EXPIRATION_MINUTES', 60),
];
