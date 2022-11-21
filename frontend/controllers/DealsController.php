<?php

namespace frontend\controllers;

use app\models\Deals;
use common\models\User;
use frontend\models\SearchDeals;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $query = Deals::find()->with('user', 'tasks')->orderBy('date_create DESC');
        $pages = new \yii\data\Pagination(['totalCount' => $query->count(), 'pageSize' => $offset, 'pageSizeParam' =>
            false, 'forcePageParam' => false]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        //$searchModel = new SearchDeals();
        //$dataProvider = $searchModel->search($this->request->queryParams);
        //$dataProvider->sort = ['defaultOrder' => ['date_create'=>SORT_DESC, 'id'=>SORT_DESC]];
        //$dataProvider->pagination = ['pageSize' => 150];


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
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
                $model->save();
                \Yii::$app->session->setFlash('success', 'Новая сделка добавлена!');
                return $this->redirect(['deals/index']);

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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('error', 'Сделка удалена!');
                $model->del = 1;

                $model->update();

                return $this->redirect(['deals/index']);

        }

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
        $model = $this->findModel($id);

    if ($this->request->isPost && $model->load($this->request->post())) {
        $model->tag = implode(",",$model->tag);
        $model->id_comment = strip_tags($model->id_comment);
        $model->save();
        \Yii::$app->session->setFlash('success', 'Cделка обновлена!');
        return $this->redirect(['deals/']);
    }
//        if (\Yii::$app->request->isAjax){
//            $model->tag = explode(',', $model->tag);
//            return $this->renderAjax('update_form', ['model' => $model]);
//        }
        $model->tag = explode(',', $model->tag);
        return $this->render('update', ['model' => $model,]);


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
}
