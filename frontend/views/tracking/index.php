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
function num_word($value, $words, $show = true)
{
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = ($show) ?  $value . ' ' : '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2:
        case 3:
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }

    return $out;
}

function secToStr($secs)
{
    $res = '';

    $days = floor($secs / 86400);
    $secs = $secs % 86400;
    $res .= num_word($days, array('день', 'дня', 'дней')) . ', ';

    $hours = floor($secs / 3600);
    $secs = $secs % 3600;
    $res .= num_word($hours, array('час', 'часа', 'часов')) . ', ';

    $minutes = floor($secs / 60);
    $secs = $secs % 60;
    $res .= num_word($minutes, array('минута', 'минуты', 'минут')) . ', ';

    $res .= num_word($secs, array('секунда', 'секунды', 'секунд'));

    return $res;
}
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

                'filter'=>User::find()->select(['username', 'id'])->indexBy('id')->column(),

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
                    return  secToStr($sum);
                    //return date('d.m.Y H:i:s', $model->session_start);
                },
                'filter' => 'Количество рабочих часов'
            ],

            [
                'attribute' => 'session_end',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', $model->session_end);
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
                            '<button class="fa-solid fa fa-eye btn btn-sm btn-success"> Детально</button>',
                            $url);
                    },


                ],

            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

