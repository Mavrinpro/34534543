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
        <div class="col-md-4">

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
        <?php if (\Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())
            ['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()
                ->identity->getId())['admin']->name == 'admin'){ ?>
            <div class="col-md-4">

                <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
                    ['prompt'=>'Оператор...', 'value' => Yii::$app->user->getId()]) ?>
            </div>
        <?php }else{ ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>
        <?php } ?>

        <div id="memberssearch-family_name_id"></div>
        <div class="col-md-4">

            <?php
            //формируем список
            $listdata=\app\models\Deals::find()
                ->select(['id as value', 'phone as label', 'id as id'])
                ->asArray()
                ->all();

            echo $form->field($model, 'deals_id')->widget(AutoComplete::class, [
                'name' => 'deals_id',
                'id' => 'deals_id',
                'value' => $model->id,
                'clientOptions' => [
                    'source' => $listdata,
                    'minLength'=>'3',
                    'limit'=>'10',
                    'select' => new JsExpression("function( event, ui ) {
    $('#model-pedigrees_id').val(ui.item.id);
    }")],

                'options'=>[
                    'class'=>'form-control'

                ],
            ]);



            ?>

            <?php if (Yii::$app->controller->action->id == 'create'){ ?>
                <?= $form->field($model, 'name')->hiddenInput(['value' => 'задача-'.strtotime($date)])->label
                (false) ?>
            <?php }else{ ?>
                <?= $form->field($model, 'name')->hiddenInput()->label
                (false) ?>
            <?php } ?>
            <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false) ?>
            <?= $form->field($model, 'status')->hiddenInput(['value' => true])->label(false) ?>
            <?= $form->field($model, 'message')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
        <div class="form-group col-12">
            <?php if (Yii::$app->controller->action->id == 'create'){ ?>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            <?php }else{ ?>
                <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
            <?php } ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
