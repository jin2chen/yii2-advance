<?php

namespace frontend\schemas;

use common\rules\UserRule;
use yii\base\Model;
use yii\web\Request;

class ContactSchema extends Model
{
    /**
     * @var string
     */
    public $email;


    public function rules()
    {
        return array_reduce([
            UserRule::email()
        ], 'array_merge', []);
    }

    /**
     * @param Request $request
     * @return static
     */
    public static function loadForUpdate(Request $request)
    {
        $schema = new static();
        $schema->attributes = $request->post();
        return $schema;
    }
}
