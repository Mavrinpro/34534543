<?php

namespace app\models;

use app\models\Tasks;
use common\models\User;
use app\models\Company;
use Yii;
use app\models\Statuses;
use kartik\select2\Select2;
use yii\web\Response;

/**
 * This is the model class for table "deals".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $tag
 * @property string|null $date_create
 * @property string|null $status
 * @property int|null $company_id
 * @property int|null $id_operator
 * @property int|null $id_filial
 * @property int|null $id_comment
 * @property string|null $call_recording
 * @property string|null $deal_email
 * @property int|null $region_id
 * @property int|null $age
 * @property int|null $talon_id
 * @property int|null $services_id
 * @property bool|null $gender
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
            [['phone', 'tag', 'status', 'id_operator', 'id_filial', 'services_id'], 'required'],
            [['date_create', 'talon_id'], 'safe'],
            [['name','call_recording', 'deal_email', 'company_id', 'region_id', 'age', 'gender', 'talon_id'], 'safe'],
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
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'tag' => 'Тег',
            'age' => 'Возраст',
            'gender' => 'Пол',
            'company_id' => 'Компания',
            'date_create' => 'Дата создания',
            'date_update' => 'Дата обновления',
            'status' => 'Статус',
            'region_id' => 'Город пациента',
            'id_operator' => 'Ответственный',
            'id_filial' => 'Филиал клиники',
            'id_comment' => 'Комментарий',
            'deal_sum' => 'Сумма сделки',
            'del' => 'Видимость',
            'call_recording' => 'Запись звонка',
            'deal_email' => 'Почта'
        ];
    }
    public function getTasks(){
        return $this->hasMany(Tasks::className(), ['deals_id' => 'id']);
    }

    public function getCompany(){
        return $this->hasOne(Company::class, ['company_id' => 'id']);
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
        $deals =  Deals::find()->where(['del' => 0])->orderBy(['date_create' => SORT_DESC])->all();

        return $deals;
    }

    // Данные по сделкам за последние 30 дней
    public function getDay30()
    {
        return Deals::find()->where(['del' => 0])->orderBy(['date_create' =>
            SORT_DESC])->all();
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

    // Получение количества сделок пользователя
    public function dealsCount($user_id=null)
    {
        return $this::find()->where(['del' => 0, 'id_operator' => $user_id])->andWhere('id_operator' != 1)->count();
    }

    public function taskForDeal($id)
    {
        return Tasks::find()->where(['deals_id' => $id])->andWhere(['!=', 'status', 0])->all();
    }

    // Смена сотрудника в задаче при смене ответственного в сделке (update)

    public function changeUserTask($id, $userId)
    {
        $model = Tasks::find()->where(['deals_id' => $id])->andWhere(['!=', 'status', 0])->one();
        if ($model != null){
            $model->user_id = $userId;
            $model->save();
        }
    }

    // Вывод сотрудника в задаче на update deals
    public function taskUser($id)
    {
        return User::find()->where(['id' => $id, 'status' => 10])->andWhere(['!=', 'id', 1])->one();
    }

    // Вывод комментарев из таблицы commets
    public function comments($deal_id)
    {
        return Comments::find()->where(['deal_id' => $deal_id])->all();
    }


}
