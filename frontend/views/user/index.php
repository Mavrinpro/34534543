<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\SearchUsers $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid)
        {
            if($model->status == 10) {
                return ['style' => 'background-color:#b5e9b7;'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            'full_name',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            [
                'attribute' => 'status',
                'format' => 'html',
                'filter'=>array("10"=>"Активный","9"=>"Не активный"),
                'value'=> function($model)
                {
                    if ($model->status == 10)
                    {
                        return '<span class="badge badge-success">Активный</span>';
                    }else if($model->status == 9)
                    {
                        return '<span class="badge badge-danger">Не активный</span>';
                    }else{
                        return '<span class="badge badge-danger bg-gray">Удален</span>';
                    }

                },
            ],

            [
                'attribute' => 'role',
                'format' => 'html',
                'value' => function($model)
                {
                    if (\Yii::$app->authManager->getRolesByUser($model->id)['superadmin']->name == 'superadmin')
                    {
                        return '<b class="text-danger">Суперадмин</b>';
                    }else if(\Yii::$app->authManager->getRolesByUser($model->id)['admin']->name == 'admin'){
                        return '<b class="text-danger">Администратор</b>';
                    }else{
                        return '<span class="text-gray">Пользователь</span>';
                    }
                }
            ],
            [
              'attribute' => 'active',
              'value' => function($model){
                  $tracking = new \app\models\Tracking();
                  if ($tracking->userOnline($model->id)->work == true){
                      return '<span class="badge badge-success badge-pill d-inline-block">Онлайн</span>';
                  }else{
                      return '<span class="badge badge-secondary badge-pill d-inline-block">Не в сети</span>';
                  }
              },
                'format' => 'html',
                'filter'=>array(true =>"Активный", false => "Не активный"),
                'label' => 'Работа'
            ],
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'template'=>'{view}{update}{check}{delete}',
                'header' =>    Html::a('Сбросить фильтр', ['index'], ['class' => 'btn btn-sm btn-outline-primary']),
                //Видимость кнопок по ролям пользователей
//                'visibleButtons' => [
//
//                    'delete' => function ($model) {
//                        return \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin';
//                    },
//                    'check' => function ($model) {
//                        return \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin';
//                    },
//
//                ],
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
                    'check' => function ($url, $model) {
                        return Html::a('<i class="btn btn-sm btn-secondary mr-2"><i class="fas fa-lock"></i></i>', ['user/change-password', 'id' => $model->id]);
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
