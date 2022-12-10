<?php

namespace frontend\controllers;

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
                            'actions' => ['delete', 'index', 'update', 'view', 'change-password'],
                            'allow' => true,
                            'roles' => ['superadmin', 'admin'],
                        ],
                        [
                            'actions' => ['view', 'logout', 'create', 'update', 'search-deals', 'change-password'],
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


            if ($model->load($this->request->post()) && $model->signup()) {
                $userRole = \Yii::$app->authManager->getRole('user');
                if ($model->signup()) {
                    // Назначаем роль в методе afterSave модели User
                    $auth = Yii::$app->authManager;
                    $editor = $auth->getRole('user'); // Получаем роль editor
                    $auth->can($editor, $this->id); // Назначаем пользователю, которому принадлежит модель User

                }
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
            $model->update();
            //var_dump($model);
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
}
