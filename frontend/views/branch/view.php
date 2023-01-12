<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Branch $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branch-view">

    <p>
        <?= Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btn 
        btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Все', '/branch/', ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>
<?php $url = 'https://clinic-abc.ru/services/';

$newUrl = explode('/', $url);

$newDomen = explode('.', $newUrl[2]);
echo '<pre>';
print_r($newDomen);



// Отправка данный через Rest Api
//$url = 'http://clinic.loc/sup/get-glazcentre';
//$array = [
//    'name' => 'Иван',
//    'full_name' => 'Иванов',
//    'company' => 'Glazcentre-TRASH',
//    'age' => 35,
//    'phone' => '79032343238'
//];
//
//// use key 'http' even if you send the request to https://...
//$options = array('http' => array(
//    'method'  => 'POST',
//    'content' => http_build_query($array)
//));
//
//$context  = stream_context_create($options);
//$result = file_get_contents($url, false, $context);

//file_put_contents('http://clinic.loc/sup/get-glazcentre', true);

?>
</div>
