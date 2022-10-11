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
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'g-py-15'], 'errorCssClass' => 'text-danger', 'successCssClass' => 'text-success',]); ?>
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
            <?= $form->field($model, 'tag')->dropDownList(ArrayHelper::map(\app\models\Tags::find()->all(), 'id', 'name'), ['prompt' => 'Теги...']) ?>
            <!--            --><? //= $form->field($model, 'tag')->widget(\kartik\select2\Select2::classname(), [
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
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id', 'name'), ['prompt' => 'Статус...']); ?>
            <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false); ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'id_operator')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'), ['prompt' => 'Ответственный...']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'id_filial')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->all(), 'id', 'name'), ['prompt' => 'Выберите город...']) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_comment')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'deal_sum')->textInput(['type' => 'number']) ?>
        </div>

        <?= $form->field($model, 'del')->hiddenInput(['value' => 0])->label(false); ?>
        <?= Html::hiddenInput('update_form', 0);?>

    </div>
    <div class="row">
        <div class="col-md-6 d-flex">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-trash"></i>', ['deals/updater', 'id' => $model->id], ['class' => ' ml-auto btn btn-danger', 'data' => ['confirm' => 'Хотите удалить эту сделку?', 'method' => 'post',],]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
