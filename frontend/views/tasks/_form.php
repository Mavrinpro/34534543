<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
/** @var yii\web\View $this */
/** @var app\models\Tasks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tasks-form">

    <?php

    $form = ActiveForm::begin(); ?>
    
    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-md-6">
    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
        ['prompt'=>'Оператор...']) ?>
    </div>
    <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false) ?>

<!--    --><?//= $form->field($model, 'date_update')->textInput() ?>

    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>