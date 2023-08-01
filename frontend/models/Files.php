<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $title
 * @property int|null $date_at
 * @property int|null $date_end
 * @property int|null $user_id
 * @property int|null $user_id_update
 */
class Files extends \yii\db\ActiveRecord
{
    //public $title;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_at', 'date_end', 'user_id', 'user_id_update'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Название',
            'date_at' => 'Date At',
            'date_end' => 'Date End',
            'file_size' => 'Размер файла'
        ];
    }

}
