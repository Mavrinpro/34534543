<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="deals-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>

    <div class="col-md-6">
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->widget(MaskedInput::class, ['mask' => '+7 (999)-999-99-99','clientOptions' => [
        'removeMaskOnSubmit' => true,
    ]]) ?>
    </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <?php
            echo '<label class="control-label">Теги</label>'; ?>
            <?=
             Select2::widget([
                'model' => $model,
                'name' => 'tag',
                'attribute' => 'tag',
                'data' => ArrayHelper::map(\app\models\Tags::find()->orderBy('id')->all(),'id','name'),
                 //['1'=>'1','2'=>2],
                'options' => [
                    'placeholder' => 'Выбрать теги ...',
                    'multiple' => true,
                    'theme'=>Select2::THEME_BOOTSTRAP
                ],
            ]);
            ?>

        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id', 'name'),
                ['prompt'=>'Статус...', 'value' => 3]); // при создании статус Записан на прием по умолчанию ?>
    <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false); ?>
        </div></div>
    <div class="row">

        <div class="col-md-6">

    <?= $form->field($model, 'id_operator')->dropDownList(ArrayHelper::map
    (\common\models\User::find()->all(), 'id', 'username'),
        ['prompt'=>'Ответственный...', 'value' => Yii::$app->user->getId()]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'id_filial')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->all(), 'id', 'name'),
                ['prompt'=>'Выберите город...']
            ) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'id_comment')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'deal_sum')->textInput(['type'=>'number']) ?>
    <?= $form->field($model, 'deal_email')->textInput() ?>
        </div>

            <?= $form->field($model, 'del')->hiddenInput(['value' => 0])->label(false); ?>
            <?= $form->field($model, 'create_form')->hiddenInput(['value' => 0])->label(false); ?>


    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
