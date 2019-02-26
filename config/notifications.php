<?php

return [
    'threshold' => env('NOTIFICATION_THRESHOLD') ?? 90,
    'cc'        => env('NOTIFICATION_CC') ?? null
];
