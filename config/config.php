<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Expiration time
    |--------------------------------------------------------------------------
    |
    | Number of seconds before a blocked ip is deleted from the ai_blocked_ips table.
    | Can be set by AI_BLOCKER_EXPIRATION_TIME in .env file.
    |
    */
    'expiration_time' => env('AI_BLOCKER_EXPIRATION_TIME', 3600),

    /*
    |--------------------------------------------------------------------------
    | Malicious URLS
    |--------------------------------------------------------------------------
    |
    | A list of malicious URL parts.
    | - A malicious URL parts needs only be part of the URL. Example:
    |   'wp-admin' triggers the URL '/wp-admin', but also 'wp-admin/foo' and 'index.php?wp-admin=bar'
    | - the URL strings are case insensitive.
    | - URLs in the list are separated by a pipe. Example:
    |   If you wish to list both '.git' and 'install.php' the list should be '.git|install.php'
    |
    | Can be set by AI_BLOCKER_MALICIOUS_URLS in.env file
    |
    */
    'malicious_urls' => env('AI_BLOCKER_MALICIOUS_URLS', 'call_user_func_array|invokefunction|wp-admin|wp-login|.git|.env|install.php|/vendor'),

    /*
    |--------------------------------------------------------------------------
    | Malicious User Agent
    |--------------------------------------------------------------------------
    |
    | A list of malicious User Agents.
    | - A malicious User Agents string needs only be part of the User Agents. Example:
    |   'dotbot' triggers the User Agent 'Mozilla/5.0 (compatible; DotBot/1.1; http://www.dotnetdotcom.org/, crawler@dotnetdotcom.org)'
    | - the User Agent strings are case insensitive.
    | - User Agentss in the list are separated by a pipe. Example:
    |   If you wish to list both 'dotbot' and 'seznam' the list should be 'dotbot|seznam'
    |
    | Can be set by AI_BLOCKER_MALICIOUS_USER_AGENTS in.env file
    |
    */
    'malicious_user_agents' => env('AI_BLOCKER_MALICIOUS_USER_AGENTS', 'dotbot|linguee'),
];
