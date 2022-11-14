<?php

use app\models\Tasks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\Alert;
//use Smalot\PdfParser\Parser;
/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// Parse PDF file and build necessary objects.
//$parser = new \Smalot\PdfParser\Parser;
//$pdf = $parser->parseFile("http://cdn.glazcentre.ru/docs/text.pdf");

//$data = $pdf->getPages()[0]->getDataTm();

//var_dump($data);
//foreach ($data as $key => $datum) {
//    //echo $datum[1].'<br>';
//}
?>
<!--Ф.И.О: --><?//= $data[8][1]. "</br>" ?>
<!--Пол: --><?//= $data[10][1]. "</br>" ?>
<!--Год рождения: --><?//= $data[12][1]. "</br>" ?>
<!--Дата взятия биоматериала: --><?//= $data[14][1]. "</br>" ?>
<!--<table style="width: 100%;">-->
<!--    <thead>-->
<!--    <th>-->
<!--        <td>--><?//= $data ?><!--</td>-->
<!--        <td>shsrth</td>-->
<!--        <td>shsrth</td>-->
<!--    </th>-->
<!--    </thead>-->
<!--</table>-->
<?php
//
//foreach ($data as $items) {
//
//}




$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="tasks-index">

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            //'user_id',
            [
                //label' => 'Полное имя',
                'attribute'=>'user_id',
                'value' => 'user.username',
                'format' => 'text',

// esli nujen select
                'filter'=>\common\models\User::find()->select(['username', 'id'])->indexBy('id')->column(),

            ],
            [
                'attribute'=>'status',
                'filter'=>array("1"=>"Активные","0"=>"Просроченные"),
            ],

            //'date_update',
            [
                'attribute' => 'date_end',
                'content' => function( $member )
                {
                    return "<b>{$member->date_end}</b>";
                },
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tasks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                  'content' => function( $member )
                {
                    return "<b>{$member->date_end}</b>";
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
