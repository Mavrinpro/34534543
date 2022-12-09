<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация нового пользователя';
$this->params['breadcrumbs'][] = $this->title;
echo Yii::$app->controller->action->id;
?>

<div class="user-form col-md-5">

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>
<?php if (Yii::$app->controller->action->id == 'create'){  ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
