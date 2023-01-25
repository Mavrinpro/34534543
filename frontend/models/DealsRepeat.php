<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deals".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $tag
 * @property string|null $date_create
 * @property int|null $id_operator
 * @property string|null $date_update
 * @property string|null $call_recording
 */
class DealsRepeat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deals_repeat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_update', 'deal_id'], 'safe'],
            [['status', 'id_operator'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['tag'], 'string', 'max' => 200],
            [['call_recording'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'tag' => 'Тег',
            'date_create' => 'Дата',
            'status' => 'Статус',
            'id_operator' => 'Сотрудник',
            'id_filial' => 'Филиал',
            'date_update' => 'Date Update',
            'call_recording' => 'Call Recording',
        ];
    }

    public function searchRepeatDeals($id)
    {
        return DealsRepeat::find()->where(['deal_id' => $id])->all();
    }

}
