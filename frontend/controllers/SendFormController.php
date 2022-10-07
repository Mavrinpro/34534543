<?php

namespace frontend\controllers;

use app\models\Deals;
use common\models\User;
use frontend\models\SearchDeals;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SendFormController extends Controller
{

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
            //\Yii::$app->session->setFlash('success', 'Данные обновлены!');
            $model->tag = implode(",", $_POST['tag']);
            return $this->renderAjax(['deals/index', 'id' => $model->id]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}