<?php

return [
    'enabled' => env('ALARM_ENABLED', true),
    'sound_file' => env('ALARM_SOUND_FILE', 'sounds/alarm.mp3'),
    'escalation_seconds' => env('ALARM_ESCALATION_SECONDS', 120),
];
