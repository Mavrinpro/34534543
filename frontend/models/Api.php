<?php

namespace app\models;

use Yii;
use app\models\Deals;

/**
 * This is the model class for table "deals".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $tag
 * @property string|null $date_create
 * @property int|null $status
 * @property int|null $id_operator
 * @property int|null $id_filial
 * @property string|null $id_comment
 * @property int|null $deal_sum
 * @property int $del
 * @property string|null $date_update
 * @property string|null $call_recording
 * @property string|null $deal_email
 */
class Api extends \yii\db\ActiveRecord
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
            [['date_create', 'date_update'], 'safe'],
            [['status', 'id_operator', 'id_filial', 'deal_sum', 'del'], 'integer'],
            [['id_comment'], 'string'],
            [['del'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['tag'], 'string', 'max' => 200],
            [['call_recording', 'deal_email'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
            'tag' => 'Tag',
            'date_create' => 'Date Create',
            'status' => 'Status',
            'id_operator' => 'Id Operator',
            'id_filial' => 'Id Filial',
            'id_comment' => 'Id Comment',
            'deal_sum' => 'Deal Sum',
            'del' => 'Del',
            'date_update' => 'Date Update',
            'call_recording' => 'Call Recording',
            'deal_email' => 'Deal Email',
        ];
    }

    // Добавление в таблицу deals_repeat
    public function DealsRepeat($model, $deal_id, $name, $phone, $tag=null, $date_create, $status=null, $id_operator, $date_update=null, $answer, $call_record)
    {
        $deals = Deals::find()->where(['phone' => $phone, 'del' => 0])->one();
        if ($deals->phone == $phone){
            $model->deal_id = $deal_id;
            $model->name = $name;
            $model->phone = $phone;
            $model->date_create = $date_create;
            $model->id_operator = $id_operator;
            $model->answer = $answer;
            $model->call_recording = $call_record;
            $model->save();
        }



    }
}
