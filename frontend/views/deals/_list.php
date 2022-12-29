<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;



switch ($model->status) {
    case 2:
        $model->status = 'Записан';
        break;
    case 3:
        $model->status = 'Думает';
        break;
}
?>








<div class="col-md-2 dr">
    <div class="block_status border-bottom mb-2 text-center bg-purple"><?= $model->status ?></div>
            <span class="deal_date text_ccc rounded"><?= $model->date_create ?></span>
            <div><a href="/deals/update/2"><?= $model->name ?></a></div>
            <div class="deal_phone"><?= $model->phone ?></div>
            <div class="deal_phone"><?= $model->name ?></div>
            <div class="deal_tag badge badge-pill badge-light d-inline-block border">Заявка с сайта</div>  <div
                    class="ml-auto d-inline-block"><?= $model->deal_sum ?> ₽</div><div class="badge badge-pill
                    badge-danger d-block mt-2"><?= $model->date_create ?></div>

</div></div>



