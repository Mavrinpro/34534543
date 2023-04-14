<?php

use app\models\Event;
use yii2fullcalendar\yii2fullcalendar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">


    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id='calendar'></div>

    <?php Pjax::end();

    ?>

</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar:{
                left:'prevYear today next nextYear',
                center:'title',
                right:'dayGridMonth,dayGridWeek,timeGridDay,listMonth',
            },
            initialView: 'dayGridMonth',
            locale: 'ru',
            firstDay: 1,
            editable: true,
            droppable: true,


            events: [
                {
                    id: 'a',
                    title: 'Расписание',
                    start: '2023-04-12',
                    color: 'red',   // an option!
                    textColor: 'white' // an option!

                }
            ],

            eventClick: function (event) {
                var eventDelete = confirm("Are you sure?");
                if (eventDelete) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/calendar-crud-ajax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event removed");
                        }
                    });
                }
            }
        });
        calendar.render();
    });
    function displayMessage(message) {
        toastr.success(message, 'Event');
    }

</script>