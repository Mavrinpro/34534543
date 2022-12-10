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

<?php $form = ActiveForm::begin() ?>
<div class="col-md-6">
<?= $form->field($model, 'password')->passwordInput(['maxlength'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class'=>'btn btn-success']) ?>
        <?= Html::a('Назад', ['index'], ['class'=>'btn btn-warning']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>