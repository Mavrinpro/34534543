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
        $searchModel = new SearchDeals();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['date_create'=>SORT_DESC, 'id'=>SORT_DESC]];

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
//        if ($_POST['action'] === 'ajaxModal') {
//            $id = $_POST['block_id'];
//            $post = Deals::find()->where(['id' => $id])->one();
//            $operator = User::find()->where(['id' => $post->id_operator])->one();
//            $arr = [
//                'id'      => $post->id,
//                'name' => $post->name,
//                'phone' => $post->phone,
//                'message' => $post->id_comment,
//                'tag' => $post->tag,
//                'status' => $post->status,
//                'id_filial' => $post->id_filial,
//                'operator' => $post->id_operator,
//                'sum' => $post->deal_sum,
//            ];
//
//            return json_encode($arr);
//
//        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            $dataProvider->pagination->pageSize=150
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
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['deals/index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            return $this->redirect(['deals/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
