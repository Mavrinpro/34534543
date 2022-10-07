<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Doctors $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="doctors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/doctors/', ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'last_name',
            'first_name',
            'specialization',
            'work_experience',
            'treated_patients',
            'photo',
            'specialization_text:ntext',
            'about_doc:ntext',
            'sertificates:ntext',
            'education:ntext',
            'date_create',
            [
                'attribute'=>'photo',
                'label'=>'Фото',
                'format'=>'raw',
                'value' => Html::img('/uploads/'.$model->photo,['style'=>'width: 50px; height: 50px']),
            ],
        ],

    ]) ?>

</div>
