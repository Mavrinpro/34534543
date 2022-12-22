<?php

use common\models\User;
use app\models\Tracking;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\SearchTracking $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
<?php
$addon = <<< HTML
<span class="input-group-text">
    <i class="fas fa-calendar-alt"></i>
</span>
HTML;
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'footerRowOptions'=>['class'=>'bg-dark'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                //label' => 'Полное имя',
                'attribute'=>'user_id',
                'value' => 'user.full_name',

                'format' => 'text',

                'filter'=>User::find()->where(['!=','status', '8'])->andWhere(['!=', 'id', 1])->select(['username', 'id'])
                    ->indexBy
                ('id')
                        ->column(),

            ],

            [

                //'autocomplete'=> false,
                'attribute' => 'date_at',
                'filterInputOptions' => [
                    'autocomplete' => 'off'
                ],
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', $model->date_at);
                },
                //'model' => $searchModel,
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'name' => 'Deals[date_create]',
                    'model'=>$searchModel,

                    'attribute'=>'date_at',
                    'convertFormat'=>true,
                    'useWithAddon'=>false,
                    'pluginOptions'=>[
                        'timePicker'=>true,
                        //'timePickerIncrement'=>30,

                        'locale'=>[
                            'format'=>'Y-m-d H:i:s'
                        ],

                    ],
                    'options' => [
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ]


                ])

            ],
            //'date_end',
            [
                'attribute' => 'session_start',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', $model->session_start);
                }
            ],
            [
                    'label' => 'Расчет',
                'attribute' => 'yutyuyt',
                'format' => 'html',
                'value' => function($model)
                {
                    $sum = $model->session_end - $model->session_start;
                    if (isset($model->session_end)){
                        return  secToStr($sum);
                    }else{
                        return '<span class="badge badge-success badge-pill d-inline-block">Онлайн</span>';
                    }

                    //return date('d.m.Y H:i:s', $model->session_start);
                },
                'footer' => secToStr($dataProvider->query->sum('count_time')),
            ],

            [
                'attribute' => 'session_end',
                'value' => function($model)
                {
                    if (isset($model->session_end)){
                        return  date('d.m.Y H:i:s', $model->session_end);
                    }else{
                        return 'Не завершен';
                    }
                }
            ],


            [
                'class' => ActionColumn::className(),
                'template'=>'{view}{update}{check}{delete}',
                'header' =>    Html::a('Сбросить фильтр', ['index'], ['class' => 'btn btn-sm btn-outline-primary']),

                'visibleButtons' => [
                    'delete' => false,
                    'update' => false
                ],
                'buttons' => [

                    'view' => function ($url,$model, $key) {
                        return Html::a(
                            '<button class="btn btn-sm btn-success"><i class="fa-solid fa fa-eye"></i> Детально</button>',
                            $url);
                    },


                ],

            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

