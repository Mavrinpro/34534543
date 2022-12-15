<?php

namespace frontend\controllers;

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




}