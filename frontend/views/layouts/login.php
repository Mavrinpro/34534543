<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
\frontend\assets\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" href="/assets/58d561ed/css/all.min.css">
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <?= Alert::widget() ?>
                </div>
                <div class="col-md-6">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </main>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
