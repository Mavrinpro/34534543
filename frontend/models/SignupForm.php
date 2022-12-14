<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $full_name;
    public $email;
    public $password;
    public $status;
    public $last_called;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username','match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message' => 'Логин может состоять из латинских
             букв и цифр'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой логин уже зарегистрироован.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой email уже зарегистрироован.'],

            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['status', 'safe'],
            ['last_called', 'integer'],

            ['full_name', 'trim'],
            ['full_name', 'required'],
            ['full_name','match', 'pattern' => '/^[а-я\s]+$/msiu', 'message' => 'Только русские буквы'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->full_name = $this->full_name;
        $user->email = $this->email;
        $user->last_called = $this->last_called;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    public function Userid($id)
    {
        $user = User::find()->where(['id' => $id]);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'full_name' => 'ФИО',
            'password' => 'Пароль',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'role' => 'Роль',
            'last_called' => 'Номер сотрудника в телефонии'
        ];
    }
}
