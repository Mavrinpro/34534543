<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "doctors".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $last_name
 * @property string|null $first_name
 * @property string|null $specialization
 * @property int|null $work_experience
 * @property int|null $treated_patients
 * @property string|null $photo
 * @property string|null $specialization_text
 * @property string|null $about_doc
 * @property string|null $sertificates
 * @property string|null $education
 * @property string|null $date_create
 */
class Doctors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['work_experience', 'treated_patients'], 'integer'],
            [['specialization_text', 'about_doc', 'sertificates', 'education'], 'string'],
            [['date_create'], 'safe'],
            [['name', 'last_name', 'first_name'], 'string', 'max' => 100],
            [['specialization'], 'string', 'max' => 300],
            [['photo'], 'file'],
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
            'last_name' => 'Фамилия',
            'first_name' => 'Отчество',
            'specialization' => 'Специализация',
            'work_experience' => 'Опыт работы',
            'treated_patients' => 'Treated Patients',
            'photo' => 'Photo',
            'specialization_text' => 'Specialization Text',
            'about_doc' => 'About Doc',
            'sertificates' => 'Sertificates',
            'education' => 'Education',
            'date_create' => 'Date Create',
        ];
    }
}
