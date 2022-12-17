<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \frontend\models\SignupForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

// Проверка на использование экшена
//echo Yii::$app->controller->action->id;
?>



<?php $form = ActiveForm::begin(['id' => 'form-signup',
]); ?>
<div class="row">
    <div class="user-form col-md-6">
        <div class="form-group">
            <?php if (Yii::$app->controller->action->id == 'create'){ ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?php }else{ ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?php } ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'full_name')->textInput(['autofocus' => true]) ?>
        </div>
    </div>
    <div class="col-md-6">
        <?php if (Yii::$app->controller->action->id == 'create'){ ?>
            <?= $form->field($model, 'status',  [
                'options' => [
                    'tag' => false,
                ],
            ])->hiddenInput(['value' => 10, 'class' => false])->label(false) ?>
        <?php }else{ ?>

            <div class="form-group">
                <?= $form->field($model, 'status')->dropdownList([10 => 'Активный', 9 => 'Неактивный']); ?>
            </div>
            <?php } ?>
            <div class="form-group">
                <?= $form->field($model, 'email') ?>
            </div>
            <?php if (Yii::$app->controller->action->id == 'create') { ?>
                <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
            <?php } ?>
        </div>
        <div class=" col-md-6">
            <div class="form-group">
                <?php if (Yii::$app->controller->action->id == 'create') { ?>
                    <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-success', 'name' => 'signup-button']); ?>
                <?php } else {
                    echo Html::submitButton('Изменить', ['class' => 'btn btn-success', 'name' => 'signup-button']);
                } ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>


    </div>
