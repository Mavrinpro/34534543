<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Services $model */
/** @var yii\widgets\ActiveForm $form */
?>



    <?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-md-6">
    <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(\app\models\Company::find()->all(), 'id', 'name')
        , ['prompt'=>'Выберите компанию...']
    ) ?>
    </div>
        <div class="col-md-6">
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
</div>
    <?php ActiveForm::end(); ?>


