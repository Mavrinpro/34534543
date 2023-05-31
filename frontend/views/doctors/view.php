<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Doctors $model */
/** @var app\models\Doctors $ev */
/** @var app\models\Doctors $files */
/** @var app\models\Doctors $f */
//\yii\helpers\VarDumper::dump($ev, $dept = 10, $highlight = true);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

Modal::begin( [
    'title' => '<h5>Добавление задачи</h5>',
    //'toggleButton' => ['label' => 'Добавить задачу', 'class' => 'btn btn-warning'],
    'footer' => 'Footer',

] );



echo "<div id='modalContent'>";
$form = ActiveForm::begin(['action' => '/doctors/create-event']);

echo $form->field($ev, 'name')->textInput(['maxlength' => true]);

echo $form->field($ev, 'user_id')->hiddenInput(['value' => $model->id])->label(false);

echo $form->field($ev, 'date_create')->textInput(['class' => 'form-control date_create']);

echo $form->field($ev, 'date_update')->hiddenInput()->label(false);

echo $form->field($ev, 'active')->hiddenInput(['value' => 1])->label(false);


echo Html::submitButton('Создать', ['class' => 'btn btn-success', 'name' => 'create_event']);


ActiveForm::end();
echo "</div>";

Modal::end();

Modal::begin( [
    'title' => '<h5>Добавить название файлу</h5>',
    //'toggleButton' => ['label' => 'Добавить задачу', 'class' => 'btn btn-warning'],
    'footer' => 'Footer',

] );
echo "<div id='modalContent2'>";
$formFile = ActiveForm::begin(['id' => 'formFile', 'action' => '/doctors/set-title']);

echo $formFile->field($f, 'title')->textInput();
echo $formFile->field($f, 'id')->hiddenInput()->label(false);
echo $formFile->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false);

echo Html::submitButton('Создать', ['class' => 'btn btn-success', 'name' => 'create_file_title']);


ActiveForm::end();
echo "</div>";
Modal::end();
?>
<div class="doctors-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/doctors/', ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Создать расписание', ['event/create'], ['class' => 'modalButton  btn btn-success', 'data-id' =>
            Yii::$app->request->get('id')]) ?>
    </p>
    <div class="col-md-12">
    <?php
    echo \kato\DropZone::widget([
        'options' => [
            'maxFilesize' => '10',
            'dictDefaultMessage' => 'Перетащите файлы в эту область'
        ],
        'clientEvents' => [
            'complete' => "function(file){console.log(file)}",
            'removedfile' => "function(file){alert(file.name + ' is removed')}"
        ],
    ]);
?></div>
    <div class="row">
    <?php
    foreach ($files as $file) {
        //var_dump($files); die();

        $url = 'files/';
        $path_parts = pathinfo('/'.$url.$file->name);

        $files = scandir('files/');
       // $files2 = scandir($dir, 1);

        //print_r($files1);
        //print_r($files2);
        //var_dump($files);
        $ras = explode('.', $file->name);

        //$kb = filesize("files/".$file->name);
        //echo $url.$file->name;

        //echo $url.$file->name;
        switch ($path_parts['extension']) {
            case 'xlsx':
                $ind = '/img/icon_xlsx.png';
                break;
            case 'xls':
                $ind = '/img/icon_xls.png';
                break;
            case 'txt':
                $ind = '/img/icon_txt.png';
                break;
            case 'zip':
                $ind = '/img/icon_zip.png';
                break;
            case 'json':
                $ind = '/img/icon_js.png';
                break;
            case 'csv':
                $ind = '/img/icon_csv.png';
                break;
            case 'docx':
                $ind = '/img/icon_doc.png';
                break;
            case 'pdf':
                $ind = '/img/icon_pdf.png';
                break;
            case 'png':
                $ind = '/img/icon_png.png';
                break;
            case 'jpeg':
                $ind = '/img/icon_jpg.png';
                break;
            case 'html':
                $ind = '/img/icon_html.png';
                break;
            case 'psd':
                $ind = '/img/icon_psd.png';
                break;
            case 'jpg':
                $ind = '/img/icon_jpg.png';
                break;
            case 'MP4':
                $ind = '/img/icon_mp4.png';
                break;
            case 'JPG':
                $ind = '/img/icon_jpg.png';
                break;
            default:
                $ind = '/img/icon_file.png';
        }
        if (!empty($file->name)) {
            $kb = filesize("files/".$file->name);

            echo '<div class="col-md-2 text-center mt-3"><div class="div_img">';

            echo '<img src="' . $ind . '" width="40" data-id="'.$file->id.'" data-title="'.$file->title.'" class="file_upload"></br>';
            //clearstatcache();
             echo '<span class="badge badge-pill">'.round($kb / 1024, 1).'kb</span></br>';


            if ($file->title != null){
                echo Html::a($file->title, \yii\helpers\Url::base() .'/'.$url. $file->name, ['class' => 'small']) . "<br/>";
            }else{
                echo Html::a($file->name, \yii\helpers\Url::base() .'/'.$url. $file->name, ['class' => 'small']) . "<br/>"; //
            }

            //echo '<a href="/doctors/remove-document/'.$file->id.'" >&times</a>';
            echo Html::a('&times', ['doctors/remove-document', 'id' => $file->id, 'modelid' => $model->id], ['class' =>
                'badge badge-pill badge-danger', 'data-confirm' => Yii::t('yii', 'Удалить файл: '.$file->name.'?')]);
            echo '</div></div>';

        }
    }
//    $files = \yii\helpers\FileHelper::findFiles('files/');
//    if (isset($files[0])) {
//        foreach ($files as $index => $file) {
//            //$nameFicheiro = substr($file, strrpos($file, '/') + 1);
//            $ras = explode('.', $file);
//            $kb = filesize($file);
//            switch ($ras[1]){
//                case 'xlsx':
//                    $ind = '/img/icon_xlsx.png';
//                    break;
//                case 'xls':
//                    $ind = '/img/icon_xls.png';
//                    break;
//                case 'csv':
//                    $ind = '/img/icon_csv.png';
//                    break;
//                case 'docx':
//                    $ind = '/img/icon_doc.png';
//                    break;
//                case 'pdf':
//                    $ind = '/img/icon_pdf.png';
//                    break;
//                case 'png':
//                    $ind = '/img/icon_png.png';
//                    break;
//                case 'jpeg':
//                    $ind = '/img/icon_jpg.png';
//                    break;
//                default: $ind = '/img/icon_png.png';
//            }
//            echo '<div class="col-md-2 text-center">';
//            echo '<img src="'. $ind.'" width="40"></br>';
//            echo '<span class="badge badge-pill">'.round($kb / 1024, 1).'kb</span></br>';
//
//            echo Html::a($file, \yii\helpers\Url::base() . '/' . $file) . "<br/>"; //
//            echo '</div>';
//            // render do
//            // ficheiro no browser
//        }
//    } else {
//        echo "There are no files available for download.";
//    }

    ?>
    </div>
<!--    --><?//= DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'name',
//            'last_name',
//            'first_name',
//            'specialization',
//            'work_experience',
//            'treated_patients',
//            'photo',
//            'specialization_text:ntext',
//            'about_doc:ntext',
//            'sertificates:ntext',
//            'education:ntext',
//            'date_create',
//            [
//                'attribute'=>'photo',
//                'label'=>'Фото',
//                'format'=>'raw',
//                'value' => Html::img('/uploads/'.$model->photo,['style'=>'width: 50px; height: 50px']),
//            ],
//        ],
//
//    ]) ?>



</div>
<!-- External Events -->
<div id='draggable-el' data-event='{ "title": "my event", "duration": "02:00" }'>drag me</div>
<ul id="external-events" class="fullcalendar-custom list-unstyled list-unstyled-py-2 w-sm-50 mb-5">
    <li>
        <!-- Event -->
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event fc-daygrid-inline-block-event'
             data-event='{
					 "title": "Open a new task on Jira",
					 "image": "../assets/svg/brands/jira-icon.svg",
					 "className": ""
				 }'>
            <div class='fc-event-title'>
                <div class='d-flex align-items-center'>

                    <span>Open a new task on Jira</span>
                </div>
            </div>
        </div>
        <!-- End Event -->
    </li>

    <li>
        <!-- Event -->
        <div id="external-events">
            <p>
                <strong>Draggable Events</strong>
            </p>

            <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                <div class="fc-event-main">My Event 1</div>
            </div>
            <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                <div class="fc-event-main">My Event 2</div>
            </div>
            <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                <div class="fc-event-main">My Event 3</div>
            </div>
            <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                <div class="fc-event-main">My Event 4</div>
            </div>
            <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                <div class="fc-event-main">My Event 5</div>
            </div>

            <p>
                <input type="checkbox" id="drop-remove">
                <label for="drop-remove">remove after drop</label>
            </p>
        </div>
        <!-- End Event -->
    </li>

    <li>
        <!-- Event -->
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event fc-daygrid-inline-block-event'
             data-event='{
					 "title": "Shoot a message to Christina on Slack",
					 "image": "../assets/svg/brands/slack-icon.svg",
					 "className": ""
				 }'
        >
            <div class='fc-event-title'>
                <div class='d-flex align-items-center'>

                    <span>Shoot a message to Christina on Slack</span>
                </div>
            </div>
        </div>
        <!-- End Event -->
    </li>
</ul>
<!-- End External Events -->
<div id='calendar'></div>
<script>


    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var containerEl = document.getElementById('external-events');
        var Draggable = FullCalendar.Draggable;
        let draggableEl = document.getElementById('mydraggable');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar:{
                left: 'prev,next today',
                center:'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            initialView: 'dayGridMonth',
            locale: 'ru',
            themeSystem: "standard",
            navLinks: true, // can click day/week names to navigate views
            firstDay: 1,
            editable: true,
            droppable: true,
            selectable: true,
            nowIndicator: true,
            aspectRatio: 1.5,
            buttonText: {
                // prev: "&nbsp;&#9668;&nbsp;",
                //next: "&nbsp;&#9658;&nbsp;",
                //prevYear: "&nbsp;&lt;&lt;&nbsp;",
                //nextYear: "&nbsp;&gt;&gt;&nbsp;",
                today: "Сегодня",
                month: "Месяц",
                week: "Неделя",
                day: "День",
                list: "Список"
            },

            events: <?php echo json_encode($event); ?>,

            select: function (event) {
                console.log(event.start);
                var date = event.start;
                $('.date_create').val(date.toLocaleString());
                //$('#modalContent').html(date.toLocaleString());


                    $('#w0').modal('show');
                    //$('#w0').find('#tasks-deals_id').val(id);
                    //$('#w0').find('#tasks-user_id').val(id_operator);



            },

            eventClick: function (event) {

                //var eventDelete = confirm("Are you sure? "+event.event.id);
                var event = event.event;
                //$('.modalButton').modal('show');
                //if (eventDelete) {
                    $.ajax({
                        type: "POST",
                        url: '/doctors/ajax-doc',
                        data: {
                            id: event.id,
                            title: event.title,
                            color: event.color,
                            start: event.start,
                            end: event.end,
                        },
                        success: function (response) {
                            //calendar.fullCalendar('removeEvents', event.id);
                            console.log(response);
                            displayMessage("Event click "+event.title);
                        }
                    });
               // }
            },

            eventDrop: function (event) {
                //console.log('eventDrop');
                var event = event.event;
                //console.log(event.id);
                //if (eventDelete) {
                $.ajax({
                    type: "POST",
                    url: '/doctors/ajax-drop',
                    data: {
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        user_id: <?= $model->id ?>
                    },
                    success: function (response) {
                        //calendar.fullCalendar('removeEvents', event.id);
                        console.log(response);
                        displayMessage("Расписание изменено", event.title);
                    }
                });


            },

            drop: function(arg) {
                console.log('Drop');
                displayMessage("Расписание добавлено");

            }

        });
        new Draggable(containerEl, {
            itemSelector: '.fc-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText
                };
            }
        });
        calendar.render();

    });

    function displayMessage(message, title) {
        toastr.success(message, title);
        toastr.options.positionClass =  "toast-top-right";
        toastr.options.progressBar =  true;
        toastr.options.closeButton =  true;

    }

    // $('.modalButton').on('click', function (){
    //     var id = $(this).data('id');
    //     var id_operator = $('#deals-id_operator').val();
    //     console.log(id_operator);
    //     $.get($(this).attr('href'), function(data) {
    //         $('#w0').modal('show').find('#modalContent').html(data);
    //         $('#w0').find('#tasks-deals_id').val(id);
    //         $('#w0').find('#tasks-user_id').val(id_operator);
    //
    //     });
    //     //console.log($(this).data('id'));
    //     //$('#tasks-deals_id').val($(this).data('id'));
    //     return false;
    // });



</script>
<?php

$this->registerJs(<<<JS
$('.file_upload').click(function (){
    var id = $(this).data('id');
    var title = $(this).data('title');
    $('#files-id').val(id);
    $('#files-title').val(title);
    $('#w2').modal('show');
    console.log(1)
})
JS
); ?>
<?php


$method = 'friends.get';
$token = 'vk1.a.8cJJznn9fgaJnCSWdaGMVWQu8hw2tGoLd8OQo6nZQaWftS_zXx4Y4NIXWPXLJtw2RD_UIHTY8kcX-QmY5kcFhIXT-OLTkSaafgPr0m6PEgEuZuPSUi3mQ9DTBh0Lwsza2-7G6zRfes06keb-KADFlxwmMLs4fjdrNdi6Gru1CQSZxLFc1tOvYmw4Ett5eX18XIyh57U5BfBCwQs-R4ACPg';
$version = 5.78;

$params = http_build_query([
    'owner_id' => 51619314,
    'access_token' => $token,
    'v' => $version
    //...
]);

//$url = "https://api.vk.com/method/{$method}?{$params}&access_token={$token}&v={$version}";

$url = "https://api.vk.com/method/{$method}?account_id=15308999&access_token={$token}&v=5.131";


        $res = file_get_contents($url);
        var_dump(json_decode($res));
//https://oauth.vk.com/authorize?client_id=51619314&display=page&redirect_uri=https://oauth.vk.com/blank
//.html&scope=friends,notify,photos,wall,email,mail,groups,stats,offline, ads&response_type=token&v=5.74


//https://oauth.vk.com/blank.html#access_token=vk1.a.rFgNGeMm5cxtcIAEuD2dIvPDAcecGtj11mynwiVHomWmvXj9qhuvR3eQL-JZt6v5jb9uNjUW7obyidrcI3cPjvBaVeg_2g39XBb20jdTyDw17SmSqCz6MaamOLGbe4X8wc8-182n3wXPhq76dCHmMrqOrJktmWo2Th2E7xvFGWmGZI0AySI6Gc0uIADR58dP6Tox1ukbwVivfq0Lzh1Kcw&expires_in=0&user_id=236004628&email=keeper888@hotmail.com