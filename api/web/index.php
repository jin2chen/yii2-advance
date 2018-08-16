<?php
/** @noinspection PhpUnhandledExceptionInspection */

use Dotenv\Dotenv;

require __DIR__ . '/../../vendor/autoload.php';
(new Dotenv(__DIR__ . '/../..'))->overload();

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', false));
defined('YII_ENV') or define('YII_ENV', env('APP_ENV', 'prod'));

require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

(new yii\web\Application(require __DIR__ . '/../config/main.php'))->run();
