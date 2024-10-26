<?php

use app\models\User;
use app\protected\Url\events\UrlEventListener;
use app\protected\Url\repositories\UrlRepository;
use app\protected\Url\repositories\UrlStatsRepository;
use app\protected\Url\services\UrlService;
use app\protected\Url\services\UrlStatsService;
use yii\caching\FileCache;
use yii\debug\Module;
use yii\log\FileTarget;
use yii\redis\Connection;

$params = include __DIR__ . '/params.php';
$db = include __DIR__ . '/db.php';

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
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation. Real in ./params-local.php
            'cookieValidationKey' => 'ifTaAiWRrUZxcQBerDlkE0UeEd2EQa9o',
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'redis' => [
            'class' => Connection::class,
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'channel' => 'queue',
            'as log' => \yii\queue\LogBehavior::class,
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'shorten' => 'url/index',
                'create' => 'url/create',
                'stats' => 'stats/index',
                '<token:\w{5}>' => 'redirect/index',
            ],
        ],
    ],
    'params' => $params,
    'on urlRedirected' => [UrlEventListener::class, 'onRedirected'],
];

if (YII_ENV_PROD) {
    $config['components']['db'] = require __DIR__ . '/db-local.php';
    $config['params'] = require __DIR__ . '/params-local.php';
}

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '172.24.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '172.24.0.1'],
    ];
}

Yii::$container->setDefinitions([
    \app\protected\Url\contracts\UrlRepository::class => UrlRepository::class,
    \app\protected\Url\contracts\UrlStatsRepository::class => UrlStatsRepository::class,
    \app\protected\Url\contracts\UrlService::class => UrlService::class,
    \app\protected\Url\contracts\UrlStatsService::class => UrlStatsService::class,
]);

return $config;
