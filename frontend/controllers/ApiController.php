<?php

namespace frontend\controllers;

use app\models\Tasks;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ApiController extends Controller
{

    /**
     * Получаем звонки по API
     */
    public function actionGetCalls()
    {

        // Вызываем модель в которое делаем запись в базу, отправку в телегу и т.д и т.п
        if (!isset(\Yii::$app->request->cookies['test'])) {
            // Установить куки
            \Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'test',
                'value' => '600'
            ]));
        }
        //return  /Yii::$app->request->cookies['test'];
        return '111111111111'. \Yii::$app->request->cookies['test']; // получаем значение куки
    }

    /**
     * Получаем заявки с сайтов
     */
    public function actionGetOrders()
    {




        return 'ssrhsrthr';
    }
// Меняем статус задачи по крону, если дата истекла
    public function actionStatusTask()
    {
        $now = date('Y-m-d H:i:s');
        $text = 'Cron отработал '. $now.' ';
        if ($this->request->get('cron') == 'status'){
            file_put_contents('text.txt', $text, FILE_APPEND);


            $models = Tasks::find()->all();
            foreach ($models as $model) {
                //return $model->status;
                if ($now > date('Y-m-d H:i:s', strtotime($model->date_end)) && $model->status == 1){
                    $model->status = 2;
                    $model->update();
                }

            }

        }

    }

}