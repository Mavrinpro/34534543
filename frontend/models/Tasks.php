<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property string|null $date_create
 * @property string|null $date_update
 * @property int|null $status
 * @property int|null $deals_id
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_id', 'deals_id'], 'required'],
            //[['user_id', 'status'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['name'], 'string', 'max' => 100],
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
            'user_id' => 'Кому',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'status' => 'Status',
            'deals_id' => 'Телефон'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDeals()
    {
        return $this->hasMany(Deals::class(), ['id' => 'deals_id']);
    }
}
