<?php

namespace frontend\controllers;

use app\models\Api;
use app\models\Deals;
use app\models\History;
use app\models\Tasks;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Workerman\Worker;
use yii\web\Response;
use yii\db\Expression;

class ApiController extends \yii\rest\ActiveController
{
    protected function verbs() {
        $verbs = parent::verbs();
        $verbs =  [
            'api/get-envybox' => ['POST'],
        ];
        return $verbs;
    }

    public function init() {
    }

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
        //$operator = User::find()->where(['last_called' => $last_called[0]])->andWhere(['!=', 'id', 1])->one();
        return 'ssrhsrthr';
    }
// Меняем статус задачи по крону, если дата истекла
    public function actionStatusTask()
    {
        $now = date('Y-m-d H:i:s');
        $text = 'Cron отработал '. $now.' ';
        if ($this->request->get('cron') == 'status'){
            //file_put_contents('text.txt', $text, FILE_APPEND);


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


            $model = Deals::find()->where(['answer' => 0])->all();

            foreach ($model as $taskAnswer) {
                $id =[];
                $task = new Tasks();
                $id[]= $taskAnswer->id;
                $tasker = Tasks::find()->where(['status' => 1])->andWhere(['in', 'deals_id', $id])->count();
                //var_dump($tasker);
                if ($tasker > 0){
                    $task->date_create = date('Y-m-d H:i:s');
                    $task->update();
                }else {


                    $task->name = 'Задача-' . strtotime(date('Y-m-d H:i:s'));
                    $task->status = 1;
                    $task->date_create = date('Y-m-d H:i:s');
                    $task->date_end = date('Y-m-d 23:59:59', strtotime("+1 day"));
                    $task->user_id = $taskAnswer->id_operator;
                    $task->deals_id = $taskAnswer->id;
                    $task->save();
                }
            }
            $text = 'Cron отработал по задачам'. date('Y-m-d H:i:s').' ';
            file_put_contents('text.txt', $text, FILE_APPEND);



    }

    public function actionGetEnvybox()
    {
        $token   = "bot621887368:AAGadjDhXjO3bEs_ILHiJ6_4j1OCZ6jUO6M";
        $chat_id = "-1001676306442";
        $text    = 'Интерра '. date('Y-m-d H:i:s').' ';

        \Yii::$app->response->format = Response::FORMAT_JSON;
        //return 100;
        $api = new Api();
        $model = new Deals();
        $history = new History();
        $company_id = 2;
        $serv = [
            'sertsertsertaer', 'ytjesyjetyjedtyj'
        ];
        $ARR = [
            'PHONE' => '79176095777',
            'USER_ID' => '158454',
            'TALON_ID' => '1514013395',
            'NAME' => 'Петр',
            'SECOND_NAME' => 'Александрович',
            'LAST_NAME' => 'Гаврилов',
            'GENDER' => 'M',
            'BIRTHDAY' => '18.10.2022',
            'AGE' => '20',
            'DATE' => '2023-01-30',
            'TIME' => '15:40 - 16:00',
            'EMPLOYEE' => 'Страхова  Елена Владиславовна',
            'STATUS' => 'Записан на прием',
            'RESPONSIBLE' => 'Цветкова Дарья Дмитриевна',
            'PRICE' => '350.00',
            'EMAIL' => ''
        ];
        // Сотрудники
        $RESPONSIBLE = [
            62 => 'Бакеева Ольга Владимировна',
            63 => 'Солаева Виктория Петровна',
            64 => 'Цветкова Дарья Дмитриевна'
        ];

        // Статус сделки
        switch ($ARR['STATUS']){
            case 'Записан на прием':
                $status = 3;
                break;
            case 'Принят':
                $status = 2;
                break;
            case 'Отказ':
                $status = 4;
                break;
            default: $status = 3;
        }

        // id сотрудника
        $key_responsible = array_search($ARR['RESPONSIBLE'], $RESPONSIBLE);
        echo $key_responsible;

        $phone = $ARR['PHONE'];
        $user_id_interra = $ARR['USER_ID'];
        $date = time();

        //$date_service = date('Y-m-d',strtotime($ARR['DATE']));
        $date_service = (int)\Yii::$app->formatter->asTimestamp(strtotime($ARR['DATE']));

        $time_service = $ARR['TIME'];
        $doc_service = $ARR['EMPLOYEE'];

        $talon_id = $ARR['TALON_ID'];
        $birtday = (int)\Yii::$app->formatter->asTimestamp($ARR['BIRTHDAY']);

        $age = (int)$ARR['AGE'];
        $gender = (int)$ARR['GENDER'];
        foreach ($serv as $item) {
            $services .= $item.', ';
        }

        switch ($ARR['GENDER']){
            case 'M':
                $gender = 1;
                break;
            case 'F':
                $gender = 0;
                break;
            default: $gender = null;
        }

        $status = $ARR['STATUS'];
        $responsible = $ARR['RESPONSIBLE'];

        foreach ($ARR  as $key => $item ) {
            $txt .= '<b>' . $key . '</b>: ' . $item ."\r\n";
        }
        $deals = Deals::find()->where( [ 'phone' => $phone, 'del' => 0, 'company_id' => $company_id ] )->one();

        //$api->fromInterraAbc($model, $ARR['USER_ID'], $ARR['NAME'], $ARR['PHONE'], 2);
        $date_create = date('Y-m-d H:i:s');
        $answer = 1;
        $id_filial = 1;
        //\Yii::$app->db->schema->refresh(); // Сбросить кэш (пр создании новых полей стаботает)
        try {

        $api->fromInterraAbc(
            $model,
            $ARR['NAME'],
            $ARR['PHONE'],
            '11',
            $date_create,
            $company_id,
            $id_filial,
            (int)$ARR['PRICE'],
            3,
            $key_responsible,
            0,
            $answer,
            $ARR['EMAIL']
        );


        file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id .
         '&parse_mode=html&text=' . urlencode($txt));
        $api->historyDeals(
            $history,
            $phone,
            $deals->id,
            $user_id_interra,
            $date,
            $date_service,
            $time_service,
            $doc_service,
            $talon_id,
            $birtday,
            $age,
            $gender,
            $services,
            $status,
            $responsible,
            $company_id
        );
        } catch (\Exception $e) {
            $tlg_text = 'ОШИБКА Exception';
            $tlg_text .= PHP_EOL.'getFile: '.$e->getFile();
            $tlg_text .= PHP_EOL.'getLine: '.$e->getLine();
            $tlg_text .= PHP_EOL.'getMessage: '.$e->getMessage();
            $tlg_text .= PHP_EOL.'getMessage: '.$e->getMessage();
            file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($tlg_text));
        }
    }



}