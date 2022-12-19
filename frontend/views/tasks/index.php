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
            'name',
            'deals.phone',

            [
                //label' => 'Полное имя',
                'attribute'=>'user_id',
                'value' => 'user.username',
                'format' => 'text',
                'visible' => \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin',

// esli nujen select
                'filter'=>\common\models\User::find()->select(['username', 'id'])->where(['!=', 'status', 8])->indexBy
                ('id')
                    ->column(),

            ],
            [
                'attribute'=>'status',
                'format' => 'html',
               'value' => function($model){
                         if(date('Y-m-d H:i:s', strtotime($model->date_end)) > date('Y-m-d H:i:s')){
                            return '<span class="text-success"><span class="badge badge-success">Активная</span></span>';
                         }else if(date('Y-m-d H:i:s', strtotime($model->date_end)) < date('Y-m-d H:i:s')){
                             return '<span class="text-danger"><span class="badge badge-danger">Просроченная</span></span>';
                         }else{
                             return '<span class="text-gray">Не определена</span>';
                         }
                       },
                'filter'=>   ['1' => 'Актывные', '2' => 'Просроченные'],
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
                'template'=>'{view}{update}{check}{updater}',
                'header' =>    Html::a('Сбросить фильтр', ['index'], ['class' => 'btn btn-sm btn-outline-primary']),
                'visibleButtons' => [

                    'delete' => function ($model) {
                        return \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin';
                    },
                ],
                'buttons' => [

                    'update' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-edit btn btn-sm btn-warning mr-2"></i>',
                            $url);
                    },
                    'view' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-eye btn btn-sm btn-success mr-2"></i>',
                            $url);
                    },
//                    'delete' => function ($url,$model, $key) {
//                        return Html::a(
//                            '<i class="fa fa-trash-alt btn btn-sm btn-danger"></i>',
//                            $url,[
//                            //'title' => Yii::t('app', 'Delete'),
//                            'data-confirm' => Yii::t('yii', 'Удалить запись № '.$key.'?'),
//                            'data-method' => 'post', 'data-pjax' => '1',
//                        ]);
//                    },

                    'updater' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fas fa-times-circle btn btn-sm btn-danger"></i>',
                            ['tasks/updater', 'id' => $model->id],[
                            //'title' => Yii::t('app', 'Закрыть задачу'),
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
