<?php

namespace frontend\controllers;

use app\models\Api;
use app\models\DealsRepeat;
use common\models\User;
use app\models\Deals;
use app\models\Tasks;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Workerman\Worker;
use Yii;
//use yii\web\User;


class ApiController extends Controller
{


    /**
     * Получаем звонки по API
     */
    public function actionGetCalls()
    {
        // Вызываем модель в которое делаем запись в базу, отправку в телегу и т.д и т.п
        if (Yii::$app->request->get('tester') == 'test') {

            $model = new Deals();
            $api = new Api();
            $repeat = new DealsRepeat();
            $request = \Yii::$app->request;
            $date = date('Y-m-d H:i:s');
            $name  = $request->get('name');
            $phone  = $request->get('phone');
            $phone = str_replace(array('(', ')', ' ', '-'), '', $phone);
            $host = $request->get('addr');
            $tag = 10; // ABC 6-заявка с сайта

            switch ($_REQUEST['treeName']){
                case '50745':
                    $tagName = '13';
                    break;
                case '58-04-04':
                    $tagName = '14';
                    break;
                case '58-04-04 Распределитель':
                    $tagName = '15';
                    break;
                case '8800 Новотел':
                    $tagName = '16';
                    break;
                case '8800 Распределитель':
                    $tagName = '17';
                    break;
                case 'Коллтрекинг':
                    $tagName = '18';
                    break;
                case 'Коллтрекинг Распределитель':
                    $tagName = '19';
                    break;
                case 'Телефония Екб':
                    $tagName = '20';
                    break;
                case 'Телефония Краснодар':
                    $tagName = '21';
                    break;
                case 'Телефония Крым':
                    $tagName = '22';
                    break;
                case 'Телефония Пятигорск':
                    $tagName = '23';
                    break;
                case 'Телефония СПБ':
                    $tagName = '24';
                    break;
                default:
                    $tagName = '16';
            }

            $status = [
                1 => 1, //'звонки'
                2 => 2, //'думает'
                3 => 3, //'записан на прием'
                4 => 4, //'отказ'
                5 => 5, //'информ звонок'
                6 => 6 // 'неразобранные'
            ];
            $filial = [
                'ulsk'      => 1,
                'krd'       => 4,
                'spb'       => 5,
                'ekb'       => 6,
                'ptg'       => 7,
                'simf'      => 8,
                'tyumen'    => 9
            ];

            // Проверка на город
            if ($_REQUEST['treeNumber'] == '000-252658'){
                $branch = $filial['ekb']; // Телефония ЕКБ
            }else if($_REQUEST['treeNumber'] == '00037158'){
                $branch = $filial['spb']; // Телефония СПБ
            }else if($_REQUEST['treeNumber'] == '00037160'){
                $branch = $filial['krd']; // Телефония Краснодар
            }else{
                $branch = $filial['ulsk']; // Телефония Ульяновск
            }

            $id_operator = User::find()->where(['status' => 10])->andWhere(['!=', 'id', 1])->all();
            $operator = [];
            foreach ($id_operator as $oper) {
                $operator[] = $oper->id;
            }
            $rand_keys = array_rand($operator, 1); // рандом id пользователя с актитвным статусом
            //echo $operator[$rand_keys];


            $TEXT = print_r($_REQUEST, 1);
            $token = "bot621887368:AAGadjDhXjO3bEs_ILHiJ6_4j1OCZ6jUO6M";
            $chat_id = "421856115";
//$txt = [];
//

            //==================================== Завершение вызова =================================//
            if ($_REQUEST['event'] == '2' && $_REQUEST['src_type'] == 1){
                foreach ($_REQUEST  as $key => $item ) {
                    $text_event2 .= '<b>' . $key . '</b>: ' . $item ."\r\n";

                    $EMPLOYEE_ID = NULL;

                    // Последний сотрудник, который ответил на звонок
                    $employee = Deals::find()
                        ->where(['answer' => 1])
                        ->andWere(['company_id' => 1])
                        ->orderBy('date_create DESC')->one();
                    if (strlen(@$_REQUEST['last_called']) == 0){
                        $EMPLOYEE_ID = $employee->id;
                    }



                    if ($key == 'timestamp'){
                        $item = date('d.m.Y H:i:s',$item);
                    }
                    $date = date('Y-m-d H:i:s', $_REQUEST['timestamp']);
                    //$event  = 'event';



                    // Установка статуса
                    if ($_REQUEST['status'] == 'ANSWER'){
                        $answer = 1;
                    }else if($_REQUEST['status'] == 'NOANSWER'){
                        $answer = 0;
                    }else{
                        $answer = 1;
                    }

                    // Разбиваем пришедший last_called на массив через &
                    $last_called = explode('&',$_REQUEST['last_called']);

                    // Если был сотрудник
                    if (strlen(@$last_called[0]) > 0){
                        $EMPLOYEE_ID = (int)$last_called[0];
                    }
                    // Если переадресован на второго сотрудника
                    if (strlen(@$last_called[1]) > 0){
                        $EMPLOYEE_ID = (int)$last_called[1];
                    }



                    $operator = User::find()->where(['last_called' => $EMPLOYEE_ID])->andWhere(['!=', 'id', 1])->one();
                    $op_id = $operator->id;
                    if ($op_id == ''){
                        $op_id = '463695687';
                    }
                    $company = 1;

                    // Если мы не нашли оператора по добавочному, тогда нам нужно уведомление в телегу
                    if((int)@$operator->id == 0) {

                        $tlg_text = '';
                        $tlg_text .= 'Ошибка выборки в базе сотрудника';
                        $tlg_text .= PHP_EOL.'Метод: '.__METHOD__;
                        $tlg_text .= PHP_EOL.'Строка: '.__LINE__;
                        $tlg_text .= PHP_EOL.'Переменная EMPLOYEE_ID ='.$EMPLOYEE_ID;
                        $tlg_text .= PHP_EOL.' '.print_r(@$_REQUEST, 1);


                    }else{



                        // Пишем в базу и распределяем на сотрудника ГлазЦентр
                        $api->finishCall($model, $_REQUEST['src_num'], $tagName, $operator->id,
                            $_REQUEST['call_record_link'], $answer, $branch);

                        $deals = Deals::find()->where(['phone' => $_REQUEST['src_num'], 'del' => 0])->one();



                        $api->DealsRepeat($repeat, $deals->id, $_REQUEST['src_num'], $_REQUEST['src_num'], null, date('Y-m-d H:i:s', $_REQUEST['timestamp']), null, $deals->id_operator, null, $answer, $_REQUEST['call_record_link']);


                        // отправляем в телегу
                        @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($text_event2));
                    }
                }

            }


            // ============================ получение отвеченных =============================//
            if ($_REQUEST['event'] == '3' && $_REQUEST['src_type'] == '1'){


                $last_called = explode('&',$_REQUEST['last_called']);
                $last_called = $_REQUEST['dst_num'];
// получаем 6 символов с конца строки (отсчёт с конца =- потому и минус)
                $last_called = substr($last_called, -3); // последние 3 цифры
// Если переадресован на второго сотрудника


                // Пишем в базу и распределяем на сотрудника ГлазЦентр
                $operator = User::find()->where(['last_called' => $last_called])->andWhere(['!=', 'id', 1])->one();

                if (empty($last_called)){
                    $operator->id = $operator[$rand_keys];
                }
                foreach ($_REQUEST  as $key => $item ) {
                    $txt3333 .= '<b>' . $key . '</b>: ' . $item ."\r\n";
                    //$txt3333 .= '=================='."\r\n";
                    //$txt3333 .= '<b>OPerator_id: </b>' . $operator->id ."\r\n";
                }

                $deals = Deals::find()->where(['phone' => $_REQUEST['src_num'], 'del' => 0])->one();
                //$api->suplyCAlls($model, $_REQUEST['src_num'], date('Y-m-d H:i:s', $_REQUEST['timestamp']), $_REQUEST['src_num'], $tagName, 1, $operator->id, $branch, null, 1, 1, null);


                $api->event3($deals, $_REQUEST['src_num'], $operator->id, $tagName, $branch, $answer);



            }
            // отправляем в телегу начало звонка
            @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($txt3333));


            //=============================== Первое касание ===============================//
            if ($_REQUEST['event'] == '1' && $_REQUEST['src_type'] == 1){
                foreach ($_REQUEST  as $key => $item ) {
                    $event1 .= '<b>' . $key . '</b>: ' . $item ."\r\n";
                }
                // Старт звонка
                $api->startCAll($model, $_REQUEST['src_num'], $_REQUEST['src_num'], date('Y-m-d H:i:s', $_REQUEST['timestamp']), 1, 1);
            }

            // отправляем в телегу
            @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($event1));





            // отправляем в телегу при ошибке
            @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($tlg_text));

        }


    }

    /**
     * Получаем заявки с сайтов
     */
    public function actionGetOrders()
    {
        $model = new Deals();
        $api = new Api();
        $request = \Yii::$app->request;
        $date = date('Y-m-d H:i:s');
        $name  = $request->get('name');
        $phone  = $request->get('phone');
        $phone = str_replace(array('(', ')', ' ', '-'), '', $phone);
        $host = $request->get('addr');
        $tag = 10; // ABC 6-заявка с сайта
        $status = [
            1 => 1, //'звонки'
            2 => 2, //'думает'
            3 => 3, //'записан на прием'
            4 => 4, //'отказ'
            5 => 5, //'информ звонок'
            6 => 6 // 'неразобранные'
        ];
        $filial = [
            'ulsk'      => 1,
            'krd'       => 4,
            'spb'       => 5,
            'ekb'       => 6,
            'ptg'       => 7,
            'simf'      => 8,
            'tyumen'    => 9
        ];
        $id_operator = User::find()
            ->where(['status' => 10])
            ->andWhere(['!=', 'id', 1])
            ->andWhere(['company_id' => 1])
            ->all(); //// Сотрудник компании ГЦ
        ///
        $id_operator2 = User::find()
            ->where(['status' => 10])
            ->andWhere(['!=', 'id', 1])
            ->andWhere(['company_id' => 2])
            ->all(); // Сотрудник
        // компании ABC
        $operator = [];
        $operator2 = [];
        foreach ($id_operator as $oper) {
            $operator[] = $oper->id;
        }

        foreach ($id_operator2 as $oper2) {
            $operator2[] = $oper2->id;
        }
        $rand_keys = array_rand($operator, 1); // рандом id пользователя с актитвным статусом
        $rand_keys2 = array_rand($operator2, 1); // рандом id пользователя с актитвным статусом
        //echo $operator[$rand_keys];

        // Если сайт ABC
        if ($request->get('api') == 'abc' && $request->get('review') == ""){
            $company = 2;
            $api->crmDeals($model, $name, $date, $phone, '10,6', 6, $operator2[$rand_keys2], $filial['ulsk'],
                null, null, $company );

        }

        // Глазцентр Ульяновск сайт
        if ($request->get('api') == 'gc_ulsk'){
            $company = 1;
            $api->crmDeals($model, $name, $date, $phone, '2,6', 6, $operator[$rand_keys], $filial['ulsk'], null, null, $company);
        }

        // Глазцентр Екатеринбург сайт
        if ($request->get('api') == 'gc_ekb'){
            $company = 1;
            $api->crmDeals($model, $name, $date, $phone, '12,6', 6, $operator[$rand_keys], $filial['ekb'], null, null, $company);
        }

        // Глазцентр Краснодар сайт
        if ($request->get('api') == 'gc_krd'){
            $company = 1;
            $api->crmDeals($model, $name, $date, $phone, '1,6', 6, $operator[$rand_keys], $filial['krd'], null, null, $company);
        }

        // Глазцентр Краснодар сайт
        if ($request->get('api') == 'gc_spb'){
            $company = 1;
            $api->crmDeals($model, $name, $date, $phone, '3,6', 6, $operator[$rand_keys], $filial['spb'], null, null, $company);
        }

        // Глазцентр Симферополь сайт
        if ($request->get('api') == 'gc_simf'){
            $company = 1;
            $api->crmDeals($model, $name, $date, $phone, '6', 6, $operator[$rand_keys], $filial['simf'], null, null, $company);
        }

        // Глазцентр Пятигорск сайт
        if ($request->get('api') == 'gc_ptg'){
            $company = 1;
            $api->crmDeals($model, $name, $date, $phone, '6', 6, $operator[$rand_keys], $filial['ptg'], null, null, $company);
        }


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

    // Ставим задачу по крону, если был пропущенный звонок
    public function actionCronTask()
    {
        $model = Deals::find()->where(['answer' => 0])->all();

        foreach ($model as $taskAnswer) {
            $id =[];
            $task = new Tasks();
            $id[]= $taskAnswer->id;
            $tasker = Tasks::find()->where(['status' => 1])->andWhere(['in', 'deals_id', $id])->count();

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

                $text = 'Задача установлена '. date('Y-m-d H:i:s').' ';
                file_put_contents('text.txt', $text, FILE_APPEND);
            }
        }

    }

    // Получаем звонки только ABC клиники
    public function actionGetAbc()
    {
        // Вызываем модель в которое делаем запись в базу, отправку в телегу и т.д и т.п
        //if (Yii::$app->request->get('call') == 'abc') {

        $model = new Deals();
        $api = new Api();
        $request = \Yii::$app->request;
        $date = date('Y-m-d H:i:s');
        $name  = $request->get('name');
        $phone  = $request->get('phone');
        $phone = str_replace(array('(', ')', ' ', '-'), '', $phone);
        $host = $request->get('addr');
        $tag = 10; // ABC 6-заявка с сайта
        $status = [
            1 => 1, //'звонки'
            2 => 2, //'думает'
            3 => 3, //'записан на прием'
            4 => 4, //'отказ'
            5 => 5, //'информ звонок'
            6 => 6 // 'неразобранные'
        ];
        $filial = [
            'ulsk'      => 1,
            'krd'       => 4,
            'spb'       => 5,
            'ekb'       => 6,
            'ptg'       => 7,
            'simf'      => 8,
            'tyumen'    => 9
        ];
        $id_operator = User::find()->where(['status' => 10])->andWhere(['!=', 'id', 1])->andWhere(['company_id' => 2])->all();
        $operator = [];
        foreach ($id_operator as $oper) {
            $operator[] = $oper->id;
        }
        $rand_keys = array_rand($operator, 1); // рандом id пользователя с актитвным статусом

        $TEXT = print_r($_REQUEST, 1);
        $token = "bot621887368:AAGadjDhXjO3bEs_ILHiJ6_4j1OCZ6jUO6M";
        $chat_id = "-1001676306442";
//$txt = [];
//

        foreach ($_REQUEST  as $key => $item ) {

            if ($key == 'timestamp'){
                $item = date('d.m.Y H:i:s',$item);
            }
            $date = date('Y-m-d H:i:s', $_REQUEST['timestamp']);
            $event  = 'event';
            if ($_REQUEST[$event] == '2' && $_REQUEST['src_type'] == 1){

                $last_called = explode('&',$_REQUEST['last_called']);
                if ($_REQUEST['status'] == 'ANSWER'){
                    $answer = 1;
                }else if($_REQUEST['status'] == 'NOANSWER'){
                    $answer = 0;
                }else{
                    $answer = 1;
                }

                // Если переадресован на второго сотрудника
                if (!empty($last_called[1])){
                    $last_called[0] = $last_called[1];
                }

                // Пишем в базу и распределяем на сотрудника ГлазЦентр
                $operator = User::find()->where(['last_called' => $last_called[0]])->andWhere(['!=', 'id', 1])->one();

                if (empty($last_called[0])){
                    $operator->id = $operator[$rand_keys];
                }

                $company = 2; // id компании (ABC)
                $api->crmDeals($model, $_REQUEST['src_num'], $date, $_REQUEST['src_num'], '10', 1, $operator->id, $filial['ulsk'], $_REQUEST['call_record_link'], $answer, $company);

                $txt .= '<b>' . $key . '</b>: ' . $item ."\r\n";
            }


        }

        // отправляем в телегу
        @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($txt));

        //}

    }

}