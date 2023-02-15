<?php

namespace frontend\controllers;

use app\models\Api;
use app\models\Deals;
use app\models\DealsRepeat;
use app\models\LayoutsMail;
use app\models\Mail;
use common\models\User;
use app\models\Tasks;
use frontend\models\SearchDeals;
use frontend\models\DeleteDeals;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * DealsController implements the CRUD actions for Deals model.
 */
class DealsController extends Controller
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
                            'actions' => ['delete', 'updater', 'dashboard', 'delete-deals', 'search-ajax', 'status-ajax', 'update-task'],
                            'allow' => true,
                            'roles' => ['admin', 'superadmin'],
                        ],
                        [
                            'actions' => ['logout', 'index', 'create', 'update', 'search-deals', 'view', 'updater', 'dashboard', 'search-ajax', 'status-ajax', 'update-task'],
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
     * Lists all Deals models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $offset = 40;
        if  (\Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name ==
            'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name ==
            'admin'){
            $query = Deals::find()->with('user', 'tasks')->where(['del' =>  0])->orderBy('date_create DESC')->addOrderBy('date_update ASC');
        }else{

        $query = Deals::find()->with('user', 'tasks')->where(['id_operator' =>  \Yii::$app->user->id])->andWhere(['del' =>  0])
            ->orderBy('date_create DESC')->addOrderBy('date_update DESC');
        }
        $pages = new \yii\data\Pagination(['totalCount' => $query->count(), 'pageSize' => $offset, 'pageSizeParam' =>
            false, 'forcePageParam' => false]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        //$searchModel = new SearchDeals();
        //$dataProvider = $searchModel->search($this->request->queryParams);
        //$dataProvider->sort = ['defaultOrder' => ['date_create'=>SORT_DESC, 'id'=>SORT_DESC]];
        //$dataProvider->pagination = ['pageSize' => 150];
        $dataProvider = new ActiveDataProvider([
            'query' => Deals::find()->with('user', 'tasks')->where(['del' =>  0])->orderBy('date_create DESC')->addOrderBy('date_update DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($_POST['action'] === 'dragged'){
            //\Yii::$app->session->setFlash('success', "Статья сохранена");
            $post = Deals::findOne($_POST['block_id']);
            $post->status = $_POST['statusID'];
            $post->save();
            $arr = [
                'status' => $_POST['statusID'],
                'id'      => $_POST['block_id'],
                'message' => 'Статус сделки изменен!'
            ];
            return json_encode($arr);
        }
        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
            'dataProvider' => $dataProvider
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
            //$dataProvider->pagination->pageSize=1
        ]);

    }
    /**
     * Displays a single Deals model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $mail = new Mail();
        $api = new Api();
        $repeat = new DealsRepeat();
        //$api->DealsRepeat($repeat, 4, '89099999999', '89099999999', null, date('Y-m-d H:i:s'), null, 7, null, 1, 'ghfhfgfghfghg');


        if ($this->request->isPost) {
            if ($this->request->Post('Deals')['id'] != '') {
                $layout = $mail->getLayouts($this->request->Post('Deals')['id']);

                \Yii::$app->session->setFlash('success', 'Письмо: ' . $layout->name . ' успешно отправлено');
                file_put_contents('text.txt', json_encode([$this->request->Post('Deals')['id'], $layout->name]));
                return $this->refresh();
            }else{
                \Yii::$app->session->setFlash('error', 'Нужно выбрать шаблон письма');
            }
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'mail' => $mail,
            'repeat' => $repeat
        ]);
    }

    /**
     * Creates a new Deals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Deals();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->tag = implode(",",$model->tag);
                $model->id_comment = strip_tags($model->id_comment);
                $model->phone = '7'.$model->phone;
                $model->save();
                \Yii::$app->session->setFlash('success', 'Новая сделка добавлена!');
                return $this->render('update', [
                    'model' => $model,
                ]);

            }
            \Yii::$app->session->setFlash('error', 'Что-то пошло не так!');
        } else {

            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

     // Изменяет видимость сделки del = 1
    public function actionUpdater($id)
    {
        $model = $this->findModel($id);

        $model->del = 1;
            \Yii::$app->session->setFlash('error', 'Сделка удалена!');


                $model->update();

                return $this->redirect(['deals/index']);



        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing Deals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //\Yii::$app->db->schema->refresh();
        $model = $this->findModel($id);
        $taska = new Tasks();

        $send_deals = \Yii::$app->request->post('send_deals');
        $send_task = \Yii::$app->request->post('send_task');


    if ($this->request->isPost && $model->load($this->request->post()) && isset($send_deals)) {

            $model->tag = implode(",", (array)$model->tag);
            $model->id_comment = strip_tags($model->id_comment);
            $model->changeUserTask($id, $model->id_operator); // смена ответственного в задаче
            $model->update();
            \Yii::$app->session->setFlash('success', 'Cделка обновлена!');
            return $this->refresh();

    }

        if ($this->request->isPost && $taska->load($this->request->post()) && isset($send_task)) {
            $taska->save();
            \Yii::$app->session->setFlash('success', 'Задача создана!');
            return $this->refresh();
        }

        $model->tag = explode(',', $model->tag);
        return $this->render('update', ['model' => $model, 'taska' => $taska]);


    }


    /**
     * Deletes an existing Deals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Deals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Deals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Deals::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findTask($id)
    {
        if (($model = Tasks::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Страница поиска всех сделок
    public function actionSearchDeals()
    {
        //$deals = Deals::find()->orderBy('date_create DESC')->all();
        $searchModel = new SearchDeals();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 35;

        return $this->render('search-deals', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // Рабочий стол оператора
    public function actionDashboard()
    {
        $model = new Deals();
        return $this->render('dashboard', [
            'model' => $model
        ]);
    }

    // Удаленные сделки
    public function actionDeleteDeals()
    {
        //$deals = Deals::find()->orderBy('date_create DESC')->all();
        $searchModel = new DeleteDeals();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 35;

        return $this->render('delete-deals', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    // Ajax search
     public function actionSearchAjax() {

         if (\Yii::$app->request->isAjax) {

             $input_search = \Yii::$app->request->get('input_search');
             $model = Deals::find()->where(['OR',['like', 'phone', $input_search], ['like', 'name', $input_search]])->all();
             \Yii::$app->response->format = Response::FORMAT_JSON;
             if (sizeof($model) > 0){
                 return $model;
             }else{
                 return false;
             }

        }
   }


     // Смена статуса Ajax на страанице view deals

    public function actionStatusAjax()
    {
        $status = \Yii::$app->request->post();
        $model = Deals::find()->where(['id' => $status["Deals"]["id"]])->one();
        if (\Yii::$app->request->isAjax) {
        $model->status = $status['Deals']['status'];
        $model->update();

            \Yii::$app->response->format = Response::FORMAT_JSON;
           return $status['Deals']['id'].'='.$status['Deals']['status'];

        }
    }
    // Закрыть задачу из сделки
    public function actionUpdateTask($id)
    {
        $model = $this->findTask($id);
        $id_deals = $model->deals_id;
        //var_dump($id_deals); die;
        $model->status = 0;


            \Yii::$app->session->setFlash('success', 'Задача закрыта!');
            $model->update();
            return $this->redirect(['deals/update', 'id' => $id_deals]);

        return $this->redirect('deals/update');
    }



}
