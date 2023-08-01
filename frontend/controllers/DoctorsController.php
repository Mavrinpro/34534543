<?php

namespace frontend\controllers;

use app\models\Doctors;
use app\models\Event;

//use Symfony\Component\EventDispatcher\Event;
use app\models\Files;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\UploadForm;

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
        \Yii::$app->db->schema->refresh();
        //        $create_event = \Yii::$app->request->post('create_event');
        $ev = new Event();
        $files = Files::find()->all();
        $f = new Files();
        //        if (isset($create_event)){
        //            $ev->date_create = date('U', \Yii::$app->request->post('date_create'));
        //            $ev->date_update = date('U', \Yii::$app->request->post('date_update'));
        //            $ev->save();
        //            //var_dump( $ev);
        //            return $this->redirect(['doctors/view', 'id' => $id]);
        //        }

        $events = Event::find()->where(['user_id' => $id])->all();

        foreach ($events as $event) {
            $response[] = array(
                "id" => $event->id,
                "title" => $event->name,
                "description" => $event->user_id,
                "start" => date('Y-m-d H:m:i', $event->date_create),
                "end" => $event->date_update,
                "color" => 'green'
            );
        }


        return $this->render('view', [
            'f' => $f,
            'files' => $files,
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

    public function actionAjaxDoc()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (\Yii::$app->request->isAjax) {
            return \Yii::$app->request->post();
        }
    }


    // EventDrop
    public function actionAjaxDrop()
    {
        $request = \Yii::$app->request->post();
        $event = Event::find()->where(['user_id' => $request['user_id']])->andWhere(['id' => $request['id']])->one();

        \Yii::$app->response->format = Response::FORMAT_JSON;

        $dispatchDate = substr($request['start'], 0, strpos($request['start'], '('));

        $event->date_create = date('U', strtotime($dispatchDate));
        $event->date_update = date('U', strtotime($dispatchDate) + 1800);
        $event->update();

        return date('Y-m-d H:i:s', $event->date_create) . ' - ' . date('Y-m-d H:i:s', $event->date_update);
    }

    public function actionCreateEvent()
    {
        //$create_event = \Yii::$app->request->post('create_event');
        $request = \Yii::$app->request->post('Event');
        $ev = new Event();


        if ($this->request->isPost) {

            if ($ev->load($this->request->post())) {

                $ev->date_create = strtotime($ev->date_create);
                $ev->date_update = strtotime($request['date_create']) + 1800;
                $ev->save();
                \Yii::$app->session->setFlash('success', 'Задача успешно создана');
                return $this->redirect(['view', 'id' => $request['user_id']]);
            }
        } else {
            $ev->loadDefaultValues();
        }
        //var_dump( $id); die;
        //return $this->redirect(['doctors/view', 'id' => $id]);

    }

    // Удаление файла
    public function actionRemoveDocument($id)
    {
        $request = \Yii::$app->request->get();
        $files = Files::find()->where(['id' => $request['id']])->one();
        //unlink('/files/'.$files->name);
        unlink('files/' . $files->name);
        $files->delete();
        \Yii::$app->session->setFlash('success', 'Файл успешно удален');
        return $this->redirect(['doctors/view', 'id' => $request['modelid']]);


        //var_dump($files);

    }

    // Установить заголовок для файла
    public function actionSetTitle()
    {
        $pageId = \Yii::$app->request->post('Doctors');
        $request = \Yii::$app->request->post('Files');
        $files = Files::find()->where(['id' => $request['id']])->one();
        //var_dump($file); die();

        //var_dump($pageId); die();
        $files->title = $request['title'];
        $files->date_end = time();
        $files->user_id_update = \Yii::$app->user->getId();
        $files->update();
        \Yii::$app->session->setFlash('success', 'Название задано',['progressBar' => true]);
        return $this->redirect(['/doctors/view', 'id' => $pageId['id']]);


    }

}
