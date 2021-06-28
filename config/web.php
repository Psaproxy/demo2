<?php

use App\Infrastructure\Event\EventsPublisher;
use App\Infrastructure\MySql\DBTransaction;
use App\Infrastructure\MySql\Repository\ShortUrl\DataProvider as DataProviderShortUrl;
use App\Infrastructure\MySql\Repository\ShortUrl\RepoConverter as RepoConverterShortUrl;
use App\Infrastructure\MySql\Repository\ShortUrl\Repository as RepositoryShortUrl;
use Core\Common\Action\IDBTransaction;
use Core\Common\Event\IEventsPublisher;
use Core\ShortUrl\IDataProvider as IDataProviderShortUrl;
use Core\ShortUrl\IRepository as IRepositoryShortUrl;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_1DZYrDROxmWHDNRRXLmPgsoo5DsDB_L',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'POST api/v1/link/create' => 'api.v1/link/create',
                'api/v1/link/<id:\w+>' => 'api.v1/link/get',
                'r/<id:\w+>' => 'redirect/index',
            ],
        ],

    ],
    'params' => $params,
    'container' => [
        'singletons' => [
            // Event
            IEventsPublisher::class => ['class' => EventsPublisher::class],

            // Infrastructure
            IDBTransaction::class => ['class' => DBTransaction::class],

            // ShortUrl
            RepoConverterShortUrl::class => ['class' => RepoConverterShortUrl::class],
            IRepositoryShortUrl::class => ['class' => RepositoryShortUrl::class],
            IDataProviderShortUrl::class => ['class' => DataProviderShortUrl::class],
        ],
    ],
    'modules' => [
        'api.v1' => [
            'class' => 'app\modules\api\v1\Module',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
