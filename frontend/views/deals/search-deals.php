<?php

use app\models\Deals;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
//use kop\y2sp\ScrollPager;
/** @var yii\web\View $this */
/** @var frontend\models\SearchDeals $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Поиск сделок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">

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
            'name',
            'phone',
            //'id_operator',

                [
                    //label' => 'Полное имя',
                    'attribute'=>'id_operator',
                    'value' => 'us.username',
                    'format' => 'text',

// esli nujen select
                    'filter'=>\common\models\User::find()->select(['username', 'id'])->indexBy('id')->column(),

                ],

            //'tag',
            //'date_create',

            [
                    'attribute' => 'date_create',
                //'model' => $searchModel,
                'filter' => DateRangePicker::widget([
                'name' => 'Deals[date_create]',
                'model'=>$searchModel,
                'attribute'=>'date_create',
                'convertFormat'=>true,
                    //'useWithAddon'=>true,
                'pluginOptions'=>[
                    'timePicker'=>true,
                    //'timePickerIncrement'=>30,
                    'locale'=>[
                        'format'=>'Y-m-d H:i:s'
                    ]
                ]
            ])

            ],
            [
                //label' => 'Полное имя',
                'attribute'=>'tag',
                'value' => 'tegi.name',

                'format' => 'text',

                'filter'=>\app\models\Tags::find()->select(['name', 'id'])->indexBy('id')->column(),

            ],
            [
                'attribute'=>'status',
                'format' => 'html',
                'value' => function($model){
                    if($model->status == '1'){
                        return '<span class="text-success"><span class="badge badge-success bg-blue">Звонки</span></span>';
                    }else if($model->status == '2'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-purple">Думает</span></span>';
                    }else if($model->status == '3'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-olive">Записан на прием</span></span>';
                    }
                    else if($model->status == '4'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-pink">Отказ</span></span>';
                    }
                    else if($model->status == '5'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-success">Информ звонок</span></span>';
                    }
                    else if($model->status == '6'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-gray">Без тегов</span></span>';
                    }
                },
                'filter'=>array("1"=>"Звонки","2"=>"Думает", "3" => "Записан на прием", "4" => "Отказ", "5" => "Информ звонок", "6" => "Без тегов" ),
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
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>