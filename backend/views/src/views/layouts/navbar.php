<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
$taskCount  = new \app\models\Tasks();
?>
<?php Pjax::begin(['id' => 'alert']); ?>
<?php if (Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())['admin']->name != 'admin' &&
    Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())['superadmin']->name != 'superadmin'){ ?>
    <?php $taskCount->Notyfication($taskCount->overdueTransactions(), $taskCount->overdueTransactions() ) ?>
    <?php } ?>
<?php Pjax::end(); ?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
        <!-- SEARCH FORM -->
    <form class=" ml-3" id="search_form_header">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"
                   id="input_search" name="input_search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="result_search"></div>
    </form>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <div class="ml-2">
            <?php
            $session_start =  \Yii::$app->request->cookies['session_start'];
            if (!empty($session_start)) { ?>
                <?= Html::a('Завершить', ['user/session-end?sessionend=yes'],['class' => 'btn btn-sm btn-success']) ?>
            <?php }else{ ?>
                <?= Html::a('Начать работу', ['user/session-start?sessionstart=yes'], ['class' => 'btn btn-sm btn-danger 
        mr-3 ']) ?>
            <?php } ?>

        </div>
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
<!--        <li class="nav-item dropdown">-->
<!--            <a class="nav-link" data-toggle="dropdown" href="#">-->
<!--                <i class="far fa-comments"></i>-->
<!--                <span class="badge badge-danger navbar-badge">3</span>-->
<!--            </a>-->
<!--            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">-->
<!--                <a href="#" class="dropdown-item">-->
<!--                     Message Start -->
<!--                    <div class="media">-->
<!--                        <img src="--><?//=$assetDir?><!--/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">-->
<!--                        <div class="media-body">-->
<!--                            <h3 class="dropdown-item-title">-->
<!--                                Brad Diesel-->
<!--                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>-->
<!--                            </h3>-->
<!--                            <p class="text-sm">Call me whenever you can...</p>-->
<!--                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                     Message End -->
<!--                </a>-->
<!--                <div class="dropdown-divider"></div>-->
<!--                <a href="#" class="dropdown-item">-->
<!--                     Message Start -->
<!--                    <div class="media">-->
<!--                        <img src="--><?//=$assetDir?><!--/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">-->
<!--                        <div class="media-body">-->
<!--                            <h3 class="dropdown-item-title">-->
<!--                                John Pierce-->
<!--                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>-->
<!--                            </h3>-->
<!--                            <p class="text-sm">I got your message bro</p>-->
<!--                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                     Message End -->
<!--                </a>-->
<!--                <div class="dropdown-divider"></div>-->
<!--                <a href="#" class="dropdown-item">-->
<!--                     Message Start -->
<!--                    <div class="media">-->
<!--                        <img src="--><?//=$assetDir?><!--/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">-->
<!--                        <div class="media-body">-->
<!--                            <h3 class="dropdown-item-title">-->
<!--                                Nora Silvester-->
<!--                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>-->
<!--                            </h3>-->
<!--                            <p class="text-sm">The subject goes here</p>-->
<!--                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                     Message End -->
<!--                </a>-->
<!--                <div class="dropdown-divider"></div>-->
<!--                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>-->
<!--            </div>-->
<!--        </li>-->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <?php \yii\widgets\Pjax::begin(['id' => 'noty']);
                if ($taskCount->overdueTransactions
                () > 0){ ?>
                    <span class="badge badge-danger navbar-badge"><?php  echo
                        $taskCount->overdueTransactions
                        (); ?></span>
               <?php }
                \yii\widgets\Pjax::end(); ?>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header"> Уведомлений: <?php echo $taskCount->overdueTransactions
                    (); ?></span>
                <div class="dropdown-divider"></div>
                <a href="/tasks" class="dropdown-item">
                    <i class="fas fa-thumbtack mr-2"></i> Просроченные задачи <span class="badge badge-danger"><?php \yii\widgets\Pjax::begin(['id' => 'badge']); echo $taskCount->overdueTransactions
                    (); \yii\widgets\Pjax::end();?></span>

                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<?php
$js = <<<JS
   $(".main-header .navbar-nav [href]").each(function () {
    if (this.href === window.location.href) {
        $(this).addClass("active");
    }
});     
JS;
$this->registerJs($js);
        ?>
<?php
if (Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || Yii::$app->authManager->getRolesByUser(Yii::$app->getUser()->identity->getId())['admin']->name == 'admin'){

    $js = <<< JS

function soundClick() {
  var audio = new Audio(); // Создаём новый элемент Audio
  audio.src = '/audio/notify.mp3'; // Указываем путь к звуку "клика"
  audio.autoplay = true; // Автоматически запускаем
  console.log(100)
}
 function updateList() {
         //$.pjax.reload({container: "#badge", async: false});
         //$.pjax.reload({container: "#alert", async: false});
         //$.pjax.reload({container: "#noty", async: false});
        //soundClick();
        }
        //setInterval(updateList, 300000);

var search_form_header = $('#search_form_header');
var input = $('#input_search');
input.on('keyup', function (){
    //console.log(400);
    var data = $(this).serialize();
    
    search_form_header.find('.result_search').html('').css('display', 'none');
    if ($(this).val().length >=3){
    
        $.ajax({
            url: '/deals/search-ajax',
            type: 'GET',
            data: data,
            success: function(res){
                console.log(res); 
                if (res){
                     console.log(res[0].phone);
                     search_form_header.find('.result_search').css('display', 'block').html('<span><a href="/deals/update/'+res[0].id+'">'+res[0].phone+'</a></span>');
                }else{
                    search_form_header.find('.result_search').css('display', 'block').html('Не найдено');
                   console.log('Не найдено'); 
                }
                
            },
            error: function(){
                search_form_header.find('.result_search').html('').css('display', 'none');
                alert('Error!');
            }
        });
        }
        return false;
});
//=======================
$(document).mouseup( function(e){ // событие клика по веб-документу
		var div = search_form_header.find('.result_search'); // тут указываем ID элемента
		if ( !div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0 ) { // и не по его дочерним элементам
			div.hide(); // скрываем его
		}
	});

JS;

    $this->registerJs($js);
    $this->registerJs($js);
}

