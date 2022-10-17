<?php

namespace app\models;

use common\models\User;
use Yii;
use app\models\Statuses;
use kartik\select2\Select2;

/**
 * This is the model class for table "deals".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $tag
 * @property string|null $date_create
 * @property string|null $status
 * @property int|null $id_operator
 * @property int|null $id_filial
 * @property int|null $id_comment
 */

class Deals extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deals';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'tag', 'status', 'id_operator', 'id_filial'], 'required'],
            [['date_create'], 'safe'],
            [['date_update'], 'safe'],
            [['id_operator', 'id_filial'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['id_comment'], 'string'],
            //[['tag'], 'string', 'max' => 200],
            [['status'], 'integer'],
            [['deal_sum'], 'integer'],
            [['del'], 'boolean'],
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
            'phone' => 'Телефон',
            'tag' => 'Тег',
            'date_create' => 'дата создания',
            'status' => 'Статус',
            'id_operator' => 'Ответственный',
            'id_filial' => 'Филиал',
            'id_comment' => 'Сомментарий (id)',
            'deal_sum' => 'Сумма сделки',
            'del' => 'Видимость',
        ];
    }

    public function getTags($id)
    {
        $query = Tags::find()->where(['id' => $id])->one();
        return($query);
    }

    public function getUser()
    {
        return $this->hasMany(User::class, ['id' => 'id_operator']);
    }

    public function getBranch(){
        return $this->hasOne(Branch::className(), ['id' => 'id_filial']);
    }

    public function getStatuses(){
        return $this->hasOne(Statuses::className(), ['id' => 'status']);
    }

    public function getData()
    {
        return Deals::find()->where(['del' => 0])->orderBy(['date_create' => SORT_DESC])->all();
    }
}
