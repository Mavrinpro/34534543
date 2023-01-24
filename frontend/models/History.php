<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 */
class History extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_deals';
    }
}
