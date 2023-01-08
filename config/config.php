<?php

/*
 * You can place your custom package configuration in here.
 */
return [
 
    /*
    |--------------------------------------------------------------------------
    | Malicious URLS
    |--------------------------------------------------------------------------
    |
    | A list of malicious URL parts.
    | - A malicious URL parts needs only be part of the URL. Example:
    |   'wp-admin' triggers the URL '/wp-admin', but also 'wp-admin/foo' and 'index.php?wp-admin=bar'
    | - URLs in the list are separated by a pipe. Example:
    |   If you wish to list both '.git' and 'install.php' the list should be '.git|install.php'
    |
    */
    'malicious_urls' => 'call_user_func_array|invokefunction|wp-admin|wp-login|.git|.env|install.php|css.php|/vendor',
];
