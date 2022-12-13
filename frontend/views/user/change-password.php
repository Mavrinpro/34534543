<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

/** @var \frontend\models\SignupForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Изменить пароль пользователя';
$this->params['breadcrumbs'][] = ['label'=>'Пользователи', 'url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert alert-danger">Выбирайте сложный пароль! Это важно!</div>
<?php $form = ActiveForm::begin() ?>
<div class="col-md-6">
<?= $form->field($model, 'password')->passwordInput(['maxlength'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class'=>'btn btn-success']) ?>
        <?php if (\Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin'){ ?>
            <?= Html::a('Назад', ['index'], ['class'=>'btn btn-warning']) ?>
       <?php } ?>

    </div>
</div>
<?php ActiveForm::end() ?>
<div class="row">
<div class="col-md-12">
    <iframe src="https://serblog.ru/demo/password-generator/" frameborder="0" height="800px" width="100%"></iframe>
</div>
</div>