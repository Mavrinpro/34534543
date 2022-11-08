<?php

use app\models\Reviews;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Отзывы врачей';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reviews-index">

    <p>
        <?= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $posts = $dataProvider->getModels(); ?>
<div class="row">
    <?php
    foreach ($posts as $post) { ?>
        <div class="col-md-2 mb-2">
            <div class="rounded shadow-sm p-2 bordered">
                <div><?=$post->name ?></div>
                <span class="mt-2"><?=$post->phone ?></span>
            </div>

        </div>
    <?php

    }
 ?>
</div>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            'phone',
            'number_card',
            'id_doc',
            'review:html',
            //'date_create',
            [
                'attribute' => 'date_create',
                'format' => ['date', 'dd.MM.yyyy H:i']
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
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

                'urlCreator' => function ($action, Reviews $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }

            ],

        ],
    ]);
?>

    <?php Pjax::end(); ?>

</div>
