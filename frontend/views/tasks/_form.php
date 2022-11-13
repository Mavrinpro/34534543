<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
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
        <div id="memberssearch-family_name_id"></div>
        <div class="col-md-4">
            <label class="control-label">Телефон</label>
            <?php
//            Select2::widget([
//                'model' => $model,
//                'name' => 'deals_id',
//                'attribute' => 'deals_id',
//                'data' => ArrayHelper::map(\app\models\Deals::find()->where(date('d.m.y', strtotime('date_create')) === date( 'd.m.y')-2)->orderBy(['date_create' => SORT_DESC])->limit(1000)->all(),'id','phone'),
//                //['1'=>'1','2'=>2],
//                'options' => [
//                    'placeholder' => 'Номер ...',
//                    //'multiple' => true,
//                    'autocomplete' => 'off'
//
//                ],
//
//            ]);


            //фомируем список
            $listdata=\app\models\Deals::find()
                ->select(['phone as value', 'phone as label'])
                ->asArray()
                ->all();


            echo AutoComplete::widget([
                    'name' => 'deals_id',
                'clientOptions' => [
                    'source' => $listdata,
                    'minLength'=>'3',
                    'autoFill'=>true,
                    //'class' => 'form-control',
                    'select' => new JsExpression("function( event, ui ) {
			        $('#memberssearch-family_name_id').val(ui.item.id);//#memberssearch-family_name_id is the id of hiddenInput.
			     }")],
                'options'=>[
                    'class'=>'form-control',
                ]
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