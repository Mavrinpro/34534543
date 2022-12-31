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

$period = 30;

$DATA_ALL = [];

// массив дат
function array_date($period)
{
    $result = [];
    $startday = date('Y-m-d', strtotime('+1 DAYS'));
    for($i=$period;$i>0;$i--)
    {
        $result[] = array(
                'days'=> date('Y-m-d', strtotime($startday.' -'.$i.' DAYS')),
            //'name'=>rusdate_month(strtotime(date('Y-m', strtotime($startday.' -'.$i.' DAYS'))), '%MONTH% Y' )
        );
    }
    return $result;
}
function rusdate_month($d, $format = 'j %MONTH% Y', $offset = 0)
{
    $montharr = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
    $dayarr = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');

    $d += 3600 * $offset;

    $sarr = array('/%MONTH%/i', '/%DAYWEEK%/i');
    $rarr = array( $montharr[date("m", $d) - 1], $dayarr[date("N", $d) - 1] );

    $format = preg_replace($sarr, $rarr, $format);
    return date($format, $d);
}

foreach(array_date($period) as $dates) {
    $DATA_ALL[$dates['days']]= 0;
}

$days30 = date('Y-m-d', strtotime('-30 DAYS'));
$d = $deals::find()
    ->select('DATE(date_create) as date, COUNT(id) as count')
    ->where(['del' => 0])
    ->andWhere(['id_operator' => $user_id])
    ->andWhere('DATE(date_create) >= "'.$days30.'"')
    ->groupBy('DATE(date_create)')
    ->asArray()->all();
if(isset($d) && sizeof($d) > 0) {
    foreach($d as $ss) {
        $DATA_ALL[$ss['date']] = $ss['count'];
    }
}

//var_dump($d->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql); // Вывод sql запроса на экран


$mass = [];
$dateArr = [];
foreach ($d as $k => $item) {

    $dateArr[] = date('Y-m-d', strtotime($item->date_create));
}
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
            <a href="/deals" class="small-box-footer">
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
            <a href="/tasks" class="small-box-footer">
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
            <a href="/tasks" class="small-box-footer">
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
            <a href="/tasks" class="small-box-footer">
                Перейти <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-12">
        <?php
        echo Chart::widget([
            'type' => Chart::TYPE_BAR,
            //'labels' => $mass,
            'datasets' => [
                [
                    'data' => $DATA_ALL
                ]
            ],
            'options' => [
                'height' => 100
            ]

        ]);
        ?>

    </div>
</div>