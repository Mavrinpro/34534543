<?php

use app\models\Deals;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\widgets\Alert;
use yii\jui\DatePicker;
use yii\jui\Sortable;
use yii\bootstrap4\Modal;

/** @var yii\web\View $this */
/** @var frontend\models\SearchDeals $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Сделки';
$this->params['breadcrumbs'][] = $this->title;
//$model = new Deals();
//Yii::$app->user->setFlash('error');

?>
    <div class="deals-index">
<?php //if (\Yii::$app->session->getFlash('success')) {
//    Alert::begin([
//        'options' => [
//            'class' => 'alert-success',
//        ],
//    ]);
//    Alert::end();
//     }?>
        <?= Alert::widget() ?>
        <p>
            <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php  //$p = Deals::getData(); ?>
        <?php //echo $this->render('', ['model' => $searchModel]); ?>
        <?php //$user = \common\models\User::findOne($id) ?>

        <?php Pjax::begin(); ?>

        <!--    --><? //= DatePicker::widget(['model' => $p, 'attribute' => 'from_date', 'language' => 'ru', 'dateFormat' => 'php:Y-m-d',]) ?>
        <?php $blockStatus = [1 => 'Звонки', 2 => 'Думает', 3 => 'Записан на прием', 4 => 'Отказ', 5 => 'Информ звонок', 6 => 'Без тегов'

        ];
        foreach ($blockStatus as $key => $stat) {
            $BSTATUS[] = $key;
        }

        $WHERE_IDS = [];
        $TAGS_KEYS = [];
        $USER_KEYS = [];
        // Делаем выборку по всем ID
        $tag_arr = app\models\Tags::find()->asArray()->all();

//        foreach ($p as $user){
//            $user_list = $user->getUser($user->id_operator);
//
//                $USER_KEYS[] = $user_list;
//
//        }
        //var_dump($USER_KEYS[$user->id_operator][0]->username);
//var_dump($USER_KEYS);
        /*
        // Ссобираем все ID в массив, чтобы дальше сделать по ним одну выборку вместо кучи
        foreach ($p as $photo) {
            $tag_list = explode(',', $photo->tag);
            if(isset($tag_list) && sizeof($tag_list) > 0) {
                foreach($tag_list as $res) {
                    $WHERE_IDS[] = $res;
                }
            }
        }
        $tag_arr = app\models\Tags::find()->where(['id' => $WHERE_IDS])->asArray()->all();
        */

        // Пересобираем массив в данными, чтобы исключить множественную выборку, и вносим данные в ключи
        if (isset($tag_arr) && sizeof($tag_arr) > 0) {
            foreach ($tag_arr as $res) {
                $TAGS_KEYS[$res['id']] = $res;
            }
        }

        ?>
        <div class="row draggable">
            <div class="col-md-2 dr">
                <div class="block_status border-bottom mb-2 text-center bg-blue"><?= $blockStatus[1] ?></div>
                <?php
                $DATA = [];


                foreach ($model as $k => $photo) {
                    //$user_id[] = $photo->getUser($photo->id_operator);
                    $badge = [];
                    // Тут создаем массив из TAG который в табилце, т.к там через запятую данные, соответственно
                    // нужно по каждой проходиться в цикле, поэтому ниже мы делаем explode и проходимся по каждому ID
                    // и выписываем в отдельный badge чтобы было красиво, а ниже из массива badge просто делаем
                    // строку через implode, так удобнее отрисовать данные
                    $tag_list = explode(',', $photo->tag);
                    if(isset($tag_list) && sizeof($tag_list) > 0) {
                        foreach($tag_list as $res) {
                            if(strlen(@$TAGS_KEYS[$res]['name']) > 1) {
                                $badge[] = '<div class="deal_tag badge badge-pill badge-light d-inline-block border">' .(@$TAGS_KEYS[$res]['name'] ? $TAGS_KEYS[$res]['name'] : $photo->tag). '</div>';
                            }
                        }
                    }
                $size[] = $photo;
                    // $m =  $photo->getStatuses();
                    if (date('d.m.y', strtotime($photo->date_create)) == date('d.m.y')) {
                        $DATA['date'] = 'Сегодня ' . date('H:i', strtotime($photo->date_create));
                    } else if (date('d', strtotime($photo->date_create)) == date('d') - 1) {
                        $DATA['date'] = 'Вчера ' . date('H:i', strtotime($photo->date_create));
                    } else {
                        $DATA['date'] = date('d.m.y', strtotime($photo->date_create));
                    }
                    $status = ['status' => $photo->status];

                    if ($status['status'] == $BSTATUS[0]) {

                        //$ph[] = $photo->name;
                        $items[] = ['content' => '
                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '">
                <div class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[0] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc">' . $DATA['date'] . '</span>
                <div>' . Html::a($photo->name, ['#', 'id' => $photo->id],['data-id' => $photo->id, 'class' => 'linkModal']) . '</div>
                <div class="deal_phone">' . $photo->phone .'</div>
                <div class="deal_phone">'. $photo->user[0]['username'].'</div>
                '.implode(' ', $badge).'
                ' . ($photo->deal_sum > 0 ? '<div class="ml-auto d-inline-block">' . number_format($photo->deal_sum,
                                    0, ' ', ' ') . ' ₽</div>' : "") . '
                </div></div>'];
                    }else {

                        $items[] = "";
                    }
                }

                    echo Sortable::widget(['id' => 'column' . $BSTATUS[0], 'items' => $items, 'options' => ['tag' => 'div', 'class' => 'dr', 'data-id' => $BSTATUS[0]], 'itemOptions' => ['tag' => 'div'], 'clientOptions' => ['cursor' => 'move', 'revert' => 200, 'opacity' => 0.7, 'connectWith' => '.ui-sortable'],]);

                ?>
            </div>

            <div class="col-md-2 dr">
                <div class="block_status border-bottom mb-2 text-center bg-purple"><?= $blockStatus[2] ?></div>
                <?php

                foreach ($model as $photo) {

                    $badge = [];

                    // Тут создаем массив из TAG который в табилце, т.к там через запятую данные, соответственно
                    // нужно по каждой проходиться в цикле, поэтому ниже мы делаем explode и проходимся по каждому ID
                    // и выписываем в отдельный badge чтобы было красиво, а ниже из массива badge просто делаем
                    // строку через implode, так удобнее отрисовать данные
                    $tag_list = explode(',', $photo->tag);
                    if(isset($tag_list) && sizeof($tag_list) > 0) {
                        foreach($tag_list as $res) {
                            if(strlen(@$TAGS_KEYS[$res]['name']) > 1) {
                                $badge[] = '<div class="deal_tag badge badge-pill badge-light d-inline-block border">' .(@$TAGS_KEYS[$res]['name'] ? $TAGS_KEYS[$res]['name'] : $photo->tag). '</div>';
                            }
                        }
                    }

                    $status = ['status' => $photo->status];
                    if (date('d.m.y', strtotime($photo->date_create)) == date('d.m.y')) {
                        $DATA['date'] = 'Сегодня ' . date('H:i', strtotime($photo->date_create));
                    } else if (date('d', strtotime($photo->date_create)) == date('d') - 1) {
                        $DATA['date'] = 'Вчера ' . date('H:i', strtotime($photo->date_create));
                    } else {
                        $DATA['date'] = date('d.m.y', strtotime($photo->date_create));
                    }
                    if ($status['status'] == 2) {

                        $item[] = ['content' => '
                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '">
                <div id="item' . $photo->id . '" class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[1] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc">' . $DATA['date'] . '</span>
                <div>' . Html::a($photo->name, ['#', 'id' => $photo->id],['data-id' => $photo->id, 'class' => 'linkModal']) .
                            '</div>
                <div class="deal_phone">' . $photo->phone .'</div>
                <div class="deal_phone">'. $photo->user[0]['username'].'</div>
                '.implode(' ', $badge).'  ' . ($photo->deal_sum > 0 ? '<div class="ml-auto d-inline-block">' . number_format($photo->deal_sum,
                                    0, ' ', ' ') . ' ₽</div>' : "") . '
                </div></div>'];

                    } else {
                        $item[] = ['content' => ""];
                    }
                }


                echo Sortable::widget(['id' => 'column' . $BSTATUS[1], 'items' => $item, 'options' => ['tag' => 'div', 'class' => 'dr', 'data-id' => $BSTATUS[1]
                ],
                    'itemOptions' => ['tag' => 'div',
                    ], 'clientOptions' => ['cursor' => 'move', 'revert' => 200, 'opacity' => 0.7, 'connectWith' => '.ui-sortable',

                    ],
                ]);

                ?>
            </div>
            <div class="col-md-2 dr">
                <div class="block_status border-bottom mb-2 text-center bg-olive"><?= $blockStatus[3] ?></div>
                <?php
                foreach ($model as $photo) {

                    $badge = [];

                    // Тут создаем массив из TAG который в табилце, т.к там через запятую данные, соответственно
                    // нужно по каждой проходиться в цикле, поэтому ниже мы делаем explode и проходимся по каждому ID
                    // и выписываем в отдельный badge чтобы было красиво, а ниже из массива badge просто делаем
                    // строку через implode, так удобнее отрисовать данные
                    $tag_list = explode(',', $photo->tag);
                    if(isset($tag_list) && sizeof($tag_list) > 0) {
                        foreach($tag_list as $res) {
                            if(strlen(@$TAGS_KEYS[$res]['name']) > 1) {
                                $badge[] = '<div class="deal_tag badge badge-pill badge-light d-inline-block border">' .(@$TAGS_KEYS[$res]['name'] ? $TAGS_KEYS[$res]['name'] : $photo->tag). '</div>';
                            }
                        }
                    }

                    $status = ['status' => $photo->status];
                    if (date('d.m.y', strtotime($photo->date_create)) == date('d.m.y')) {
                        $DATA['date'] = 'Сегодня ' . date('H:i', strtotime($photo->date_create));
                    } else if (date('d', strtotime($photo->date_create)) == date('d') - 1) {
                        $DATA['date'] = 'Вчера ' . date('H:i', strtotime($photo->date_create));
                    } else {
                        $DATA['date'] = date('d.m.y', strtotime($photo->date_create));
                    }
                    if ($status['status'] == 3) {

                        $item2[] = ['content' => '
                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '"><div class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[2] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc">' . $DATA['date'] . '</span>
                <div>' . Html::a($photo->name, ['#', 'id' => $photo->id],['data-id' => $photo->id, 'class' => 'linkModal']) . '</div>
                <div class="deal_phone">' . $photo->phone . '</div>
                <div class="deal_phone">'. $photo->user[0]['username'].'</div>
                '.implode(' ', $badge).'
                ' . ($photo->deal_sum > 0 ? '<div class="ml-auto d-inline-block">' . number_format($photo->deal_sum,
                                    0, ' ', ' ') . ' ₽</div>' : "") . '
                </div></div>'];
                    } else {
                        $item2[] = ['content' => ""];
                    }
                }


                echo Sortable::widget(['id' => 'column' . $BSTATUS[2], 'items' => $item2, 'options' => ['tag' => 'div', 'class' => 'dr', 'data-id' => $BSTATUS[2]

                ], 'itemOptions' => ['tag' => 'div',

                ], 'clientOptions' => ['cursor' => 'move', 'revert' => 200, 'opacity' => 0.7, 'connectWith' => '.ui-sortable',

                ],

                ]);

                ?>
            </div>
            <div class="col-md-2 dr">
                <div class="block_status border-bottom mb-2 text-center bg-pink"><?= $blockStatus[4] ?></div>
                <?php


                foreach ($model as $photo) {

                    $badge = [];

                    // Тут создаем массив из TAG который в табилце, т.к там через запятую данные, соответственно
                    // нужно по каждой проходиться в цикле, поэтому ниже мы делаем explode и проходимся по каждому ID
                    // и выписываем в отдельный badge чтобы было красиво, а ниже из массива badge просто делаем
                    // строку через implode, так удобнее отрисовать данные
                    $tag_list = explode(',', $photo->tag);
                    if(isset($tag_list) && sizeof($tag_list) > 0) {
                        foreach($tag_list as $res) {
                            if(strlen(@$TAGS_KEYS[$res]['name']) > 1) {
                                $badge[] = '<div class="deal_tag badge badge-pill badge-light d-inline-block border">' .(@$TAGS_KEYS[$res]['name'] ? $TAGS_KEYS[$res]['name'] : $photo->tag). '</div>';
                            }
                        }
                    }

                    $status = ['status' => $photo->status];

                    if (date('d.m.y', strtotime($photo->date_create)) == date('d.m.y')) {
                        $DATA['date'] = 'Сегодня ' . date('H:i', strtotime($photo->date_create));
                    } else if (date('d', strtotime($photo->date_create)) == date('d') - 1) {
                        $DATA['date'] = 'Вчера ' . date('H:i', strtotime($photo->date_create));
                    } else {
                        $DATA['date'] = date('d.m.y', strtotime($photo->date_create));
                    }

                    if ($status['status'] == 4) {
                        $item3[] = ['content' => '
                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '"><div class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[3] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc">' . $DATA['date'] . '</span>
                <div>' . Html::a($photo->name, ['#', 'id' => $photo->id],['data-id' => $photo->id, 'class' => 'linkModal']) . '</div>
                <div class="deal_phone">' . $photo->phone . '</div>
                <div class="deal_phone">'. $photo->user[0]['username'].'</div>
                '.implode(' ', $badge).'
                ' . ($photo->deal_sum > 0 ? '<div class="ml-auto d-inline-block">' . number_format($photo->deal_sum,
                                    0, ' ', ' ') . ' ₽</div>' : "") . '
                </div></div>'];
                    } else {
                        $item3[] = ['content' => ""];
                    }
                }

                echo Sortable::widget(['id' => 'column' . $BSTATUS[3], 'items' => $item3, 'options' => ['tag' => 'div', 'class' => 'dr', 'data-id' => $BSTATUS[3]

                ], 'itemOptions' => ['tag' => 'div',

                ], 'clientOptions' => ['cursor' => 'move', 'revert' => 200, 'opacity' => 0.7, 'connectWith' => '.ui-sortable',

                ],

                ]);
                ?>
            </div>
            <div class="col-md-2 dr">
                <div class="block_status border-bottom mb-2 text-center bg-success"><?= $blockStatus[5] ?></div>
                <?php
                foreach ($model as $photo) {

                    $badge = [];

                    // Тут создаем массив из TAG который в табилце, т.к там через запятую данные, соответственно
                    // нужно по каждой проходиться в цикле, поэтому ниже мы делаем explode и проходимся по каждому ID
                    // и выписываем в отдельный badge чтобы было красиво, а ниже из массива badge просто делаем
                    // строку через implode, так удобнее отрисовать данные
                    $tag_list = explode(',', $photo->tag);
                    if(isset($tag_list) && sizeof($tag_list) > 0) {
                        foreach($tag_list as $res) {
                            if(strlen(@$TAGS_KEYS[$res]['name']) > 1) {
                                $badge[] = '<div class="deal_tag badge badge-pill badge-light d-inline-block border">' .(@$TAGS_KEYS[$res]['name'] ? $TAGS_KEYS[$res]['name'] : $photo->tag). '</div>';
                            }
                        }
                    }

                    $status = ['status' => $photo->status];

                    if (date('d.m.y', strtotime($photo->date_create)) == date('d.m.y')) {
                        $DATA['date'] = 'Сегодня ' . date('H:i', strtotime($photo->date_create));
                    } else if (date('d', strtotime($photo->date_create)) == date('d') - 1) {
                        $DATA['date'] = 'Вчера ' . date('H:i', strtotime($photo->date_create));
                    } else {
                        $DATA['date'] = date('d.m.y', strtotime($photo->date_create));
                    }

                    if ($status['status'] == 5) {
                        $item4[] = ['content' => '
                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '"><div class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[4] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc">' . $DATA['date'] . '</span>
                <div>' . Html::a($photo->name, ['#', 'id' => $photo->id],['data-id' => $photo->id, 'class' => 'linkModal']) . '</div>
                <div class="deal_phone">' . $photo->phone . '</div>
                <div class="deal_phone">'. $photo->user[0]['username'].'</div>
                '.implode(' ', $badge).'
                ' . ($photo->deal_sum > 0 ? '<div class="ml-auto d-inline-block">' . number_format($photo->deal_sum,
                                    0, ' ', ' ') . ' ₽</div>' : "") . '
                </div></div>'];
                    } else {
                        $item4[] = ['content' => ""];
                    }
                }

                echo Sortable::widget(['id' => 'column' . $BSTATUS[4], 'items' => $item4, 'options' => ['tag' => 'div', 'class' => 'dr', 'data-id' => $BSTATUS[4]

                ], 'itemOptions' => ['tag' => 'div',

                ], 'clientOptions' => ['cursor' => 'move', 'revert' => 200, 'opacity' => 0.7, 'connectWith' => '.ui-sortable',

                ],

                ]);
                ?>
            </div>
            <div class="col-md-2 dr">
                <div class="block_status border-bottom mb-2 text-center bg-gray"><?= $blockStatus[6] ?></div>
                <?php
                foreach ($model as $photo) {

                    $badge = [];

                    // Тут создаем массив из TAG который в табилце, т.к там через запятую данные, соответственно
                    // нужно по каждой проходиться в цикле, поэтому ниже мы делаем explode и проходимся по каждому ID
                    // и выписываем в отдельный badge чтобы было красиво, а ниже из массива badge просто делаем
                    // строку через implode, так удобнее отрисовать данные
                    $tag_list = explode(',', $photo->tag);
                    if(isset($tag_list) && sizeof($tag_list) > 0) {
                        foreach($tag_list as $res) {
                            if(strlen(@$TAGS_KEYS[$res]['name']) > 1) {
                                $badge[] = '<div class="deal_tag badge badge-pill badge-light d-inline-block border">' .(@$TAGS_KEYS[$res]['name'] ? $TAGS_KEYS[$res]['name'] : $photo->tag). '</div>';
                            }
                        }
                    }

                    $status = ['status' => $photo->status];

                    if (date('d.m.y', strtotime($photo->date_create)) == date('d.m.y')) {
                        $DATA['date'] = 'Сегодня ' . date('H:i', strtotime($photo->date_create));
                    } else if (date('d', strtotime($photo->date_create)) == date('d') - 1) {
                        $DATA['date'] = 'Вчера ' . date('H:i', strtotime($photo->date_create));
                    } else {
                        $DATA['date'] = date('d.m.y', strtotime($photo->date_create));
                    }

                    if ($status['status'] == 6) {
                        $item5[] = ['content' => '
                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '"><div class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[5] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc">' . $DATA['date'] . '</span>
                <div>' . Html::a($photo->name, ['#', 'id' => $photo->id],['data-id' => $photo->id, 'class' => 'linkModal']) . '</div>
                <div class="deal_phone">' . $photo->phone . '</div>
                <div class="deal_phone">'. $photo->user[0]['username'].'</div>
                '.implode(' ', $badge).'
                ' . ($photo->deal_sum > 0 ? '<div class="ml-auto d-inline-block">' . number_format($photo->deal_sum,
                                    0, ' ', ' ') . ' ₽</div>' : "") . '
                </div></div>'];
                    } else {
                        $item5[] = ['content' => ""];
                    }
                }

                echo Sortable::widget(['id' => 'column' . $BSTATUS[5], 'items' => $item5, 'options' => ['tag' => 'div', 'class' => 'dr', 'data-id' => $BSTATUS[5]

                ], 'itemOptions' => ['tag' => 'div',

                ], 'clientOptions' => ['cursor' => 'move', 'revert' => 200, 'opacity' => 0.7, 'connectWith' => '.ui-sortable',],

                ]);
                ?>
            </div>
        </div>


        <!--    --><? //= GridView::widget(['dataProvider' => $dataProvider, 'filterModel' => $searchModel, 'columns' => [//['class' => 'yii\grid\SerialColumn'],
        //
        //        'id', 'name', 'phone', 'tag', 'date_create', //'status',
        //        //'id_operator',
        //        //'id_filial',
        //        //'id_comment',
        //        ['class' => ActionColumn::className(), 'urlCreator' => function ($action, Deals $model, $key, $index, $column) {
        //            return Url::toRoute([$action, 'id' => $model->id]);
        //        }],],]); ?>
        <?php Pjax::end(); ?>

    </div>

<?php $this->registerJs(<<<JS
        let arr = [];
$('.dr').sortable({

    receive: function( event, ui ) {

       let block_id = $(this).find('.ui-sortable-handle .ui-sortable-helper').children('.dgdfdg').data('id');
       //var statusID = ($('.ui-sortable-handle.ui-sortable-helper').find('.rounded').data('status'));
        arr['statusID'] =  $(this).data('id');
        console.log(arr['id']+'---');
        $.ajax({
            type: "POST",
            url: "index",
            data: 'action=dragged&statusID='+arr['statusID']+'&block_id='+arr['id'],
            dataType: 'JSON',
            success: function (data){
                $('.ui-sortable-handle.ui-sortable-helper').find('.rounded').attr('data-status', arr['statusID']);
                console.log(JSON.parse( arr['statusID'] + data.id));
                $(document).Toasts('create', {title: 'У сделки изменился статус!', icon: 'fa fa-check-circle', autohide: true, class: 'bg-success'})
            }
        })

    },
    change  : function end(){
        let ID = $('.ui-sortable-handle .ui-sortable-helper').find('.dgdfdg').data('id');
        $('.ui-sortable-handle.ui-sortable-helper').find('.rounded').attr('data-status', arr['statusID']);
        return arr['id'] = ID;

    },

    over  : function (){
        $('.ui-sortable-handle.ui-sortable-helper').find('.rounded').attr('data-status', arr['statusID']);
    }

});
JS
); ?>


<?php $this->registerJs(<<<JS
$('.linkModal').on('click', function (){
    var data = $(this).data();
    $('#exmodal').modal('show');
     $('#exmodal').find('.modal-title').text('id ' +data.id);
     $('#exmodal').find('.modal-body').load('/deals/update?id=' +data.id);
})
JS
); ?>

<?php $this->registerJs(<<<JS
     
JS
); ?>
