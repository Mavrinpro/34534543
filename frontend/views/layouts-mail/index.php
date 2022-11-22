<?php

use app\models\LayoutsMail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\SearchLayoutsMail $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Шаблоны писем';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="layouts-mail-index">
    <p>
        <?= Html::a('Создать шаблон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'mail_id',
            //'text:html',
            [
              'attribute' => 'text',
              'format' => 'html',
              'value' => function($model){
                  $model->text = explode(" ", $model->text);
                  $model->text = array_slice($model->text, 0, 6);
                  $newtext = implode(" ", $model->text);
                  $newtext = strip_tags($newtext);
                  return '<p>'.$newtext.'...</p>';
              }
],
            //'img',
            [
                'label' =>'Файл',
                'attribute' => 'file',
                'format' => 'html',
                //Through this return value, we can arbitrarily control the display of column data
                //$data points to the data result set of the current row
                'value' => function ($data) {
                    if ($data->file != '') {

                        return Html::a($data->file, ['foldermail/' . $data->file], ['target'=>'_blank',
                            'data-pjax'=>false, 'class' => 'target_class']);
                    }else{
                        return '';
                    }
                },
            ],
            //'date_create',
            //'date_update',
            [
                'class' => ActionColumn::className(),
                'buttons' => [
                    'update' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-edit btn btn-sm btn-warning"></i>',
                            $url);
                    },
                    'view' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-eye btn btn-sm btn-success"></i>',
                            $url);
                    },
                    'delete' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa fa-trash-alt btn btn-sm btn-danger"></i>',
                            $url,[
                            //'title' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Удалить запись № '.$key.'?'),
                            'data-method' => 'post', 'data-pjax' => '1',
                        ]);
                    },


                ],
                'content' => function( $member )
                {
                    return "<b>{$member->date_end}</b>";
                },
            ],
        ],
    ]); ?>


</div>
<?php
$js = <<<JS
$('.target_class').attr('target', '_blank');



JS;
$this->registerJs($js);
?>
