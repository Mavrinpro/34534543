<?php

use common\models\User;
use app\models\Tracking;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\SearchTracking $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
<?php

?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                //label' => 'Полное имя',
                'attribute'=>'user_id',
                'value' => 'user.full_name',

                'format' => 'text',

                'filter'=>User::find()->where(['!=','status', '8'])->select(['username', 'id'])->indexBy('id')->column(),

            ],
            [
                    'attribute' => 'date_at',
                    'value' => function($model)
                    {
                        return date('d.m.Y H:i:s', $model->date_at);
                    }
            ],
            //'date_end',
            [
                'attribute' => 'session_start',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', $model->session_start);
                }
            ],
            [
                    'label' => 'Расчет',
                'attribute' => 'yutyuyt',
                'value' => function($model)
                {
                    $sum = $model->session_end - $model->session_start;
                    if (isset($model->session_end)){
                        return  secToStr($sum);
                    }else{
                        return 'Сотрудник в работе';
                    }

                    //return date('d.m.Y H:i:s', $model->session_start);
                },
                'filter' => 'Количество рабочих часов'
            ],

            [
                'attribute' => 'session_end',
                'value' => function($model)
                {
                    if (isset($model->session_end)){
                        return  date('d.m.Y H:i:s', $model->session_end);
                    }else{
                        return 'Не завершен';
                    }
                }
            ],


            [
                'class' => ActionColumn::className(),
                'template'=>'{view}{update}{check}{delete}',
                'header' =>    Html::a('Сбросить фильтр', ['index'], ['class' => 'btn btn-sm btn-outline-primary']),

                'visibleButtons' => [
                    'delete' => false,
                    'update' => false
                ],
                'buttons' => [

                    'view' => function ($url,$model, $key) {
                        return Html::a(
                            '<button class="btn btn-sm btn-success"><i class="fa-solid fa fa-eye"></i> Детально</button>',
                            $url);
                    },


                ],

            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

