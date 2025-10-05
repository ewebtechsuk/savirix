<?php

return [
    'channels' => [
        'email' => App\Services\Messaging\Channels\EmailChannel::class,
        'sms' => App\Services\Messaging\Channels\SmsChannel::class,
    ],
];
