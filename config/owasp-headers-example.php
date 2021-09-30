<?php

// for a description of recommended headers
// see https://wiki.owasp.org/index.php/OWASP_Secure_Headers_Project#tab=Headers

return [
    # see https://https.cio.gov/hsts/
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
    'X-Content-Type-Option' => 'nosniff',
    'Content-Type' => 'text/html; charset=utf-8',
    'X-XSS-Protection' => '1; mode=block',
    'X-Frame-Options' => 'DENY',
    'X-Permitted-Cross-Domain-Policies' => 'none',
    'Referrer-Policy' => 'same-origin',
    # see https://csp-evaluator.withgoogle.com
    #'Content-Security-Policy' => 'default-src \'self\'; img-src \'self\'; script-src \'self\'; frame-ancestors \'none\'',
    'Content-Security-Policy' => 'frame-ancestors \'none\'',
    'Feature-Policy' => 'camera: \'none\'; payment: \'none\'; microphone: \'none\'',
];

