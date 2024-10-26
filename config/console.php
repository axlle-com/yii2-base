<?php

use app\protected\Url\repositories\UrlRepository;
use app\protected\Url\repositories\UrlStatsRepository;
use app\protected\Url\services\UrlService;
use app\protected\Url\services\UrlStatsService;
use yii\caching\FileCache;
use yii\gii\Module;
use yii\log\FileTarget;
use yii\redis\Connection;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
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
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_PROD) {
    $config['components']['db'] = require __DIR__ . '/db-local.php';
    $config['params'] = require __DIR__ . '/params-local.php';
}

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => Module::class,
    ];
    // configuration adjustments for 'dev' environment
    // requires version `2.1.21` of yii2-debug module
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
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
