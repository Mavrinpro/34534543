<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\LayoutsMail $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблон письма', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="layouts-mail-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
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
            //'mail_id',
            'text:html',
            //'img',
            //'file',
            [
              'attribute' => 'file',
                'value' => function($model){
                    if ($model->file != ''){
                        return $model->file;
                    }else{
                        return 'Не загружен';
                    }
                }
],
            //'date_create',
            [
            'attribute' => 'date_create',
            'value' => function($model){
                return date('d.m.Y H:i', strtotime($model->date_create));
            }
],
            //'date_update',
            [
            'attribute' => 'date_update',
            'value' => function($model){
        if ($model->date_update != NULL){
            return date('d.m.Y H:i', strtotime($model->date_update));
        }else{
            return 'Не производилось';
        }

            }
            ],
        ],
    ]) ?>

</div>
