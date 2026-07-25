<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Notification Channel
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the notification channels should be used
    | by default when sending notifications. You may use any of the
    | channels defined in the "channels" array below.
    |
    */

    'default' => env('NOTIFICATION_CHANNEL', 'mail'),

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Here you can configure the available notification channels. Laravel
    | ships with "mail", "database", "broadcast", "nexmo", "slack" by default.
    | We add "webpush" here for web push notifications.
    |
    */

    'channels' => [

        'mail' => [
            'transport' => env('MAIL_MAILER', 'smtp'),
        ],

        'database' => [
            'table' => 'notifications',
        ],

        'broadcast' => [
            'driver' => 'broadcast',
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
        ],

        'nexmo' => [
            'driver' => 'nexmo',
            'key' => env('NEXMO_KEY'),
            'secret' => env('NEXMO_SECRET'),
            'sms_from' => env('NEXMO_SMS_FROM'),
        ],

        'webpush' => [
            'driver' => 'webpush',
            'model' => App\Models\User::class, // model yang menerima notifikasi
            'database_table' => 'webpush_subscriptions', // tabel untuk simpan subscription
            'vapid' => [
                'subject' => env('VAPID_SUBJECT', 'mailto:support@moneymate.id'),
                'public_key' => env('VAPID_PUBLIC_KEY'),
                'private_key' => env('VAPID_PRIVATE_KEY'),
            ],
        ],

    ],

];
