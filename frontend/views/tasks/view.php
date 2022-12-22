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
            'deals.phone',
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
            [
                    'attribute' => 'status',
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
            ]
        ],
    ]) ?>

</div>
