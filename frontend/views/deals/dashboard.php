<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use practically\chartjs\Chart;
use dosamigos\chartjs\ChartJs;

/** @var yii\web\View $this */
/** @var \app\models\Deals $model */

$this->title = 'Рабочий стол';
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$user_id = Yii::$app->user->getId();
$taskCount  = new \app\models\Tasks();
$deals = new \app\models\Deals();
$today = date('Y-m-d 23:59:50');
$d = \app\models\Deals::find()->where('date_create' <= '2022-10-11 23:59:59')
    ->select('date_create')
    ->addSelect('count(id) as data')
    ->groupBy('date_create')
    ->createCommand();
//echo '<pre>';
//print_r($d);
?>
<div class="row">
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">

                <h3><?= $model->dealsCount($user_id) ?></h3>
                <p>Ваших сделок</p>
            </div>
            <div class="icon">
                <i class="fas fa-th"></i>
            </div>
            <a href="#" class="small-box-footer">
                Перейти <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!--Вывод активных задач-->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $taskCount->activeTask($user_id) ?></h3>
                <p>Активные задачи</p>
            </div>
            <div class="icon">
                <i class="fas fa-thumbtack"></i>
            </div>
            <a href="#" class="small-box-footer">
                Перейти <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
<!--Задачи на сегодня-->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $taskCount->todayTask($user_id) ?></h3>
                <p>Задачи на сегодня</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <a href="#" class="small-box-footer">
                Перейти <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!--Просроченные задачи-->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $taskCount->taskOverdue($user_id) ?></h3>
                <p>Просроченные задачи</p>
            </div>
            <div class="icon">
                <i class="fas fa-thumbtack"></i>
            </div>
            <a href="#" class="small-box-footer">
                Перейти <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-12">
        <?php
        $num = [65, 59, 90, 81, 56, 55, 40, 65, 59, 90, 81, 56, 55, 40, 65, 59, 90, 81, 56, 55, 40, 65, 59, 90, 81,
            56,];
        //$users = $deals->getDay30($today);
        foreach (lastDay30() as $key => $Date)
        {
            $ARRKEY = [];
            $ARRKEY[] = $key;
            $arrDate[$key] = $Date; // Список дат для графика (по филиалам)
        }
        $arrDate = $num;
        $sfsed =[];
        //$sfsed[] = $arrDate[$key] = $num;
        var_dump($arrDate);
        echo Chart::widget([
            'type' => Chart::TYPE_BAR,
            'labels' => $arrDate,
            'datasets' => [
                [
                    'data' => [
                        $arrDate

                    ]
                ]
            ]


        ]);
        ?>
        <?php $countDeals = \app\models\Deals::find()->where('date_create' > $today + 10)->count(); ?>

    </div>

</div>