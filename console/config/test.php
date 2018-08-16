<?php
/** @noinspection SpellCheckingInspection */

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/main.php',
    [
        'id' => 'app-console-tests',
    ]
);

return $config;
