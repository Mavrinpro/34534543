<?php

namespace frontend\controllers;

use app\models\Tracking;
use common\models\User;
use frontend\models\SearchUsers;
use frontend\models\SignupForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\AuthMethod;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['delete', 'index', 'update', 'view', 'change-password', 'session-start', 'session-end', 'switch-user', 'number-format'],
                            'allow' => true,
                            'roles' => ['superadmin', 'admin'],
                        ],
                        [
                            'actions' => ['view', 'logout', 'create', 'update', 'search-deals', 'change-password', 'session-start', 'session-end', 'switch-user'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchUsers();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $user = new User;

            if ($model->load($this->request->post()) && $model->signup()) {
                $lastUserId = User::getEntity();
                //$userRole = \Yii::$app->authManager->getRole('user');
                $user_id = \Yii::$app->user->GetId();

                //$id = $user->getId();
                $auth = \Yii::$app->authManager;
                $userRole = $auth->getRole('user'); // Получаем роль editor
                $auth->assign($userRole, $lastUserId); // Назначаем пользователю, которому принадлежит модель User

                \Yii::$app->session->setFlash('success', 'Новый пользователь зарегистрирован.');
//                echo '<pre>'; die;
//                var_dump($model);
                    return $this->redirect('/user/index');


            }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->username = $this->request->Post('User')['username'];
            $model->full_name = $this->request->Post('User')['full_name'];
            $model->email = $this->request->Post('User')['email'];
            $model->last_called = $this->request->Post('User')['last_called'];
            //echo '<pre>';
            //print_r($model); die;
            $model->update();

            \Yii::$app->session->setFlash('success', 'Данные обновлены.');
            return $this->redirect(['view', 'id' => $model->id]);
        }



        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->status = 0;
        $model->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
// Смена пароля пользователя
    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post())) {

            $model->setPassword($this->request->Post('User')['password']);

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Пароль изменен.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('change-password', [
            'model'=>$model
        ]);
    }

    // ======================= Учет рабочего времени ===================================
    public function actionSessionStart()
    {
        $model = new Tracking();

        $date = date('U');
        if (\Yii::$app->request->get('sessionstart') == 'yes') {
            $model->date_at = $date;
            $model->session_start = $date;
            $model->user_id = \Yii::$app->user->id;
            $model->work = true;
            \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'session_start',
                'value' => $date
            ]));

            $model->save();

            if ($model->save()){
                \Yii::$app->session->setFlash('success', 'Вы начали рабочий день.' .\Yii::$app->request->cookies['session_start']);
                return $this->redirect('/deals/index');
            }

        }

    }

    // Учет рабочего времени
    public function actionSessionEnd()
    {
        $model = new Tracking();
        $sessId = \Yii::$app->request->cookies['session_start'];
        $user_id = \Yii::$app->user->id;

        $trackingId = Tracking::find()->where(['user_id'=> $user_id])->andWhere(['work' => 1])->one();
        $date = date('U');
        $count_time = $date - $sessId->value;
        //print_r($count_time); die;
        if (\Yii::$app->request->get('sessionend') == 'yes') {


            $trackingId->date_end = $date;
            $trackingId->session_end = $date;
            $trackingId->work = false;
            $trackingId->count_time = $count_time;
            $trackingId->update();

            \Yii::$app->session->setFlash('success', 'Вы закончили рабочий день.');
            \Yii::$app->response->cookies->remove('session_start');
            //$model->update();
            return $this->redirect('/deals/index');
        }

    }

    public function actionSwitchUser($id)
    {
        $user = $this->findModel($id);
        $initialId = \Yii::$app->user->getId(); //here is the current ID, so you can go back after that.
        if ($id == $initialId) {
            return $this->redirect(['view', 'id' => $user->id]);
        } else {

            $duration = 0;
            \Yii::$app->user->switchIdentity($user, $duration); //Change the current user.
            \Yii::$app->session->set('user.idbeforeswitch',$initialId); //Save in the session the id of your admin user.
            return $this->redirect(['view', 'id' => $user->id]);
        }
    }



    public function actionNumberFormat()
    {
        $user = new User;
        $number = 56380.356;
        return $user->numberFormat($number);
        //return number_format($number, 2, ',', ' ');



    }


































}
