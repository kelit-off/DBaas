<?php

return [
    // Base domain used to expose tenant databases (e.g. db.example.com).
    // Point a wildcard DNS: *.db.example.com -> your gateway/load balancer.
    'domain' => env('DBAAS_DOMAIN', 'db.local'),

    // Optional default host override (not used if domain is set).
    'host' => env('DBAAS_HOST', null),
];

