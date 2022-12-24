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
    ]) ?>
</div>
<form action="" name="messages" method="post">
    <div class="row">
        <label>Name: </label>
        <input type="text" id="nameField" autocomplete="off"  name="fname"/>
    </div>
    <div class="row">
        <label>Text: </label>
        <input type="text" id="textField" autocomplete="off" name="msg"/>
    </div>
    <div class="row"><input type="submit" value="go!"/></div>
</form>
<?php

$js = <<< JS

window.onload = function(){
    let ws = new WebSocket('ws://127.0.0.1:8001');
        var status = document.getElementById('status');
    ws.addEventListener('message', (event) =>{
 console.log('on server '+ event.data);
        //status.innerText += event.data;
    })
        ws.onmessage = function(event){
            let mess = event.data;
            var div = document.getElementById('messages-field');
            var innerDiv = document.createElement('div');
            innerDiv.classList.add('leftmessage');
            var h3 = document.createElement('h3');
            

            document.getElementById('nameField').value = '';
            document.getElementById('textField').value = '';

        };

    document.forms['messages'].onsubmit = function(){

        let message = {
            name: this.fname.value,
            msg: this.msg.value
        }
        status.innerHTML += message.name +' '+ message.msg+'<br>';
        console.log('on server '+ message.name +' '+ message.msg);
        ws.send(JSON.stringify(message));

        return false;
    }
    };

JS;

$this->registerJs($js);
?>
