<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \app\models\Deals $model */

$this->title = 'Рабочий стол';
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$user_id = Yii::$app->user->getId();
$taskCount  = new \app\models\Tasks();
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

</div>