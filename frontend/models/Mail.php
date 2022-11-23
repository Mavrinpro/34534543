<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 */
class Mail extends Model
{

    public function rules()
    {
        return [
            [['id'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }
}
