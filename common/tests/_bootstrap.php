<?php

use Dotenv\Dotenv;

require __DIR__ . '/../../vendor/autoload.php';
(new Dotenv(__DIR__ . '/../..'))->overload();

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../config/bootstrap.php';
