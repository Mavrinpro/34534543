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
            [['user_id', 'deals_id', 'date_end'], 'safe'],
            [[], 'required'],
            [['date_create', 'date_update', 'name', 'status'], 'safe'],
           //[['date_end'], 'datetime'],
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
            'date_create' => 'Дата создания',
            'date_update' => 'Дата обновления',
            'status' => 'Статус',
            'deals_id' => 'Телефон',
            'date_end' => 'Дата окончания'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDeals()
    {
        return $this->hasOne(Deals::className(), ['id' => 'deals_id']);
    }

//    public function getDeals()
//    {
//        return $this->hasMany(Deals::className(), ['deals_id' => 'id']);
//    }
}
