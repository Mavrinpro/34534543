<?php

namespace frontend\controllers;

use app\models\Api;
use app\models\Deals;
use app\models\History;
use app\models\Tasks;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use Workerman\Worker;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\HttpBasicAuth;


class SupController extends ActiveController
{
    public $modelClass = 'app\models\Deals';

    // Заявки из чата EnvYbox (на сайте указываем эту ссылку)
    public function actionGetChat()
    {

        $token   = "bot621887368:AAGadjDhXjO3bEs_ILHiJ6_4j1OCZ6jUO6M";
        $chat_id = "-1001676306442";
        $text    = 'Envybox '. date('Y-m-d H:i:s').' ';

        try {

            file_put_contents('text.txt', $text, FILE_APPEND);

            foreach ($_REQUEST  as $key => $item ) {

                $txt .= '<b>' . $key . '</b>: ' . $item ."\r\n";
            }

            // отправляем в телегу
            file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode('66666'));

        } catch (\Exception $e) {
            // отправляем в телегу
            $tlg_text = 'ОШИБКА Exception';
            $tlg_text .= PHP_EOL.'getFile: '.$e->getFile();
            $tlg_text .= PHP_EOL.'getLine: '.$e->getLine();
            $tlg_text .= PHP_EOL.'getMessage: '.$e->getMessage();
            @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($tlg_text));
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return json_encode($_REQUEST);
    }


    // Интеграция с Интеррой для ГлазЦентра
    public function actionGetGlazcentre()
    {

        $token   = "bot621887368:AAGadjDhXjO3bEs_ILHiJ6_4j1OCZ6jUO6M";
        $chat_id = "-1001676306442";
        $text    = 'Интерра '. date('Y-m-d H:i:s').' ';

        try {

            file_put_contents('text.txt', $text, FILE_APPEND);
            $array = [
              'name' => 'Иван',
              'full_name' => 'Иванов',
                'company' => 'Glazcentre',
                'age' => 35,
                'phone' => '79032343238'
            ];
            foreach ($_REQUEST  as $key => $item ) {


                $txt .= '<b>' . $key . '</b>: ' . $item ."\r\n";

            }

            // отправляем в телегу
            file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($txt));

        } catch (\Exception $e) {
            // отправляем в телегу
            $tlg_text = 'ОШИБКА Exception';
            $tlg_text .= PHP_EOL.'getFile: '.$e->getFile();
            $tlg_text .= PHP_EOL.'getLine: '.$e->getLine();
            $tlg_text .= PHP_EOL.'getMessage: '.$e->getMessage();
            @file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($tlg_text));
        }
        return 'Glazcentre';
    }


    // Интеграция с Интеррой для ABC
    public function actionGetAbc()
    {

        $token   = "bot621887368:AAGadjDhXjO3bEs_ILHiJ6_4j1OCZ6jUO6M";
        $chat_id = "-1001676306442";
        $text    = 'Интерра '. date('Y-m-d H:i:s').' ';

        $model = new Deals();
        $api = new Api();
        $history = new History();

        $crm_id = (int)$_REQUEST['CRM_ID'];
        $name = $_REQUEST['NAME']. ' '. $_REQUEST['SECOND_NAME'].' '.  $_REQUEST['LAST_NAME'];
        $phone =  (int)$_REQUEST['PHONE'];
        $company_id = 2;
        $user_id_interra = (int)$_REQUEST['USER_ID'];
        $date = time();
        $date_service = (int)\Yii::$app->formatter->asTimestamp($_REQUEST['DATE']);
        $time_service = $_REQUEST['TIME'];
        $doc_service = $_REQUEST['EMPLOYEE'];
        $talon_id = (int)$_REQUEST['TALON_ID'];
        $birtday = (int)\Yii::$app->formatter->asTimestamp($_REQUEST['BIRTHDAY']);
        $age = (int)$_REQUEST['AGE'];


        $arr = [
            'phone' => '79045366227',
            'name' => 'Семен',
            'crm_id' => '423423'
        ];



        switch ($_REQUEST['GENDER']){
            case 'M':
                $gender = 1;
                break;
            case 'F':
                $gender = 0;
                break;
            default: $gender = null;
        }

        // Услуги
        $services = '';
//        foreach ($_REQUEST['SERVICES']  as $k => $service ) {
//            $services .=  $service .", ";
//        }

        $status = $_REQUEST['STATUS'];
        $responsible = $_REQUEST['RESPONSIBLE']; // кто записал

        try {

            file_put_contents('text.txt', $text, FILE_APPEND);

            foreach ($arr  as $key => $item ) {

                $txt .= '<b>' . $key . '</b>: ' . $item ."\r\n";

            }
            $txt .= PHP_EOL;
            $txt .= '==========================';
            $txt .= PHP_EOL;
//            foreach ($_REQUEST['SERVICES']  as $k => $service ) {
//                $txt .=  '<b>' . $k . '</b>: ' . $service ."\r\n";
//            }
// отправляем в телегу
            file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($txt));




            $deals = Deals::find()->where( [ 'phone' => $arr['phone'], 'del' => 0, 'company_id' => $company_id ] )->one();
            //return $deals->id; die;
            $api->fromInterraAbc($model, $deals->id, $arr['name'], $arr['phone'], $company_id);
            // В историю
//            $api->historyDeals(
//                $history,
//                $phone,
//                $deals->id,
//                $user_id_interra,
//                $date,
//                $date_service,
//                $time_service,
//                $doc_service,
//                $talon_id,
//                $birtday,
//                $age,
//                $gender,
//                $services,
//                $status,
//                $responsible,
//                $company_id
//            );

            // отправляем в телегу
			file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode('35345345435'));

        } catch (\Exception $e) {
            // отправляем в телегу
            $tlg_text = 'ОШИБКА Exception';
            //$tlg_text .= PHP_EOL.'getFile: '.$e->getFile();
            //$tlg_text .= PHP_EOL.'getLine: '.$e->getLine();
            //$tlg_text .= PHP_EOL.'getMessage: '.$e->getMessage();
            file_get_contents('https://api.telegram.org/' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html&text=' . urlencode($tlg_text));
        }
    }

}