<?php

use app\models\Deals;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
use kartik\export\ExportMenu;
//use kop\y2sp\ScrollPager;
use practically\chartjs\Chart;
/** @var yii\web\View $this */
/** @var frontend\models\SearchDeals $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Поиск сделок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'grid']); ?>
    <?php $datestart = 1671096781;
    $dateend = 1671096886;
    $sundate = $dateend - $datestart;



    ?>
<!--    --><?//=
//    Chart::widget([
//        'type' => Chart::TYPE_BAR,
//        //'labels' => $arrLabel,
//        'datasets' => [
//
//
//            [
//                'label' => 'По филиалам',
//                'query' => \app\models\Deals::find()
//                    ->select('id_filial')
//                    ->addSelect('count(*) as data')
//                    ->groupBy('id_filial')
//                    ->createCommand(),
//                'labelAttribute' => 'id_filial',
//
//            ],
//        ],
//
//
//    ]);
//    ?>
    <?php  // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-12"><div class="alert alert-secondary" role="alert">Здесь можно настроить и экспортироовать отчет в выбранном формате</div>
    </div>

<?php
$gridColumns = [
      'name',
    'phone',

    'deal_sum',
    [
        //label' => 'Полное имя',
        'attribute'=>'id_operator',
        'value' => 'us.username',
        'format' => 'text',

// esli nujen select
        'filter'=>\common\models\User::find()->where(['!=','status', 8])->select(['username', 'id'])
            ->indexBy
            ('id')->column(),

    ],
    [
        //label' => 'Полное имя',
        'attribute'=>'tag',
        'value' => 'tegi.name',

        'format' => 'text',

        'filter'=>\app\models\Tags::find()->select(['name', 'id'])->indexBy('id')->column(),

    ],
    [
        //label' => 'Полное имя',
        'attribute'=>'id_filial',
        'value' => 'branch.name',

        'format' => 'text',

        'filter'=>\app\models\Branch::find()->select(['name', 'id'])->indexBy('id')->column(),

    ],


];
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
]);
?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'options' => [
            'id' => 'search_deals'
        ],
        'footerRowOptions'=>['class'=>'bg-dark'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            [
                'attribute' => 'phone',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        $model->phone,['deals/update', 'id' => $model->id]);
                },
            ],
            //'deal_sum',
            [
                'attribute' => 'deal_sum',
                'value' => function($model)
                {
                    return number_format($model->deal_sum,  false, '',' ');
                },
                'footer' => number_format($dataProvider->query->sum('deal_sum'),  false, '',' '),
            ]    ,
            //'id_operator',

                [
                    //label' => 'Полное имя',
                    'attribute'=>'id_operator',
                    'value' => 'us.full_name',
                    'format' => 'text',

// esli nujen select
                    'filter'=>\common\models\User::find()->where(['!=','status', 8])->andWhere(['!=', 'status', 0])->select(['username', 'id'])
                        ->indexBy
                    ('id')->column(),

                ],

            //'tag',
            //'date_create',

            [

                    //'autocomplete'=> false,
                    'attribute' => 'date_create',
                    'filterInputOptions' => [
                            'autocomplete' => 'off'
                    ],
                //'model' => $searchModel,
                'filter' => DateRangePicker::widget([
                'name' => 'Deals[date_create]',
                'model'=>$searchModel,

                'attribute'=>'date_create',
                    'convertFormat'=>true,
                    'useWithAddon'=>false,
                'pluginOptions'=>[
                    'timePicker'=>true,
                    //'timePickerIncrement'=>30,
                    'locale'=>[
                        'format'=>'Y-m-d'
                    ],

                ],
                    'options' => [
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ]


            ])

            ],
            [
                //label' => 'Полное имя',
                'attribute'=>'tag',
                //'value' => 'tegi.name',
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

                'format' => 'html',

                'filter'=>\app\models\Tags::find()->select(['name', 'id'])->indexBy('id')->column(),

            ],


            [
                'attribute'=>'status',
                'format' => 'html',
                'value' => function($model){
                    if($model->status == '1'){
                        return '<span class="text-success"><span class="badge badge-success bg-blue">Звонки</span></span>';
                    }else if($model->status == '2'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-purple">Думает</span></span>';
                    }else if($model->status == '3'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-olive">Записан на прием</span></span>';
                    }
                    else if($model->status == '4'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-pink">Отказ</span></span>';
                    }
                    else if($model->status == '5'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-success">Информ звонок</span></span>';
                    }
                    else if($model->status == '6'){
                        return '<span class="text-danger"><span class="badge badge-danger bg-gray">Неразобранные</span></span>';
                    }
                },
                'filter'=>array("1"=>"Звонки","2"=>"Думает", "3" => "Записан на прием", "4" => "Отказ", "5" => "Информ звонок", "6" => "Неразобранные" ),
            ],

            [
                //label' => 'Полное имя',
                'attribute'=>'id_filial',
                'value' => 'branch.name',

                'format' => 'text',

                'filter'=>\app\models\Branch::find()->select(['name', 'id'])->indexBy('id')->column(),

            ],

            [
                'class' => ActionColumn::className(),
                'header' =>    Html::a('Сбросить фильтр', ['deals/search-deals'], ['class' => 'btn btn-sm btn-outline-primary']),
                'template'=>'{view}{update}{updater}',
                'visibleButtons' => [

                    'delete' => function ($model) {
                        return \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin';
                    },
                ],
                'buttons' => [
                    'update' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-edit btn btn-sm btn-warning mr-2"></i>',
                            $url);
                    },
                    'view' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fa-solid fa fa-eye btn btn-sm btn-success mr-2"></i>',
                            $url);
                    },
                    'updater' => function ($url,$model, $key) {
                        return Html::a(
                            '<i class="fas fa-times-circle btn btn-sm btn-danger"></i>',
                            ['deals/updater', 'id' => $model->id],[
                            //'title' => Yii::t('app', 'Закрыть задачу'),
                            'data-confirm' => Yii::t('yii', 'Удалить запись № '.$key.'?'),
                            'data-method' => 'post', 'data-pjax' => '0',
                                'title' => 'Закрыть сделку'
                        ]);
                    },

                ],
            ],
        ],
    ]);
//    $branch = \app\models\Branch::find()->all();
//    foreach ($branch as $bran) {
//        $br[] = $bran['name'];
//    }
//    ?>
<!--    --><?//=
//    Chart::widget([
//    'type' => Chart::TYPE_BAR,
//    'labels' => $br,
//    'datasets' => [
//
//
//    [
//    'label' => 'По филиалам',
//    'query' => \app\models\Deals::find()
//    ->select('id_filial')
//    ->addSelect('count(*) as data')
//    ->groupBy('id_filial')
//    ->createCommand(),
//    'labelAttribute' => 'id_filial',
//
//    ],
//    ],
//
//
//    ]);
//    ?>
    <?php Pjax::end(); ?>

</div>
<?php
$js = <<< JS

 function updateList() {
         $.pjax.reload({container: "#search_deals", async: false});
        }
        setInterval(updateList, 5000);


JS;

$this->registerJs($js);