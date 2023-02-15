<?php

use app\models\Deals;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\widgets\Alert;
use app\models\DealsRepeat;
use app\models\History;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var app\models\DealsRepeat $repeat */
/** @var app\models\History $history */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Детально', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <audio controls muted>
        <source src="https://sipuni.com/api/crm/record?id=1673105413.778577&hash=20695eb6be6d359dd4a58bfef0e7830d&user=060863" type="audio/ogg">
        <source src="https://sipuni.com/api/crm/record?id=1673105413.778577&hash=20695eb6be6d359dd4a58bfef0e7830d&user=060863" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div class="col-md-6">
        <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>', ['deals/updater', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Хотите удалить сделку № '.$model->id.'?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/deals/', ['class' => 'btn btn-warning']) ?>
    </div>
    <div class="col-md-6">
        <h3>Отправить письмо</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-5 mt-3">
        <div class="shadow p-3 rounded-lg">
            <?= DetailView::widget([
                'model' => $model,
                'template' => '<b> {label}</b> - {value}</div><hr>',
                'attributes' => [
                    'id',
                    'name',
                    'phone',
                    'company.name',
//                    [
//                         'attribute' => 'del',
//                        'format' => 'html',
//                        'value' => function($model){
//                            if ($model->del == 0){
//                                return '<i class="fas fa-unlock text-success" title="Активная"></i>';
//                            }else{
//                                return '<i class="fas fa-ban text-danger" title="Удалена"></i>';
//                            }
//                        }
//                    ],
                    [
                        'attribute' => 'tag',
                        'format' => 'html',
                        'value' => function($model)
                        {
                            $tag = \app\models\Tags::find()->where(['id' => explode(',',$model->tag)])->all();

                            foreach ($tag as $t)
                            {
                                // Вывод списка тегов (только таким образом. Через .=)
                                $res .= '<div class="deal_tag badge badge-pill badge-light d-inline-block border">'
                                    .$t->name.'</div>';

                            }
                            return $res;
                        },
                    ],
                    [
                          'attribute' => 'id_filial',
                        'value' => function($model)
                        {
                            $adress = \app\models\Branch::find()->where(['id' => $model->id_filial])->one();
                            return $adress->name;
                        }
                    ],
                    'date_create',
                    'date_update',
                    [
                          'attribute'  => 'status',
                        'value' => function($model)
                        {
                            $status = \app\models\Statuses::findOne(['id' => $model->status]);
                            return $status->name;
                        }
                    ],
                    [
                        'attribute' => 'deal_sum',
                        //'contentOptions' => [ Изменение цвета колонки
                        //'class' => 'bg-gray'
                        //],
                        'value' => function($model)
                        {
                            return number_format($model->deal_sum,  false, '',' ');
                        },

                    ],
                    [
                        'attribute' => 'id_comment',

                    ],

                    'deal_email'

                ],
            ]) ?>

        </div>
        <?php $h = History::find()->where(['deal_id' => $model->id])->all(); ?>
        <?php if (sizeof($h) > 0){ ?>

        <div class="shadow rounded-lg mt-3 p-2">
            <?php
            foreach ($h as $histor) { ?>
                <small class="d-block"><?= date('d.m.Y H:i:s',$histor->date) ?> - <?= $histor->status ?>.
                    <b>Услуги:</b> <?=
                    $histor->services
                    ?>. <b>Дата: </b><?= date('d.m.Y',$histor->date_service) ?>. <b>Время:</b> <?=
                    $histor->time_service ?>. <b>Врач:</b> <?= $histor->doc_service ?>. <b>Сотрудник:</b> <?= $histor->responsible ?>
                </small>
                <hr>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-6 mb-5 mt-3">
        <div class="shadow p-3 rounded-lg">
<!--            --><?php //Pjax::begin(); ?>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'id')->dropDownList(ArrayHelper::map(\app\models\LayoutsMail::find()->all(), 'id', 'name'),
                ['prompt'=>'Выбрать шаблон письма...'])->label(false); ?>
             <?= $form->field($model, 'deal_email')->hiddenInput([value($model->deal_email)])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                <!--                --><?//= Html::a('Отправить', ['deals/view', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
<!--            --><?php //Pjax::end(); ?>

        </div>

        <div class="shadow p-3 rounded-lg mt-3">

            <?php $form = ActiveForm::begin(['id' => 'status_id']); ?>
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(\app\models\Statuses::find()->all(), 'id',
               'name'),
                ['prompt'=>'Сменить статус...'])->label(false); ?>
            <?= $form->field($model, 'id')->hiddenInput([value($model->id), 'id' => 'hidden_ids'])->label(false) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="shadow p-3 rounded-lg mt-5">
            <b>Запись звонка</b>
            <audio controls>
                <source src="<?= $model->call_recording ?>" type="audio/ogg">
                <source src="<?= $model->call_recording ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    </div>
</div>
<?php
$_REQUEST['RESPONSIBLE'] = 'gaergaer aergaerg aergaerg';

$RESPONSIBLE = [
    62 => 'Бакеева Ольга Владимировна',
    63 => 'Солаева Виктория Петровна',
    64 => 'Цветкова Дарья Дмитриевна'
];
$TH = [];
foreach ($RESPONSIBLE as $k => $item) {
    $TH[] = $item;
}

print_r($TH);

// id сотрудника
$key_responsible = array_search($_REQUEST['RESPONSIBLE'], $RESPONSIBLE);
//echo gettype($key_responsible);

$k = array_rand($RESPONSIBLE);

//echo $k;
$history = Deals::find()->where(['talon_id' => 2723028352, 'company_id' => 2])->one();
//echo '<pre>';
//print_r($history);
//echo $history->id;
$js = <<< JS
$(document).on("change", "#status_id", function () {
    var data = $(this).serialize();
    var hidden_ids = $('#hidden_ids').val(); // id сделки
    //alert(data);
    $.ajax({
            url: '/deals/status-ajax',
            type: 'POST',
            data: data+'&'+hidden_ids,
            success: function(res){
                console.log(res);
                toastr.success('Статус сделки изменен!')
            },
            error: function(){
                alert('Error!');
            }
        });
    return false; // Cancel form submitting.
});
JS;

$this->registerJs($js);


