<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Deals $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Детально', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-6">
        <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/deals/', ['class' => 'btn btn-warning']) ?>
    </div>
    <div class="col-md-6">
        <h3>Отправить письмо</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-5 mt-3">
        <div class="shadow p-3 rounded-lg">
            <?php $adress = \app\models\Branch::findOne(['id' => $model->id_filial])?>
            <?php $status = \app\models\Statuses::findOne(['id' => $model->status])?>
            <?php $tags = \app\models\Tags::find()->where(['id' => explode(',',$model->tag)])->all()?>

            <b>ID:</b> <?= $model->id ?>
            <hr>
            <b>Название: </b><?= $model->name ?>
            <hr>
            <b>Телефон:</b> <?= $model->phone ?>
            <hr>
            <b>Теги:</b> <?php foreach ($tags as $tag){
                echo '<div class="deal_tag badge badge-pill badge-light d-inline-block border">'.$tag['name']
               .'</div>';
            } ?>
            <hr>
            <b>Филиал:</b> <?= $adress->name ?>
            <hr>
            <b>Дата:</b> <?= date('d.m.Y' ,strtotime($model->date_create)) ?>
            <hr>
            <b>Статус:</b> <?= $status->name ?>
            <?= isset($model->deal_sum) ? '<hr><b>Сумма сделки: </b>'.$model->deal_sum .' ₽' : '' ?>
            <hr>
            <b>Комментарий:</b> <?= $model->id_comment ?>
            <hr>
            <b><div class="mb-3">Запись звонка: <audio controls="">
                        <source src="https://sipuni.com/api/crm/record?id=1666940852.1574544&amp;hash=a1c8c33d711c3f5cdfd28f4f06fd51cd&amp;user=060863" type="audio/ogg; codecs=vorbis">
                        <source src="https://sipuni.com/api/crm/record?id=1666940852.1574544&amp;hash=a1c8c33d711c3f5cdfd28f4f06fd51cd&amp;user=060863" type="audio/mpeg">
                        Тег audio не поддерживается вашим браузером.
                        <a href="https://sipuni.com/api/crm/record?id=1666940852.1574544&amp;hash=a1c8c33d711c3f5cdfd28f4f06fd51cd&amp;user=060863">Скачайте музыку</a>.
                    </audio></div></b>

        </div>
    </div>
    <div class="col-md-6 mb-5 mt-3">
        <div class="shadow p-3 rounded-lg">
            haerhaer
        </div>

    </div>
</div>
<!--<div class="deals-view">-->
<!---->
<!--    <p>-->
<!--        --><?//= Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary
//        btn-sm']) ?>
<!--        --><?//= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger btn-sm',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--        --><?//= Html::a('Все', '/deals/', ['class' => 'btn btn-warning btn-sm']) ?>
<!--    </p>-->
<!--    --><?php
//    echo '<pre>';
//   // print_r($model);
//    ?>
<!---->
<!--    --><?php //$adress = \app\models\Branch::findOne(['id' => $model->id_filial])?>
<!--    --><?php //$status = \app\models\Statuses::findOne(['id' => $model->status])?>
<!--Название: --><?//= $model->name ?><!--<br>-->
<!--ID: --><?//= $model->id ?><!--<br>-->
<!--Телефон: --><?//= $model->phone ?><!--<br>-->
<!--Теги: --><?//= $model->getTags($model)->name ?><!--<br>-->
<!--Филиал: --><?//= $adress->name ?><!--<br>-->
<!--Дата: --><?//= date('d.m.Y' ,strtotime($model->date_create)) ?><!--<br>-->
<?//= $status->name ?><!--<br>-->
<!---->
<!--    <div class="col-md-4 col-sm-6 col-12">-->
<!--        --><?//= \hail812\adminlte\widgets\InfoBox::widget([
//            'text' => $model->name ,
//            'number' => $model->phone,
//            //'icon' => 'far fa-bookmark',
//            'progress' => [
//                'width' => '70%',
//                'description' => '70% Increase in 30 Days',
//                'egerger' => 'aergaer'
//            ]
//        ]) ?>
<!--    </div>-->
<!---->
<!---->
<!--    --><?//= DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'name',
//            'phone',
//            'tag',
//            'date_create',
//            [
//                'attribute' => 'status',
//                'value' => $status->name
//            ],
//            'id_operator',
//            'id_filial',
//            'id_comment',
//        ],
//    ]) ?>
<!---->
<!--</div>-->
