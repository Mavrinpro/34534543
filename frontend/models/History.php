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

    public function rules()
    {
        return [
            [['deal_id', 'user_id_interra', 'date', 'date_service', 'time_service', 'doc_service', 'talon_id', 'birtday', 'age', 'gender', 'services', 'status', 'responsible', 'company_id'], 'safe'],
        ];
    }
}
