<?php

use app\models\Tasks;

//use yii\helpers\VarDumper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap4\Modal;
use app\models\History;

//use kartik\date\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var app\models\Deals $service */
/** @var app\models\Deals $taska */
/** @var app\models\Deals $comment */
/** @var yii\widgets\ActiveForm $form */


//VarDumper::dump($model, $dept = 10, $highlight = true);

?>
<?php
Modal::begin([
    'title' => '<h5>Добавление задачи</h5>',
    //'toggleButton' => ['label' => 'Добавить задачу', 'class' => 'btn btn-warning'],
    //'footer' => 'Footer',
]);

echo "<div id='modalContent'></div>";

Modal::end();

// Модальное окно обновления данных

Modal::begin([

    'titleOptions' => ['class' => 'bg-success', 'title' => '<h5 class="text-center">Обновить данные</h5>'],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false, 'class' => 'efwefwef'],
    //'toggleButton' => ['label' => 'Добавить задачу', 'class' => 'btn btn-warning'],
    'closeButton' => false,
    'size' => 'modal-lg',
    'bodyOptions' => [
        'class' => 'text-center',
    ],
    'footer' => Html::a('Получить данные', ['deals/get-fake-data', 'id' => $model->id], ['class' => 'btn-block btn-lg btn btn-success']),
]);

echo "Появились новые данные. Необходимо загрузить их в форму.";

Modal::end();
$taskCount = \app\models\Tasks::find()->where(['deals_id' => $model->id])->andWhere(['status' => 1])->count();
$taskIdDeal = Tasks::find()->where(['deals_id' => $model->id])->andWhere(['status' => 1])->one();
echo $taskCount . ' ' . $model->id;
if ($taskCount == 0) { ?>

    <?= Html::a('Создать задачу', ['tasks/forma'], ['class' => 'modalButton  btn btn-success', 'data-id' => Yii::$app->request->get('id')]) ?>
<?php } else {
    ?>
    <?= Html::a('Изменить задачу', ['tasks/update', 'id' => $taskIdDeal->id], ['class' => 'modalButton  btn btn-success', 'data-id' =>
        Yii::$app->request->get('id')]) ?>
    <?= $model->id ?>

<?php } ?>
<div class="special_block mt-3">
    <?php if ($model->special == 1): ?>
    <div class="alert alert-danger mt-3 special-alert">Особенный пациент</div>
<?php endif; ?>
</div>
    <div class="deals-form">
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'g-py-15', 'data-id' => $model->id,]]); ?>
<?php $date = date('Y-m-d H:i:s'); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(\app\models\Company::find()->all(),
                'id', 'name'), ['prompt' => 'Статус...', 'disabled' => true]); ?>
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

                'data' => ArrayHelper::map(\app\models\Tags::find()->orderBy('id')->all(), 'id', 'name'),
                //['1'=>'1','2'=>2],
                'options' => [
                    'placeholder' => 'Выбрать теги ...',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id', 'name'), ['prompt' => 'Статус...']); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_filial')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->all(), 'id', 'name'), ['prompt' => 'Выберите город...']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id_operator')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'), ['prompt' => 'Ответственный...']); ?>
            <?= $form->field($model, 'date_update')->hiddenInput(['value' => $date])->label(false); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'deal_sum')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'gender')->dropDownList([1 => 'Мужской', 0 => 'Женский'], ['prompt' => 'Пол пациента...']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'deal_email')->textInput(['type' => 'email']); ?>
        </div>
        <div class="col-md-4 mt-0">

            <?php echo '<label class="control-label">Город пациента</label>'; ?>
            <?=
            Select2::widget([
                'model' => $model,
                'name' => 'region_id',
                'attribute' => 'region_id',

                'data' => ArrayHelper::map(\app\models\Region::find()->orderBy('id')->all(), 'id', 'name'),
                //['1'=>'1','2'=>2],
                'options' => [
                    'placeholder' => 'Выбрать город ...',
                    //'multiple' => true
                ],
            ]);
            ?>
            <?= $form->field($model, 'date_update')->hiddenInput(['value' => $date])->label(false); ?>
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

                'data' => ArrayHelper::map(\app\models\Services::find()->orderBy('id')->where(['company_id' =>
                    $model->company_id])->all(), 'id', 'name'),
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
            <?= $form->field($service, 'name', ['enableAjaxValidation' => true])->textInput()->label('Если услуги нет в списке'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <?= $form->field($comment, 'text')->widget(\yii\redactor\widgets\Redactor::class) ?>
        </div>


        <?= $form->field($model, 'del')->hiddenInput(['value' => 0])->label(false); ?>
        <?= Html::hiddenInput('update_form', 0); ?>

    </div>
    <div class="row">
    <div class="col-md-12 d-flex">
<?= Html::submitButton('Сохранить', ['id' => 'update_former', 'name' => 'send_deals', 'class' => 'btn btn-success', 'data-id' => $model->id]) ?>
<?php if ($model->special == 1): ?>
    <input type="checkbox" class="checkbox ml-auto" id="box_special" data-id="<?= $model->id ?>" checked/>
<?php else: ?>
    <input type="checkbox" class="checkbox ml-auto" id="box_special" data-id="<?= $model->id ?>" />
    <?php endif; ?>
    <label for="box_special">Особенный пациент</label>
    </div>
    <div class="col-md-12">
        <?php foreach ($model->comments($model->id) as $comment) {
            $userComment = \common\models\User::find()->where(['id' => $comment->user_id])->one();
            if (sizeof($model->comments($model->id)) > 0) { ?>
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left"><?= $userComment->full_name ?></span>
                        <span class="direct-chat-timestamp float-right"></span>
                        <a href="/deals/delete-comment/?id=<?= $comment->id ?>&deal_id=<?= $model->id ?>"
                           class="text-danger"><i class="fa
                            fa-trash
                            float-right
                            mr-3"></i></a>
                        <?= Html::a('<i class="fa
                            fa-trash
                            float-right
                            mr-3"></i>', ['deals/delete-comment', 'id' => $comment->id, 'deal_id' => $model->id]) ?>
                    </div>
                    <div class="direct-chat-text">
                        <?= $comment->text ?>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
    <div class="col-md-12 mt-3">
        <?php $h = History::find()->where(['deal_id' => $model->id])->all(); ?>
        <?php if (sizeof($h) > 0) { ?>
            <div class="shadow rounded-lg p-2">
                <?php
                foreach ($h as $histor) { ?>
                    <small class="d-block"><?= date('d.m.Y H:i:s', $histor->date) ?> |
                        <b>Талон:</b>
                        <?= $histor->talon_id ?>
                        <?php if ($histor->name != null) { ?>
                            (<?= $histor->name ?>)
                        <?php } ?>
                        -
                        <?= $histor->status ?>.
                        <?php if (strlen($histor->services) > 0) { ?>
                            <b>Услуги:</b> <?=
                            $histor->services
                            ?>.<?php } ?>
                        <?php if ($histor->date_service != 0) { ?>
                            <b>Дата: </b><?= date('d.m.Y', $histor->date_service) ?>.
                        <?php } ?>
                        <?php if (strlen($histor->time_service) > 0) { ?>
                            <b>Время:</b> <?=
                            $histor->time_service ?>.
                        <?php } ?>
                        <?php if (strlen($histor->doc_service) > 0) { ?>
                            <b>Врач:</b> <?= $histor->doc_service ?>.
                        <?php } ?>
                        <?php if (strlen($histor->responsible) > 0) { ?>
                            <b>Сотрудник:</b> <?= $histor->responsible ?>
                        <?php } ?>
                        <?php if (strlen($histor->message) > 0) { ?>
                            <b>Сообщ:</b> <?= $histor->message ?>
                        <?php } ?>
                    </small>
                    <hr>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    </div>
    <hr>
    <?php ActiveForm::end(); ?>

    <?php
    $taskID = \app\models\Tasks::find()->where(['deals_id' => $model->id, 'status' => 1])->one();
    $userID = \Yii::$app->getUser()->getId();
    $time = time();
    //echo $time;
    $d = strtotime($taskID->date_end);
    //echo $d;
    if ($time > $d) {
        $bg_task = 'bg-danger';
    } else {
        $bg_task = 'bg-success';
    }
    if ($taskCount == 0) { ?>
        <h3>Создать задачу</h3>

        <div class="col-md-6">
            <?php $form2 = ActiveForm::begin(); ?>
            <?= $form2->field($taska, 'name')->hiddenInput(['value' => 'задача-' . strtotime($date)])->label
            (false) ?>
            <?= $form2->field($taska, 'date_create')->hiddenInput(['value' => $date])->label(false) ?>
            <?= $form2->field($taska, 'status')->hiddenInput(['value' => true])->label(false) ?>
            <?= $form2->field($taska, 'deals_id')->hiddenInput(['value' => $model->id])->label(false) ?>
            <?= $form2->field($taska, 'user_id')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'), ['prompt' => 'Ответственный...']); ?>
            <?= $form->field($model, 'date_update')->hiddenInput(['value' => $date])->label(false); ?>

            <?= $form->field($model, 'date_update')->hiddenInput(['value' => $date])->label(false); ?>
            <?= $form2->field($taska, 'user_create_id')->hiddenInput(['value' => $userID])->label(false) ?>
            <?= $form2->field($taska, 'date_end')->widget(\kartik\date\DatePicker::class, [

                'options' => [
                    'autocomplete' => 'off',
                    'placeholder' => 'Выберите дату',
                    'data' => [
                        'picker' => 'datepicker'
                    ]
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'startDate' => 'today',
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd 23:59:59',

                ]
            ]) ?>
            <?= $form2->field($taska, 'message')->widget(\yii\redactor\widgets\Redactor::class) ?>
            <?= Html::submitButton('Создать задачу', ['name' => 'send_task', 'class' => 'btn btn-success']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    <?php } else { ?>

        <div class="row mt-3">
            <div class="col-md-12">
                <?php foreach ($model->taskForDeal($model->id) as $task) { ?>
                    <?php $taskname = explode('-', $task->name);
                    if ($taskname[0] == 'Авто') {
                        $robot = '<small><i class="fas fa-robot text-warning mr-1"></i></small>';
                    }
                    ?>
                    <div class="shadow rounded-lg d-flex mb-3 p-2 <?= $bg_task ?>">
                        <div class="d-inline">
                            <?= $robot; ?>
                            <b>Дата окончания: </b><?= date('d.m.Y', strtotime($task->date_end)) ?>
                            <b>Кому: </b><?= $model->taskUser($task->user_id)->full_name ?>
                            <?php if (isset($task->user_create_id)): ?>
                                <b>Кто поставил: </b><span
                                        class="text-warning"><?= $model->taskUser($task->user_create_id)
                                        ->full_name ?></span>
                            <?php endif ?>
                            <?= $task->message ?>
                        </div>
                        <div class="ml-auto d-inline"><?= Html::a(
                                '<i class="fas fa-times-circle btn btn-sm btn-dark"></i>',
                                ['/deals/update-task', 'id' => $task->id], [
                                //'title' => Yii::t('app', 'Закрыть задачу'),
                                'data-confirm' => Yii::t('yii', 'Удалить запись № ' . $task->id . '?'),
                                'data-method' => 'post', 'data-pjax' => '0', 'name' => 'gfdgd'
                            ]); ?></div>
                    </div>

                <?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>

    <?php
    $m = Tasks::findOne(['deals_id' => $model->id, 'status' => 1]);
    //echo $m->id;
    $this->registerJs(<<<JS
    $(function(){
        console.log($('#tasks-deals_id').attr('name'));
    // changed id to class
    $('.modalButton').on('click', function (){
        var id = $(this).data('id');
        var id_operator = $('#deals-id_operator').val();
        var v0 =$('#w0');
        console.log(id_operator);
        $.get($(this).attr('href'), function(data) {
            v0.modal('show').find('#modalContent').html(data);
            v0.find('#tasks-deals_id').val(id);
            v0.find('#tasks-user_id').val(id_operator);
          
       });
        //console.log($(this).data('id'));
    //$('#tasks-deals_id').val($(this).data('id'));
       return false;
    });
    
}); 


// Модалка при обновлении формы

// $('#update_former').on('click',function (e){
//     e.preventDefault();
//     var v1 =$('#w1');
//     //v1.modal('show').find('#modalData').html(data);
//     var id = $(this).data('id');
//     var url = '/deals/update/?id='+id
//     $.ajax({
//             url: '/deals/change-former',
//             type: 'POST',
//             data: {
//                 id: id
//             },
//             success: function(res){
//                 console.log(res);
//                 if (res === 1){
//                     v1.modal('show');
//                    
//                 }else{
//                     $('#login-form').yiiActiveForm('submitForm');
//                     //window.location = url;
//                 }
//                
//             },
//             error: function(){
//                 alert('Error!');
//             }
//         });
//     //return false; // Cancel form submitting.
// })
//$('#update_former').on('click',function (e){
//    if ($('#deals-services_id').val() == ""){
//        $('#deals-services_id').addClass('is-invalid');
//        displayMessage('Вы не указали причину обращения', 'Ошибка обновления сделки' );
//    }else{
//         $('#deals-services_id').removeClass('is-invalid');
//          $('#deals-services_id').addClass('is-valid');
//    }
//});

function displayMessage(message, title) {
        toastr.error(message, title);
        toastr.options.positionClass =  "toast-top-right";
        toastr.options.progressBar =  true;
        toastr.options.closeButton =  true;
    }

    
    // Особенный пациент
 var alert_special = $('.special_block');
    $('#box_special').change(function(){
        
	if ($(this).is(':checked')){
        box = 1;
	} else {
         box = 0;
	}
     console.log(box);   
        $.ajax({
            url: '/deals/special-pacient',
            type: 'POST',
            data: {
                modelId: $(this).data('id'),
                special: box
            },
            success: function(res){
                console.log(res);
                if (res.special == '1'){
                    alert_special.html('<div class="alert alert-danger">Особенный пациент</div>');
                   
                }else{
                   alert_special.html('');
                }
               
            },
            error: function(){
                alert('Error!');
            }
        });
    return false; // Cancel form submitting.

		
}); 
    
JS
    );