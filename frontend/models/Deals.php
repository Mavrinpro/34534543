<?php

namespace app\models;

use common\models\User;
use app\models\Tasks;
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
 * @property string|null $call_recording
 * @property string|null $deal_email
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
            [['call_recording', 'deal_email'], 'safe'],
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
            'date_create' => 'Дата создания',
            'date_update' => 'Дата обновления',
            'status' => 'Статус',
            'id_operator' => 'Ответственный',
            'id_filial' => 'Филиал',
            'id_comment' => 'Сомментарий (id)',
            'deal_sum' => 'Сумма сделки',
            'del' => 'Видимость',
            'call_recording' => 'Запись звонка',
            'deal_email' => 'Почта'
        ];
    }
    public function getTasks(){
        return $this->hasMany(Tasks::className(), ['deals_id' => 'id']);
    }

    public function getTags($id)
    {
        return $this->hasMany(Tags::class, ['id' => explode(', ', $id)]);
    }
    public function getTags2()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag']);
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

    public function getTegi()
    {
        return $this->hasOne(Tags::class, ['id' => 'tag']);
    }
    public function getUs()
    {
        return $this->hasOne(User::class, ['id' => 'id_operator']);
    }

    public function actionSend($model) {
        $send = Yii::$app->mailer->compose()
            ->setFrom('from_mail@gmail.com')
            ->setTo('to_mail@gmail.com')
            ->setSubject('Test Message')
            ->setTextBody('Plain text content. YII2 Application')
            ->setHtmlBody('<b>HTML content <i>Ram Pukar</i></b>')
            ->send();
        if($send){
            echo "Send";
        }
    }
}
