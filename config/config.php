<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Malicious URL detection enabled
    |--------------------------------------------------------------------------
    |
    | Determines whether middleware checks for malicious URLs.
    | Can be set by URL_DETECTION_ENABLED in .env file.
    |
    */
    'url_detection_enabled' => env('URL_DETECTION_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Malicious User Agents detection enabled
    |--------------------------------------------------------------------------
    |
    | Determines whether middleware checks for malicious User Agents.
    | Can be set by USER_AGENT_DETECTION_ENABLED in .env file.
    |
    */
    'user_agent_detection_enabled' => env('USER_AGENT_DETECTION_ENABLED', true),

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

    /*
    |--------------------------------------------------------------------------
    | Block IPs Store
    |--------------------------------------------------------------------------
    |
    | The implementation you use to store blocked IPs with. Implementations you can choose from:
    | - \Accentinteractive\LaravelBlocker\Services\BlockedIpStoreDatabase
    | - \Accentinteractive\LaravelBlocker\Services\BlockedIpStoreCache
    |
    | Can be set by AI_BLOCKER_STORAGE_IMPLEMENTATION_CLASS in.env file
    |
    */
    'storage_implementation_class' => env('AI_BLOCKER_STORAGE_IMPLEMENTATION_CLASS', '\Accentinteractive\LaravelBlocker\Services\BlockedIpStoreCache'),
];
