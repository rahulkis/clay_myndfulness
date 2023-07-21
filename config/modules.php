<?php

return [
    "currency" => env("CURRENCY", "$"),
    "FREE_USER_ABBILITIES" => [
        "routine:create",
        "routine:update",
        "routine:delete"
    ],
    "PREMIUM_USER_ABBILITIES" => [
        "routine:create",
        "routine:update",
        "routine:delete",
        "self-assesment:create",
        "self-assesment:update",
        "self-assesment:delete",
    ],
    "full_date_format"  => env("FULL_DATE_FORMAT", "d/m/Y H:i a"),
    "short_date_format"  => env("SHORT_DATE_FORMAT", "d/m/Y"),
    "routine_types"  => [
        "Once a day",
        "Twice a day",
        "Thrice a day",
        "Four times a day",
        "Once every two days",
        "Once every three days",
        "Once every four days",
        "Once every five days",
        "Once every six days",
        "Once every week"
    ],
    "APP_STORE_KEY"  => env("APP_STORE_KEY", null),
    "NOTIFICATION_GRACE_DAY"  => env("NOTIFICATION_GRACE_DAY", 3),
];
