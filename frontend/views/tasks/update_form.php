<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\jui\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\Tasks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tasks-form">

    <?php

    $form = ActiveForm::begin(); ?>

    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
        <div class="col-md-12">

            <?= $form->field($model, 'date_end')->widget(\kartik\date\DatePicker::className(),[

                'options' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Выберите дату',
                    'data' => [
                        'picker' => 'datepicker'
                    ]
                ],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'startDate' => 'today',
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd 23:59:59',

                ]
            ]) ?>
        </div>
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

        <div id="memberssearch-family_name_id"></div>

        <?= $form->field($model, 'deals_id')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'name')->hiddenInput(['value' => 'задача-'.strtotime($date)])->label
            (false) ?>
            <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false) ?>
            <?= $form->field($model, 'status')->hiddenInput(['value' => true])->label(false) ?>
        <?= $form->field($model, 'message')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        <div class="form-group col-12">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>