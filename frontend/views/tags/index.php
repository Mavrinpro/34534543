<?php

use app\models\Tags;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\TagSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    --><?//= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            //['class' => 'yii\grid\SerialColumn'],
//
//            //'id',
//            'name',
//            [
//                'class' => ActionColumn::className(),
//                'header' =>    Html::a('Сбросить фильтр', ['tags/index'], ['class' => 'btn btn-sm btn-outline-primary']),
//                'visibleButtons' => [
//
//                    'delete' => function ($model) {
//                        return \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin';
//                    },
//                ],
//                'buttons' => [
//                    'update' => function ($url,$model, $key) {
//                        return Html::a(
//                            '<i class="fa-solid fa fa-edit btn btn-sm btn-warning"></i>',
//                            $url);
//                    },
//                    'view' => function ($url,$model, $key) {
//                        return Html::a(
//                            '<i class="fa-solid fa fa-eye btn btn-sm btn-success"></i>',
//                            $url);
//                    },
//                    'delete' => function ($url,$model, $key) {
//                        return Html::a(
//                            '<i class="fa fa-trash-alt btn btn-sm btn-danger"></i>',
//                            $url,[
//                            //'title' => Yii::t('app', 'Delete'),
//                            'data-confirm' => Yii::t('yii', 'Удалить запись № '.$key.'?'),
//                            'data-method' => 'post', 'data-pjax' => '1',
//                        ]);
//                    },
//
//
//                ],
//            ],
//        ],
//    ]);
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_taglist',
        'layout' => '{items}<div class="mt-2"> {pager}</div>',
        'emptyText' => '',
        'options' => [
            'tag' => 'div',
            'class' => 'row',
            'id' => 'news-list',
        ],
    ]);

    ?>

    <?php Pjax::end(); ?>

</div>
