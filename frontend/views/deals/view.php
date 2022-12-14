<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\widgets\Alert;
/** @var yii\web\View $this */
/** @var app\models\Deals $model */

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
                    [
                         'attribute' => 'del',
                        'format' => 'html',
                        'value' => function($model){
                            if ($model->del == 0){
                                return '<i class="fas fa-unlock text-success" title="Активная"></i>';
                            }else{
                                return '<i class="fas fa-ban text-danger" title="Удалена"></i>';
                            }
                        }
                    ],
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
<!--<div class="deals-view">-->
<!---->
<!--    <p>-->
<!--        --><?//= Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary
//        btn-sm']) ?>
<!--        --><?//= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger btn-sm',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--        --><?//= Html::a('Все', '/deals/', ['class' => 'btn btn-warning btn-sm']) ?>
<!--    </p>-->
<!--    --><?php
//    echo '<pre>';
//   // print_r($model);
//    ?>
<!---->
<!--    --><?php //$adress = \app\models\Branch::findOne(['id' => $model->id_filial])?>
<!--    --><?php //$status = \app\models\Statuses::findOne(['id' => $model->status])?>
<!--Название: --><?//= $model->name ?><!--<br>-->
<!--ID: --><?//= $model->id ?><!--<br>-->
<!--Телефон: --><?//= $model->phone ?><!--<br>-->
<!--Теги: --><?//= $model->getTags($model)->name ?><!--<br>-->
<!--Филиал: --><?//= $adress->name ?><!--<br>-->
<!--Дата: --><?//= date('d.m.Y' ,strtotime($model->date_create)) ?><!--<br>-->
<?//= $status->name ?><!--<br>-->
<!---->
<!--    <div class="col-md-4 col-sm-6 col-12">-->
<!--        --><?//= \hail812\adminlte\widgets\InfoBox::widget([
//            'text' => $model->name ,
//            'number' => $model->phone,
//            //'icon' => 'far fa-bookmark',
//            'progress' => [
//                'width' => '70%',
//                'description' => '70% Increase in 30 Days',
//                'egerger' => 'aergaer'
//            ]
//        ]) ?>
<!--    </div>-->
<!---->
<!---->
<!--    --><?//= DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'name',
//            'phone',
//            'tag',
//            'date_create',
//            [
//                'attribute' => 'status',
//                'value' => $status->name
//            ],
//            'id_operator',
//            'id_filial',
//            'id_comment',
//        ],
//    ]) ?>
<!---->
<!--</div>-->
