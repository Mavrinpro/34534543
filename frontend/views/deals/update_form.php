<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="deals-form">
    <?php yii\widgets\Pjax::begin() ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'g-py-15', 'data-pjax' => true],
        'errorCssClass' => 'text-danger',
        'successCssClass' => 'text-success',
    ]); ?>
    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?
            echo $form->field($model, 'tag')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\Tags::find()->all(), 'id', 'name'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Select a state ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

            ?>
            <!--            --><?//= $form->field($model, 'tag')->widget(\kartik\select2\Select2::classname(), [
            //                'data' => ArrayHelper::map(\app\models\Tags::find()->all(), 'id', 'name'),
            //                'options' => ['placeholder' => 'Select a state ...', 'multiple' => true],
            //                'pluginOptions' => [
            //                    'allowClear' => true
            //                ],
            //            ]); ?>
            <?php
            //echo '<label class="control-label">Теги</label>';
            //            echo \kartik\select2\Select2::widget([
            //                'name' => 'tag',
            //                 'hideSearch' => true,
            //                'data' => ArrayHelper::map(\app\models\Tags::find()->all(), 'id', 'name'),
            //                'size' => \kartik\select2\Select2::THEME_KRAJEE,
            //                'options' => ['placeholder' => 'Select a state ...', 'multiple' => true, 'autocomplete' => 'off'],
            //                'pluginOptions' => [
            //                    'allowClear' => true
            //                ],
            //            ])
            ?>
        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'date_create')->textInput(['value' => $date]) ?>
        </div></div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id', 'name'),
                ['prompt'=>'Статус...']); ?>
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'id_operator')->textInput() ?>
        </div></div>

    <?= $form->field($model, 'id_filial')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->all(), 'id', 'name'),
        ['prompt'=>'Выберите город...']
    ) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_comment')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'deal_sum')->textInput(['type'=>'number']) ?>
        </div></div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Yii\widgets\Pjax::end(); ?>
</div>
