<?php

namespace app\models;

use common\models\User;
use common\widgets\Alert;
use Illuminate\Support\Facades\Auth;
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
            [['date_end'], 'required'],
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

    public function getPhone() {
        return $this->deals->phone;
    }

    // Просроченные сделки в сайдбаре
    public function overdueTransactions()
    {
        if (\Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin'){
       return $this::find()->where(['status' => 2])->count();
        }else{
            return $this::find()->where(['status' => 2, 'user_id' => Yii::$app->user->getId()])->count();
        }
    }

    public function Notyfication($count, $num)
    {
        if ($count > 0){
            \Yii::$app->session->setFlash('error', 'Есть просроченные задачи '. $num);
            echo \lavrentiev\widgets\toastr\NotificationFlash::widget([
    'options' => [
        'escapeHtml' => false,
        "closeButton" => true,
        "debug" => false,
        "newestOnTop" => false,
        "progressBar" => false,
        "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
        "preventDuplicates" => false,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ]
]);
        }
    }

}
