<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="col-md-2 dr">
    <div class="block_status border-bottom mb-2 text-center bg-purple"><?= 2  ?></div>
    <div class="deal_tag badge badge-pill badge-light d-inline-block border"><?= $model->name ?></div>
<div class="badge badge-pill badge-success d-block mt-2"></div>





                <div class="mb-2 dgdfdg" data-id="' . $photo->id . '">
                <div id="item' . $photo->id . '" class="rounded shadow-sm p-2 border position-relative bg-white" data-status="' . $BSTATUS[1] . '" data-id="' . $photo->id . '">
                <span class="deal_date text_ccc"><?= $model->date_create ?></span>
                <div><?= $model->name ?></div>
                <div class="deal_phone"><?= $model->phone ?></div>
                <div class="deal_phone"><?= $model->user->username ?></div>
                <div class="ml-auto d-inline-block"><?= $model->deal_sum ?> ₽</div>
                </div></div>





</div>
