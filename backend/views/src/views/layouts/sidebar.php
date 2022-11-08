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
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username; ?></a>
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
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Аналитика',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">2</span>',
                        'url' => ['site/index'],
//                        'items' => [
//                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
//                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
//                        ]
                    ],
                    ['label' => 'Сделки', 'url' => ['/deals'], 'icon' => 'th', 'badge' => '<span class="right badge badge-warning">New</span>','active'=>\Yii::$app->controller->id == 'deals'],
                    ['label' => 'Задачи', 'url' => ['/tasks'], 'icon' => 'thumbtack', 'active'=>\Yii::$app->controller->id
                    == 'tasks'],
                    //['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    //['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
                    ['label' => 'Филиалы', 'url' => ['/branch'], 'iconStyle' => 'fa fa-city',
                        'active'=>\Yii::$app->controller->id == 'branch', ],
                    ['label' => 'Теги', 'url' => ['/tags'], 'iconStyle' => 'fa fa-tags',
                        'active'=>\Yii::$app->controller->id == 'tags', ],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
//                    [
//                        'label' => 'Level1',
//                        'items' => [
//                            ['label' => 'Level2', 'iconStyle' => 'far'],
//                            [
//                                'label' => 'Level2',
//                                'iconStyle' => 'far',
//                                'items' => [
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
//                                ]
//                            ],
//                            ['label' => 'Level2', 'iconStyle' => 'far']
//                        ]
//                    ],
                    //['label' => 'Level1'],
                    //['label' => 'LABELS', 'header' => true],
                    //['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    //['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    //['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>