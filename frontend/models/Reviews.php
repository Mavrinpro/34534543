<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $number_card
 * @property int|null $id_doc
 * @property string|null $review
 * @property string|null $date_create
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_doc', 'name', 'phone'], 'required'],
            [['review'], 'string'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['number_card'], 'string',  'max' => 10],
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
            'number_card' => 'Номер мед. карты',
            'id_doc' => 'Врач',
            'review' => 'Текст отзыва',
            'date_create' => 'Дата',
        ];
    }
}
