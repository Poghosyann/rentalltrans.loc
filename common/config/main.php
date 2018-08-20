<?php
error_reporting(0);
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 3600 * 24 * 365,
            'useCookies' => true,
            'name' => 'cart',
            'cookieParams' => [
                'httpOnly' => true,
                'lifetime' => 3600 * 24 * 365,
            ],
        ],
        'jwplayer' => [
            'class' => 'wadeshuler\jwplayer\JWConfig',
            'key' => 'IzEqVjRNGbvR6o5C9Fa0V+d5RKsU6WMks6OoUQ==',  // <-- Your Key Here!!
            'htmlOptions' => [
                'class' => 'myVideoPlayer',
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=rentaltrans',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.jino.ru',
                'username' => 'admin@rentalltrans.com',
                'password' => 'artur999',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],

    ],
];