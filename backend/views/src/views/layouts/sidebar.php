<?php
use yii\helpers\Html;
$taskCount  = new \app\models\Tasks();
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/backend/web/assets/uploads/img/eye.png" alt="AdminLTE Logo" class="brand-image img-circle
        elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">EYE CRM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info"><?php //$userModel = Yii::$app->user->identity;var_dump($userModel->username); ?>
                <?= Html::a(Yii::$app->user->identity->username, ['user/view',  'id' => Yii::$app->user->identity->getId()], ['class' => 'profile-link']) ?>

            </div>

        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->

        <nav class="mt-2">
            <?php
            \yii\widgets\Pjax::begin(['id' => 'badge']);
            if ($taskCount->overdueTransactions
            () > 0){

                $badgeCount = '<span class="right badge badge-danger" id="countries">'.$taskCount->overdueTransactions
                    ().'</span>';

            }else{
                $badgeCount = '';
            }
            \yii\widgets\Pjax::end();
            $menuItems   = [];
            $menuItems[] = [
                'label' => 'Аналитика',
                'icon' => 'tachometer-alt',
                'badge' => '<span class="right badge badge-info">2</span>',
                'url' => ['site/index'],
//                        'items' => [
                // ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
//                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
//                        ]
                'active'=>\Yii::$app->controller->id == 'site',
                'visible' => Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())
                    ['admin']->name == 'admin' || Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())
                    ['superadmin']->name == 'superadmin',

            ];
            $menuItems[] = ['label' => 'Сделки', 'url' => ['/deals'], 'icon' => 'th', 'badge' => '<span class="right badge badge-warning">New</span>','active'=>$this->context->route == 'deals/index'];
            $menuItems[] = ['label' => 'Поиск', 'url' => ['/deals/search-deals'], 'icon' => 'search',
                'active'=>$this->context->route == 'deals/search-deals'];

             $menuItems[] =['label' => 'Задачи', 'url' => ['/tasks'], 'icon' => 'thumbtack', 'active'=>\Yii::$app->controller->id
                == 'tasks',  'badge' => $badgeCount,];

            $menuItems[] =['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest];
            $menuItems[] =['label' => 'Филиалы', 'url' => ['/branch'], 'iconStyle' => 'fa fa-city',
                'active'=>\Yii::$app->controller->id == 'branch', ];
            $menuItems[] = ['label' => 'Теги', 'url' => ['/tags'], 'iconStyle' => 'fa fa-tags',
                'active'=>\Yii::$app->controller->id == 'tags', ];
            $menuItems[] = ['label' => 'Шаблоны писем', 'url' => ['/layouts-mail/index'], 'iconStyle' => 'fa fa-envelope',
                'active'=>\Yii::$app->controller->id == 'layouts-mail', ];
            $menuItems[] = ['label' => 'Пользователи', 'url' => ['/user'], 'iconStyle' => 'fa fa-user',
                'active'=>\Yii::$app->controller->id == 'user', 'visible' => Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())
                    ['admin']->name == 'admin' || Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())
                    ['superadmin']->name == 'superadmin', ];
            $menuItems[] = ['label' => 'Учет времени', 'url' => ['/tracking'], 'iconStyle' => 'fa fa-history',
                'active'=>\Yii::$app->controller->id == 'tracking', 'visible' => Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())
                    ['admin']->name == 'admin' || Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())
                    ['superadmin']->name == 'superadmin', ];
            $menuItems[] = ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank', 'visible' => Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin'];
            $menuItems[] = ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank', 'visible' => Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin'];


            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => $menuItems,
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php
$js = <<< JS


 function updateList() {
         $.pjax.reload({container: "#badge", async: false});
        }
        setInterval(updateList, 1000);

JS;

$this->registerJs($js);