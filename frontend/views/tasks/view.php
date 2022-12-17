<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tasks-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-times-circle"></i>', ['tasks/updater', 'id' => $model->id, 'updater' => 'yes'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'user.full_name',
            'date_create',
            //'date_end',
            [
                'attribute' =>'date_end',
                'label' => 'Дата окончания',
                'value' => function($model){
                    return $model->date_end;
                }
            ],
            'status',
        ],
    ]) ?>

</div>
