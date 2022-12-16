<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tracking $model */

$this->title = 'Рабочее время за '.date('d.m.Y',$model->date_at);
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branch-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.full_name',
            [
                'label' => 'Расчет',
                'attribute' => 'yutyuyt',
                'value' => function($model)
                {
                    $sum = $model->session_end - $model->session_start;
                    if (isset($model->session_end)){
                        return  secToStr($sum);
                    }else{
                        return 'Сотрудник в работе';
                    }

                    //return date('d.m.Y H:i:s', $model->session_start);
                },

            ],

        ],
    ]) ?>

</div>

