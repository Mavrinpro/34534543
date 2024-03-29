<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var app\models\Deals $service */
/** @var app\models\Deals $comment */
/** @var yii\widgets\ActiveForm $form */

$userID = \common\models\User::find()->where(['id' => Yii::$app->getUser()->id])->one();
//echo $userID->id;
?>

<div class="deals-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
    <div class="col-md-4">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->widget(MaskedInput::class, ['mask' => '+7 (999)-999-99-99','clientOptions' => [
                'removeMaskOnSubmit' => true,
            ]]) ?>
        </div>
        <div class="col-md-4">
    <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(\app\models\Company::find()->all(), 'id', 'name'),
        ['prompt'=>'Компания...', 'value' => $userID->company_id,]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
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

        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id', 'name'),
                ['prompt'=>'Статус...', 'value' => 3]); // при создании статус Записан на прием по умолчанию ?>
    <?= $form->field($model, 'date_create')->hiddenInput(['value' => $date])->label(false); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_filial')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->all(), 'id', 'name'),
                ['prompt'=>'Выберите город...']
            ) ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4">
    <?= $form->field($model, 'id_operator')->dropDownList(ArrayHelper::map
    (\common\models\User::find()->all(), 'id', 'username'),
        ['prompt'=>'Ответственный...', 'value' => Yii::$app->user->getId()]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'deal_sum')->textInput(['type'=>'number']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'gender')->dropDownList([1 => 'Мужской', 0 => 'Женский'],['prompt'=>'Пол пациента...'])
            ; ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'deal_email')->textInput() ?>
        </div>
        <div class="col-md-4">
                <?php echo '<label class="control-label">Город пациента</label>'; ?>
                <?=
                Select2::widget([
                    'model' => $model,
                    'name' => 'region_id',
                    'attribute' => 'region_id',
                    'data' => ArrayHelper::map(\app\models\Region::find()->orderBy('id')->all(),'id','name'),
                    //['1'=>'1','2'=>2],
                    'options' => [
                        'placeholder' => 'Выбрать город ...',

                        //'multiple' => true
                    ],
                ]);
                ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'age')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?php echo '<label>Причина обращения</label>'; ?>
            <?=
            Select2::widget([
                'model' => $model,
                'name' => 'services_id',
                'attribute' => 'services_id',


                'data' => ArrayHelper::map(\app\models\Services::find()->where(['company_id' => $userID->company_id])->orderBy('id')
                    ->all(),
                    'id','name'),
                //['1'=>'1','2'=>2],
                'options' => [
                    'placeholder' => 'Услуга ...',
                    //'multiple' => true
                ],
                'pluginOptions' => ['allowClear' => true]
            ]);

            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($service, 'name')->textInput()->label('Если услуги нет в списке'); ?>
        </div>
        <div class="col-md-12">
    <?= $form->field($comment, 'text')->widget(\yii\redactor\widgets\Redactor::class) ?>
        </div>
        <div class="col-md-6">

        </div>

            <?= $form->field($model, 'del')->hiddenInput(['value' => 0])->label(false); ?>
            <?= $form->field($model, 'create_form')->hiddenInput(['value' => 0])->label(false); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
