<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $date_create
 * @property int $date_update
 * @property int $active
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_id', 'active'], 'required'],
            [['date_create', 'date_update'], 'safe'],
            [['user_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'user_id' => 'User ID',
            'date_create' => 'Дата начала',
            'date_update' => 'дата окончания',
            'active' => 'Active',
        ];
    }
}
