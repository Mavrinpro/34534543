<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/** @var yii\web\View $this */
/** @var app\models\Tasks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tasks-form">

    <?php

    $form = ActiveForm::begin(); ?>

    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
    <div class="col-md-4">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-md-4">
    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
        ['prompt'=>'Оператор...']) ?>
    </div>
        <div class="col-md-4">
            <label class="control-label">Телефон</label>
            <?=
            Select2::widget([
                'model' => $model,
                'name' => 'deals_id',
                'attribute' => 'deals_id',
                'data' => ArrayHelper::map(\app\models\Deals::find()->orderBy('id')->all(),'id','phone'),
                //['1'=>'1','2'=>2],
                'options' => [
                    'placeholder' => 'Номер ...',
                    //'multiple' => true,

                ],
            ]);
            ?>
            <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false) ?>
            <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

        </div>
        <div class="form-group col-12">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>