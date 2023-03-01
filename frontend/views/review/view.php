<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Api;
use yii\helpers\VarDumper;
/** @var yii\web\View $this */
/** @var app\models\Reviews $model */

$api = new Api();

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reviews-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/review/', ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            'number_card',
            'id_doc',
            'review:html',
            'date_create',
        ],
    ]) ?>

</div>
<?php

$words = preg_split('/\s+/', 'This is a string');
$phoneNumber = '9021212222';
$formattedNumber = preg_replace('/^(\d{3})(\d{3})(\d{2})(\d{2})$/', '+7 ($1) $2-$3-$4', $phoneNumber);
echo $formattedNumber;

VarDumper::dump($api->minDeals(1), $dept = 100, $highlight = true);

$array1 = [2,3,4,5,6];
$array2 = [2,3,4,5,7];
$eewtew = array_diff($array1,$array2 );
//VarDumper::dump($eewtew, $dept = 100, $highlight = true);

