<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
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
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            [
              'attribute' => 'status',
                'format' => 'html',
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
            //'created_at',
            [
                'attribute' => 'created_at',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', ($model->created_at));
                }
            ],
            //'updated_at',
            [
                'attribute' => 'updated_at',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', ($model->updated_at));
                }
            ],
            //'verification_token',
        ],
    ]) ?>

</div>
