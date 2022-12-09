<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

// Проверка на использование экшена
//echo Yii::$app->controller->action->id;
?>

<div class="user-form col-md-5">

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'status')->dropdownList([10 => 'Активный', 9 => 'Неактивный']) ?>


    <?= $form->field($model, 'email') ?>
<?php if (Yii::$app->controller->action->id == 'create'){  ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?php } ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id == 'create'){  ?>
        <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-success', 'name' => 'signup-button']); ?>
        <?php }else{
            echo Html::submitButton('Изменить', ['class' => 'btn btn-success', 'name' => 'signup-button']);
        } ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
