<?php
//use app\models\Branch;
use dosamigos\chartjs\ChartJs;
use practically\chartjs\Chart;
/** @var yii\web\View $this */
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$this->title = 'Статистика';

?>

    <?php

    $DATA_GRAF   = []; // массив для графика
    $BRANCH_KEYS = []; // Ключи городов, чтобы вытащить потом название города в массив
    $i                    = -1;

    // Метод для рандомизации цветов
    function random_html_color($i = 0)
    {
        $color = array('#FF0F00', '#FF6600', '#FF9E01', '#FCD202', '#F8FF01', '#B0DE09', '#04D215', '#0D8ECF', '#0D52D1', '#2A0CD0', '#8A0CCF', '#CD0D74',
            '#FF0F00', '#FF6600', '#FF9E01', '#FCD202', '#F8FF01', '#B0DE09', '#04D215', '#0D8ECF', '#0D52D1', '#2A0CD0', '#8A0CCF', '#CD0D74');

        return @$color[$i];
    }

    $arr = \app\models\Branch::find()->asArray()->all();
    foreach ($arr as $res) {
        $BRANCH_KEYS[$res['id']] =  $res;
    }

    // Собираем миссив со сгруппированными данными по городу
    $arr = \app\models\Deals::find()->select('COUNT(id) as count, id_filial')->groupBy('id_filial')->asArray()->all();
    foreach ($arr as $res) {
        $i++;
        $DATA_GRAF[] = [
            'color'      => random_html_color($i),
            'city_name'  => $BRANCH_KEYS[$res['id_filial']]['name'],
            'city_count' => $res['count']
        ];
    }
    $DATA_GRAF = json_encode($DATA_GRAF);
    ?>
<div class="row">
<div class="col-md-6">
    <div class="card card-info">
        <div id="chartdiv" style="height: 400px;"></div>
        <div id="legenddiv" class="hidden d-none"></div>
<!--        <div class="card-header">-->
<!--            <h3 class="card-title"><i class="fas fa-tachometer-alt"></i></h3>-->
<!--            <div class="card-tools">-->
<!--                <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
<!--                    <i class="fas fa-minus"></i>-->
<!--                </button>-->
<!--                <button type="button" class="btn btn-tool" data-card-widget="remove">-->
<!--                    <i class="fas fa-times"></i>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
        <div class="card-body">
<!--            <canvas id="myChart2" height="100"></canvas>-->
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card card-info">
        <div class="card-body">
            <?= ChartJs::widget([
                'type' => 'bar',
                'options' => [
                    'height' => 400,
                    'width' => 400
                ],
                'data' => [
                    'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                    'datasets' => [
                        [
                            'label' => "My First dataset",
                            'backgroundColor' => "rgba(179,181,198,0.2)",
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => [65, 59, 90, 81, 56, 55, 40]
                        ],
                        [
                            'label' => "My Second dataset",
                            'backgroundColor' => "rgba(255,99,132,0.2)",
                            'borderColor' => "rgba(255,99,132,1)",
                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(255,99,132,1)",
                            'data' => [28, 48, 40, 19, 96, 27, 100]
                        ]
                    ]
                ]
            ]);
            ?>
<?php $labels = \app\models\Branch::find()->select('name')->all();
$users = \common\models\User::find()->select('username')->orderBy('id')->all();
foreach ($labels as $label)
{
    $arrLabel[] = $label['name']; // Список городов для графика (по филиалам)
}
            foreach ($users as $user)
            {
                $arrUser[] = $user['username']; // Список городов для графика (по филиалам)
            }

$model = new \app\models\Deals();
 Pjax::begin();
//            $form = ActiveForm::begin();
//            echo $form->field($model, 'status')->dropDownList([
//                '0' => 'Активный',
//                '1' => 'Отключен',
//                '2'=>'Удален'
//            ]);
//            ActiveForm::end();
            ?>
            <?= Chart::widget([
                'type' => Chart::TYPE_BAR,
                'labels' => $arrLabel,
                'datasets' => [


                    [
                        'label' => 'По филиалам',
                        'query' => \app\models\Deals::find()
                            ->select('id_filial')
                            ->addSelect('count(*) as data')
                            ->groupBy('id_filial')
                            ->createCommand(),
                        'labelAttribute' => 'id_filial',

                    ],
                ],


            ]);

            echo Chart::widget([
                'type' => Chart::TYPE_BAR,
                'labels' => $arrUser,
                'datasets' => [

                    [
                        'label' => 'По Сотрудникам',
                        'query' => \app\models\Deals::find()
                            ->select('id_operator')
                            ->addSelect('count(*) as data')
                            ->groupBy('id_operator')
                            ->createCommand(),
                        'labelAttribute' => 'id_operator',

                    ],
                ],


            ]);
            Pjax::end();
            ?>
        </div>
    </div>
</div>
</div>
<!--<div class="row">-->
<!--<div class="col-md-6" style="height: 400px;">-->
<!---->
<!--</div>-->
<!--<div class="col-md-6">-->
<!--    <div id="chartdiv2" style="height: 400px;"></div>-->
<!--    <div id="legenddiv3" class="hidden d-none"></div>-->
<!--</div>-->
<!--</div>-->
<?php $this->registerJs(<<<JS
        
     jQuery(function($) {
var chart;
var chartData = $DATA_GRAF;

//console.log(chartData);
am4core.useTheme(am4themes_animated);
am4core.ready(function() {
    
    var chart = am4core.create("chartdiv", am4charts.XYChart);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
   
    chart.tooltip.label.wrap = true;
    
    chart.data = chartData;
    
    
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.dataFields.category = "city_name";
        categoryAxis.renderer.minGridDistance = 40;
        categoryAxis.fontSize = 11;
        
        
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.min = 0;
    //valueAxis.max = 24000;
    valueAxis.strictMinMax = true;
    valueAxis.renderer.minGridDistance = 30;

    let axisBreak = valueAxis.axisBreaks.create();
    //axisBreak.startValue = 300;
    //axisBreak.endValue = 1200;
    axisBreak.breakSize = 0.05;

    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.categoryX = "city_name";
    series.dataFields.valueY = "city_count";
    series.columns.template.tooltipText = "{categoryX}: {valueY}";
    series.columns.template.tooltipY = 0;
    series.columns.template.strokeOpacity = 0;
    

    // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
    series.columns.template.adapter.add("fill", function(fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
    });
    
});
        
 
//    const ctx = document.getElementById('myChart').getContext('2d');
//const myChart = new Chart(ctx, {
//    type: 'bar',
//    data: {
//        labels: $BRANCH_KEYS,
//        datasets: [{
//            label: '# of Votes',
//            data: [12, 19, 3, 5, 2, 3],
//            backgroundColor: [
//                'rgba(255, 99, 132, 0.2)',
//                'rgba(54, 162, 235, 0.2)',
//                'rgba(255, 206, 86, 0.2)',
//                'rgba(75, 192, 192, 0.2)',
//                'rgba(153, 102, 255, 0.2)',
//                'rgba(255, 159, 64, 0.2)'
//            ],
//            borderColor: [
//                'rgba(255, 99, 132, 1)',
//                'rgba(54, 162, 235, 1)',
//                'rgba(255, 206, 86, 1)',
//                'rgba(75, 192, 192, 1)',
//                'rgba(153, 102, 255, 1)',
//                'rgba(255, 159, 64, 1)'
//            ],
//            borderWidth: 1
//        }]
//    },
//    options: {
//        scales: {
//            y: {
//                beginAtZero: true
//            }
//        }
//    }
//});
});
JS
); ?>



