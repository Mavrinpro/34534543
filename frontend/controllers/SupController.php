<?php

namespace frontend\controllers;

use app\models\Deals;
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
    public function actionGla()
    {
        return 'Glazcentre';
    }

}