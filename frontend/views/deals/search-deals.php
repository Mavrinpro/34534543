<?php

use app\models\Deals;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
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
            //'tag',
            //'date_create',
            [
                //label' => 'Полное имя',
                'attribute'=>'tag',
                'value' => function($model)
                {

                        if ($model->tag != "")
                        {
                            return 'Теги';
                        }else{
                            return 'нет тегов';
                        }

                },
                'format' => 'text',

// esli nujen select
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