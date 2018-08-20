<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'user/rented-items/<page:\d+>',
                    'route' => 'item/rented-items',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'user/create-payment-account/<alias>',
                    'route' => 'user/create-payment-account',
                ],
                [
                    'pattern' => 'user/my-rented-items/<page:\d+>',
                    'route' => 'item/my-rented-items',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'user/my-items/<page:\d+>',
                    'route' => '/item/my-rentals',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'browse/<category>/<location_from>/<location_to>/<from>/<to>/<from_h>/<from_i>/<to_h>/<to_i>/<page:\d+>',
                    'route' => 'catalog/index',
                    'defaults' => ['page' => 1],
                ],

                [
                    'pattern' => 'browse/<category>/<location_from>/<location_to>/<from>/<to>/<from_h>/<from_i>/<to_h>/<to_i>/<price>/<user>/<class>/<marka>/<model><page:\d+>',
                    'route' => 'catalog/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'catelog/mail',
                    'route' => 'catalog/mail',
                ],

                [
                    'pattern' => 'messages/<alias>',
                    'route' => 'chat/messages',
                    'defaults' => ['alias' => null],
                ],

                [
                    'pattern' => 'payment/status/<status>/<orderid>',
                    'route' => 'payment/status',
                ],

                [
                    'pattern' => 'payment/buy-now/<alias>',
                    'route' => 'payment/buy-now',
                ],

                [
                    'pattern' => 'browse/<category>/<page:\d+>',
                    'route' => 'catalog/index',
                    'defaults' => ['page' => 1],
                ],

                [
                    'pattern' => 'item/delete',
                    'route' => 'item/delete',
                ],

                [
                    'pattern' => 'item/image-remove',
                    'route' => 'item/image-remove',
                ],
                [
                    'pattern' => 'item/ajax-filter',
                    'route' => 'item/ajax-filter',
                ],
                [
                    'pattern' => 'item/ajax-model',
                    'route' => 'item/ajax-model',
                ],

                [
                    'pattern' => 'item/<alias>',
                    'route' => 'catalog/item-page',
                ],

                [
                    'pattern' => 'user/<alias>/rental-items<page:\d+>',
                    'route' => 'catalog/user-item',
                    'defaults' => ['page' => 1],
                ],

                [
                    'pattern' => 'user/my-items/add-item',
                    'route' => 'item/add',
                ],
                [
                    'pattern' => 'user/my-items/edit-item',
                    'route' => 'item/update',
                ],


                [
                    'pattern' => 'user/<alias>/mutual-connections<page:\d+>',
                    'route' => 'connection/index',
                    'defaults' => ['page' => 1],
                ],
                [
                    'pattern' => 'user/my-connections<page:\d+>',
                    'route' => 'item/my-connections',
                    'defaults' => ['page' => 1],
                ],
                '<action>' => 'site/<action>',
                [
                    'pattern' => 'company/contacts',
                    'route' => 'site/contacts',
                ],
                [
                    'pattern' => 'company/<alias>',
                    'route' => 'site/page',
                    'defaults' => ['page' => 1],
                ],
            ],
        ],
    ],
    'params' => $params,
];
