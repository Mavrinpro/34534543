<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Tags $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tags-view">

    <p>
        <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/tags/', ['class' => 'btn btn-warning btn-sm']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>
<?php
$phone = '8422589265';
function formatPhone($phone){
    $phone = str_split($phone);
    if ($phone[0] == '8'){
        $phone[0] = '7';
    }elseif ($phone[0] == '9'){
        $phone[0] = '7'.$phone[0];
    }elseif ($phone[0].$phone[1].$phone[2] == '8422'){
        $phone[0].$phone[1].$phone[2] = '7'.$phone[0].$phone[1].$phone[2];
    }
    return join('', $phone);
}

//echo formatPhone($phone);

$num = str_split($phone);
$num[0] = '7';
echo formatPhone($phone);



?>
</div>

