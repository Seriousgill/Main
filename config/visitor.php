<?php

return [
    'default_status' => env('VISITOR_DEFAULT_STATUS', 'pending'),
    'max_daily_visits' => (int) env('VISITOR_MAX_DAILY_VISITS', 500),
    'require_photo' => (bool) env('VISITOR_REQUIRE_PHOTO', true),
];
