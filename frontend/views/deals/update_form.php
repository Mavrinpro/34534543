<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap4\Modal;
//use kartik\date\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var yii\widgets\ActiveForm $form */

?>
<?php
Modal::begin([
'title' => '<h5>Добавление задачи</h5>',
//'toggleButton' => ['label' => 'Добавить задачу', 'class' => 'btn btn-warning'],
//'footer' => 'Footer',
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>
<?= Html::a('Создать задачу', ['tasks/forma'], ['class' => 'modalButton  btn btn-success', 'data-id' => Yii::$app->request->get('id')]) ?>

<div class="deals-form">

    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'g-py-15']]); ?>
    <?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(\app\models\Company::find()->all(), 'id', 'name'), ['prompt' => 'Компания...']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

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
                    'multiple' => true
                ],
            ]);
            ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id', 'name'), ['prompt' => 'Статус...']); ?>
            <?= $form->field($model, 'date_update')->hiddenInput(['value' => $date])->label(false); ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'id_operator')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'), ['prompt' => 'Ответственный...']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'id_filial')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->all(), 'id', 'name'), ['prompt' => 'Выберите город...']) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_comment')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'deal_sum')->textInput(['type' => 'number']) ?>
            <p><b>Дата создания:</b> <?= date('d.m.y H:i:s', strtotime($model->date_create)) ?> <b>Дата обновления:</b>
                <?=
               $model->date_update != null ?  date('d.m.y H:i:s', strtotime($model->date_update)) :
                    "не производилось" ?></p>
            <?= $form->field($model, 'deal_email')->hiddenInput(['type' => 'email']); ?>
        </div>

        <?= $form->field($model, 'del')->hiddenInput(['value' => 0])->label(false); ?>
        <?= Html::hiddenInput('update_form', 0);?>

    </div>
    <div class="row">
        <div class="col-md-6 d-flex">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-trash"></i>', ['deals/updater', 'id' => $model->id], ['class' => ' ml-auto btn btn-danger', 'data' => ['confirm' => 'Хотите удалить эту сделку?', 'method' => 'post',],]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(<<<JS
    $(function(){
        console.log($('#tasks-deals_id').attr('name'));
    // changed id to class
    $('.modalButton').on('click', function (){
        var id = $(this).data('id');
        var id_operator = $('#deals-id_operator').val();
        console.log(id_operator);
        $.get($(this).attr('href'), function(data) {
          $('#w0').modal('show').find('#modalContent').html(data);
          $('#w0').find('#tasks-deals_id').val(id);
          $('#w0').find('#tasks-user_id').val(id_operator);
          
       });
        //console.log($(this).data('id'));
    //$('#tasks-deals_id').val($(this).data('id'));
       return false;
    });
    
}); 
JS
);
