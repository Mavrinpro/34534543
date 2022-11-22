<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "layouts_mail".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $mail_id
 * @property string|null $text
 * @property string|null $img
 * @property string|null $file
 * @property string|null $date_create
 * @property string|null $date_update
 */
class LayoutsMail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'layouts_mail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['mail_id'], 'integer'],
            [['text'], 'string'],
            [['date_create', 'date_update'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['img'], 'string', 'max' => 300],
            [['file'], 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Заголовок',
            'mail_id' => 'Mail ID',
            'text' => 'Текст',
            'img' => 'Img',
            'file' => 'Файл',
            'date_create' => 'Дата создания',
            'date_update' => 'Дата обновления',
        ];
    }

    public function upload()
    {
        if (isset($this->file) && $this->validate()) {

            $this->file->saveAs('foldermail/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}
