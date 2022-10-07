<?php

use app\models\Doctors;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\DataProviderInterface;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Врачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Doctors', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'last_name',
            'first_name',
            'specialization',
            //'work_experience',
            //'treated_patients',
            [
                'label' =>'Фото',
                'attribute' => 'photo',
                'format' => 'raw',
                //Through this return value, we can arbitrarily control the display of column data
                //$data points to the data result set of the current row
                'value' => function ($data) {
                    if ($data->photo != '') {

                        return Html::img('/uploads/' . $data->photo, ["width" => "84", "height" => "84"]);
                    }else{
                        return '';
                    }
                },
            ],
            //'specialization_text:ntext',
            //'about_doc:ntext',
            //'sertificates:ntext',
            //'education:ntext',
            //'date_create',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Doctors $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
