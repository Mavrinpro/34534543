<?php

namespace app\models;

use app\models\Deals;
use app\models\History;
use Yii;

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
 * @property bool $answer
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
            [['date_create', 'date_update', 'deal_sum', 'del', 'answer'], 'safe'],
            [['status', 'id_operator', 'id_filial'], 'integer'],
            [['id_comment'], 'string'],
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

    // Приведение номера телефона к единому формакту типа 79000000000
    public function formatPhone($num) {
        $num = preg_replace('/[^0-9]/', '', $num);
        $len = strlen($num);

        if($len == 11) $num = preg_replace('/([0-9]{1})([0-9]{3})([0-9]{3})/', '7$2$3', $num);

        elseif($len == 10) $num = preg_replace('/([0-9]{3})([0-9]{2})([0-9]{2})([0-9]{3})/', '7$1$2$3$4', $num);

        return $num;
    }


    public function fromInterraAbc(
        $model,
        //$id = null,
        $name = null,
        $phone = null,
        $tag = null,
        $date = null,
        $company_id = null,
        $id_filial = null,
        $deal_sum = null,
        $status = null,
        $id_operator = null,
        $del,
        $answer = 1,
        $deal_email = null
    )
    {
        $deals = Deals::find()->where( [ 'phone' => $phone, 'del' => 0, 'company_id' => $company_id ] )->one();

        if ($deals->phone == $phone ) {
            $deals->name = $name;
            $deals->deal_sum = $deal_sum;
            $deals->id_operator = $id_operator;
            $deals->update();
        }else{
            $model->name = $name;
            $model->phone = $phone;
            $model->tag = $tag;
            $model->date_create = $date;
            $model->status = $status;
            $model->company_id = $company_id;
            $model->id_operator = $id_operator;
            $model->id_filial = $id_filial;
            $model->deal_sum = $deal_sum;
            $model->del = $del;
            $model->answer = $answer;
            $model->deal_email = $deal_email;
            $model->save();


        }
    }

    // История изменений из интерры в таблицу history_deals

    public function historyDeals(
        $model,
        $phone,
        $deal_id = null,
        $user_id_interra = null,
        $date = null,
        $date_service = null,
        $time_service = null,
        $doc_service = null,
        $talon_id = null,
        $birtday = null,
        $age = null,
        $gender = null,
        $services = null,
        $status = null,
        $responsible = null,
        $company_id = null
    )
    {
        $deals = Deals::find()->where( [ 'phone' => $phone, 'del' => 0, 'company_id' => $company_id ] )->one();

        if ($deals->phone == $phone){
            $model->deal_id = $deal_id;
            $model->user_id_interra = $user_id_interra;
            $model->date = $date;
            $model->date_service = $date_service;
            $model->time_service = $time_service;
            $model->doc_service = $doc_service;
            $model->talon_id = $talon_id;
            $model->birtday = $birtday;
            $model->age = $age;
            $model->gender = $gender;
            $model->services = $services;
            $model->status = $status;
            $model->responsible = $responsible;
            $model->company_id = $company_id;
            $model->save();
        }
    }

    // Смена статуса
    public function changeStatus($model, $date, $talon_id, $status, $company_id, $message = null)
    {
        $history = Deals::find()->where(['talon_id' => $talon_id, 'company_id' => $company_id])->one();

        if ($history->talon_id == $talon_id){
            $model->date = $date;
            $model->status = $status;
            $model->deal_id = $history->id;
            $model->talon_id = $talon_id;
            $model->company_id = $company_id;
            $model->message = $message;
            $model->save();
        }
    }

    // Назначить ответственного по крону
    public function cronUser($id)
    {
        $deals = Deals::find()->where(['id_operator' => null, 'del' => 0] )->one();
            $deals->id_operator = $id;
            $deals->update();
    }

}
