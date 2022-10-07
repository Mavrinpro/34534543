<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
/** @var yii\web\View $this */
/** @var app\models\Doctors $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="doctors-form">
    <?php $date = date('Y-m-d h:i:s'); ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work_experience')->textInput() ?>

    <?= $form->field($model, 'treated_patients')->textInput() ?>

    <?= $form->field($model, 'photo')->fileInput() ?>

    <?= $form->field($model, 'specialization_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'about_doc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sertificates')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'education')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_create')->textInput(['value' => $date]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
