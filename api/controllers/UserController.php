<?php

namespace api\controllers;

use yii\rest\Controller;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }

    public function actionIndex()
    {
        return [
            'list'
        ];
    }

    public function actionCreate()
    {
        return [
            'create'
        ];
    }

    public function actionView($id)
    {
        return $id;
    }
}
