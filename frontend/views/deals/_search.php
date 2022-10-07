<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\SearchDeals $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="deals-search">
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get',]); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'phone') ?>
        </div>
            <div class="col-md-2">
                <?= $form->field($model, 'tag') ?>
            </div>
        <div class="col-md-2">
        <?= $form->field($model, 'date_create') ?>
        </div>
</div>
        <?php // echo $form->field($model, 'status') ?>

        <?php // echo $form->field($model, 'id_operator') ?>

        <?php // echo $form->field($model, 'id_filial') ?>

        <?php // echo $form->field($model, 'id_comment') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
