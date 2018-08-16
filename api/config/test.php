<?php

return \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../config/main.php'),
    [
        'id' => 'app-api-tests',
    ]
);
