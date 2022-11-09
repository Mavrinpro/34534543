<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
/** @var yii\web\View $this */
/** @var app\models\Reviews $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $date = date('Y-m-d H:i:s'); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_doc')->dropDownList(ArrayHelper::map(\app\models\Doctors::find()->all(), 'id', 'name'), ['prompt'=>'Выберите врача...']
    ) ?>

    <?= $form->field($model, 'review')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'date_create')->textInput(['value' => $date]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
