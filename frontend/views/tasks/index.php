<?php

use app\models\Tasks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\Alert;
use kartik\date\DatePicker;
//use Smalot\PdfParser\Parser;
/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var app\models\Tasks $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

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
                'format' => 'html',
               'value' => function($model){
                         if($model->status == '1'){
                            return '<span class="text-success"><span class="badge badge-success">Активная</span></span>';
                         }else if($model->status == '0'){
                             return '<span class="text-danger"><span class="badge badge-danger">Просроченная</span></span>';
                         }else{
                             return '<span class="text-gray">Не определена</span>';
                         }
                       },
                'filter'=>array("1"=>"Активные","0"=>"Просроченные"),
            ],

            //'date_update',
            [
                'attribute' => 'date_end',
                'format' => 'html',

                'content' => function( $member )
                {
                    if (date('d.m.Y', strtotime($member->date_end)) == '01.01.1970'){
                        return 'Дата не установлена';
                    }
                    return date('d.m.Y', strtotime($member->date_end));
                },
//                'filter' => DatePicker::widget([
//                    //'options' => ['width' => '100px'],
//                    'options' => [
//            'autocomplete' => 'off',
//            'placeholder' => 'Выберите дату',
//            'data' => [
//                'picker' => 'datepicker'
//            ]
//        ],
//                    'attribute' => 'date_end',
//                    'model' => $searchModel,
//                    'value' => $searchModel->date_create,
//                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
//                    'pluginOptions' => [
//                        'format' => 'yyyy-mm-dd',
//
//                        'autoclose' => true,
//                        'todayHighlight' => true,
//                    ]
//                ]),
            ],

            [
                'class' => ActionColumn::className(),
                'buttons' => [
                    'update' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-edit btn btn-sm btn-warning"></i>',
                            $url);
                    },
                    'view' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-eye btn btn-sm btn-success"></i>',
                            $url);
                    },
                    'delete' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa fa-trash-alt btn btn-sm btn-danger"></i>',
                            $url,[
                            //'title' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Удалить запись № '.$key.'?'),
                            'data-method' => 'post', 'data-pjax' => '1',
                        ]);
                    },


                ],
                  'content' => function( $member )
                {
                    return "<b>{$member->date_end}</b>";
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
