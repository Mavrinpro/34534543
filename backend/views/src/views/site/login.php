<?php
//use yii\helpers\Html;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg text-white text-center">Войдите в систему</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model,'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
<!--            <div class="col-8">-->
<!--                --><?//= $form->field($model, 'rememberMe')->checkbox([
//                    'template' => '<div class="icheck-primary">{input}{label}</div>',
//                    'labelOptions' => [
//                        'class' => ''
//                    ],
//                    'uncheck' => null
//                ]) ?>
<!--            </div>-->
            <div class="col-12">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-warning btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

<!--        <div class="social-auth-links text-center mb-3">-->
<!--            <p>- OR -</p>-->
<!--            <a href="#" class="btn btn-block btn-primary">-->
<!--                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook-->
<!--            </a>-->
<!--            <a href="#" class="btn btn-block btn-danger">-->
<!--                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+-->
<!--            </a>-->
<!--        </div>-->
        <!-- /.social-auth-links -->

<!--        <p class="mb-1">-->
<!--            <a href="forgot-password.html">I forgot my password</a>-->
<!--        </p>-->
<!--        <p class="mb-0">-->
<!--            <a href="register.html" class="text-center">Register a new membership</a>-->
<!--        </p>-->
    </div>
    <!-- /.login-card-body -->
</div>

<?php
$css = <<<CSS
body{
    background-image: linear-gradient(358deg, rgb(0 0 0 / 58%), rgb(5 5 5 / 61%)), url(/img/eye.jpg);
    background-size: cover;
    background-repeat: no-repeat;
}
.card{
background-color: rgb(255 255 255 / 15%);
    box-shadow: 0 0 47px -22px #000;
}

CSS;
$this->registerCss($css);

