<?php

namespace frontend\controllers;

use app\models\Doctors;
use app\models\Event;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * DoctorsController implements the CRUD actions for Doctors model.
 */
class DoctorsController extends Controller
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
     * Lists all Doctors models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Doctors::find(),

            'pagination' => [
                'pageSize' => 5,
                'pageSizeParam' =>
                    false,
                'forcePageParam' => false
            ],

            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            $dataProvider->pagination->pageSize = 5
        ]);
    }

    /**
     * Displays a single Doctors model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $ev = new Event();
        $events = Event::find()->where(['user_id' => $id])->all();
        foreach ($events as $event){
            $response[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => date('Y-m-d H:i:s',$event->date_create),
                'end' => date('Y-m-d H:i:s',$event->date_update),
                'color' => 'green',
                'textColor' => 'red'

            ];
        }

        return $this->render('view', [
            'ev' => $ev,
            'event' => $response,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Doctors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Doctors();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->photo = UploadedFile::getInstance($model, 'photo');
            $model->photo->saveAs('uploads/' . $model->photo->baseName . '.' . $model->photo->extension);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Doctors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->photo = UploadedFile::getInstance($model, 'photo');
            $model->photo->saveAs('uploads/' . $model->photo->baseName . '.' . $model->photo->extension);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Doctors model.
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
     * Finds the Doctors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Doctors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctors::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    // Создание Event
    public function actionCreateEvent()
    {
        $event = new Event();
        $id = \Yii::$app->request->post('Event')['user_id'];
        $post = \Yii::$app->request->post();
        if ($this->request->isPost && $event->load($this->request->post()) && $event->save()){
            $event->user_id = $id;
            $event->date_create = strtotime(\Yii::$app->request->post('Event')['date_create']);
            $event->date_update = strtotime(\Yii::$app->request->post('Event')['date_update']);
            $event->save();
            return $this->redirect(['doctors/view', 'id' => $id]);
        }

    }

    // EventDrop
    public function actionAjaxDrop()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request->post();
        $event = Event::find()->where(['id' => $request['id']])->one();
        $dispatchDate = substr($request['start'], 0, strpos($request['start'], '('));
        $event->date_create = date('U', strtotime($dispatchDate));
        $event->date_update = date('U', strtotime($dispatchDate) + 1800);
        $event->update();
        return date('d-m-Y H:i:s', $event->date_create).' - '.date('d-m-Y H:i:s', $event->date_update);
    }

}
