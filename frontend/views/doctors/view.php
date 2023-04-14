<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Doctors $model */
/** @var app\models\Doctors $ev */
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

echo $form->field($ev, 'date_update')->textInput();

echo $form->field($ev, 'active')->textInput();


echo Html::submitButton('Создать', ['class' => 'btn btn-success', 'name' => 'create_event']);


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
                            end: event.end
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
                        end: event.end
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