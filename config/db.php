<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'mysql:host=mysql;dbname=base',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
