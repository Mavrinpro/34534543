<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "time_tracking".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $date_at
 * @property int|null $date_end
 * @property int|null $session_start
 * @property int|null $session_end
 */
class Tracking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'time_tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date_at', 'date_end', 'session_start', 'session_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'date_at' => 'Date At',
            'date_end' => 'Date End',
            'session_start' => 'Session Start',
            'session_end' => 'Session End',
        ];
    }

    // Проверка - если session_end == null, то кнопка старт = disabled
    public function getB($id)
    {
        $user = Tracking::find()->where('user_id' == $id)->one();
        if ($user->session_end == null)
        {
            return $user->session_end;
        }

    }
}
