<?php

return [
    'seconds_between_logs' => env('TRACER_SECONDS_BETWEEN_LOGS', null),
    'log_ip_address' => env('TRACER_LOG_IP_ADDRESS', true),
    'log_user_agent' => env('TRACER_LOG_USER_AGENT', true),
    'log_referer' => env('TRACER_LOG_REFERER', true),
];
