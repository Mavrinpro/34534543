<?php

namespace frontend\controllers;

use app\models\Deals;
use app\models\Tasks;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Workerman\Worker;

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
        $operator = User::find()->where(['last_called' => $last_called[0]])->andWhere(['!=', 'id', 1])->one();
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

    public function actionCronTask()
    {

        if ($this->request->get('cron') == 'createtask'){
            $model = Deals::find()->where(['answer' => 0])->all();
            $answer = [];
            $userId = [];
            foreach ($model as $taskAnswer) {
                $answer[] = $taskAnswer->id;
                $userId[] = $taskAnswer->id_operator;

                $task = new Tasks();
                $task->status = 1;
                $task->date_create = date('Y-m-d H:i:s');
                $task->date_end = date('Y-m-d 23:59:59', strtotime("+1 day"));
                $task->user_id = $taskAnswer->id_operator;
                $task->deals_id = $taskAnswer->id;
            }

        }
    }

}