<?php

namespace console\controllers;

use stdClass;
use Yii;
use yii\console\Controller;
use yii\swiftmailer\Message;

class MailController extends Controller
{
    public function actionSend()
    {
        $user = new stdClass();
        $user->username = 'Jin Chen';
        $user->password_reset_token = 'KILZFzqUEbCjo6IrgID4bUdyp864tirkW3c2LK5Ibjcc';
        Yii::$app->mailer->compose('passwordResetToken-html.php', ['user' => $user])
            ->setFrom('admin@jinchen.me')
            ->setSubject('Mail Test')
            ->setTo('mole.chen@foxmail.com')
            ->send();

//        $message = new Message();
//        $message->setFrom('admin@jinchen.me')
//            ->setSubject('Mail Test')
//            ->setTo('mole.chen@foxmail.com')
//            ->setTextBody('Test')
//            ->send();
    }
}
