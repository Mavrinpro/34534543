<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="fas fa-fingerprint"></i> Изменить пароль', ['user/change-password', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('<i class="fas fa-sign-in-alt"></i> Войти', ['switch-user', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        //'template' => '<div class="mb-2" style="font-size: 20px"> {label} - {value}</div>',
        'attributes' => [
            'id',
            'username',
            'full_name',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            [
              'attribute' => 'status',
                'format' => 'html',
                'value'=> function($model)
                {
                    if ($model->status == 10)
                    {
                        return '<span class="badge badge-success">Активный</span>';
                    }else if($model->status == 9)
                    {
                        return '<span class="badge badge-danger">Не активный</span>';
                    }else{
                        return '<span class="badge badge-danger bg-gray">Удален</span>';
                    }

                },
            ],
            //'created_at',
            [
                'attribute' => 'created_at',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', ($model->created_at));
                }
            ],
            //'updated_at',
            [
                'attribute' => 'updated_at',
                'value' => function($model)
                {
                    return date('d.m.Y H:i:s', ($model->updated_at));
                }
            ],
            //'verification_token',
        ],
    ]) ;
    // сгенерировать пароль
//        $password = 'rEL2bpVR2hVdSc9b8R2L0hwjb';
//    $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
//    echo $hash;
//$called = '8422271131';
//    function formatPhone($num) {
//        $num = preg_replace('/[^0-9]/', '', $num);
//        $len = strlen($num);
//
//        if($len == 11) $num = preg_replace('/([0-9]{1})([0-9]{3})([0-9]{3})/', '7$2$3', $num);
//        //elseif($len == 8) $num = preg_replace('/([0-9]{3})([0-9]{2})([0-9]{3})/', '$1 - $2 $3', $num);
//        //elseif($len == 9) $num = preg_replace('/([0-9]{3})([0-9]{2})([0-9]{2})([0-9]{2})/', '$1 - $2 $3 $4', $num);
//        elseif($len == 10) $num = preg_replace('/([0-9]{3})([0-9]{2})([0-9]{2})([0-9]{3})/', '7$1$2$3$4', $num);
//
//        return $num;
//    }
//    echo formatPhone($called);
    ?>
</div>
