<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\Droppable;
use yii\web\UploadedFile;
use yii\redactor\models\FileUploadModel;

/** @var yii\web\View $this */
/** @var app\models\LayoutsMail $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $date = date('Y-m-d H:i:s'); ?>
<div class="layouts-mail-form">
<?= Yii::$app->controller->action->id; ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mail_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'text')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'img')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'file')->fileInput(['maxlength' => true]) ?>
<?php
if (Yii::$app->controller->action->id == 'create'){ ?>
    <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php }else{ ?>

    <?= $form->field($model, 'date_update')->hiddenInput(['value' => $date])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    </div>
<?php } ?>


    <?php ActiveForm::end(); ?>

</div>
