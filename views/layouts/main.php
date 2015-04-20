<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\widgets\LanguageSelector;
use frontend\widgets\Alert;
use frontend\widgets\Section;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="<?php echo Yii::t('app', 'Essay, Essays, Free Essays, Download Essays, Buy Essays, Find Essays, Courseworks, Free Courseworks, Download Courseworks, Buy Courseworks, Diploma works, Free Diploma works, Download Diploma works, Buy Diploma works, Find Diploma works, Theses, Free Thesis, Download the Thesis, Buy Thesis, Find the Thesis, Referat, Find Referat, Free Referat, Download Referat, Buy Referat'); ?>">
    <meta name="author" content="">

    <meta property="og:image" content="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/images/common/default_work.png'; ?>" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="/images/common/favicon.ico">

    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-envelope"></i> <?php echo Yii::$app->params['supportEmail']; ?></a></li>
                                <?php if(!Yii::$app->user->isGuest){ ?>
                                    <li><a href="#"><i class="fa fa-user"></i> <?php echo Yii::$app->user->identity->getUsername(); ?></a></li>
                                    <li><a href="#"><?php echo Yii::t('app', 'Balance'); ?>: $ <span class="balance"><?php echo Yii::$app->user->identity->getBalance(); ?></span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="logo pull-left">
                            <a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>">
                                <img src="/images/common/logo-full.png" alt="logo">
                            </a>
                        </div>
                        <div class="btn-group pull-right">
                            <?php echo LanguageSelector::widget(); ?>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/account" class="<?php if(Yii::$app->controller->id == 'account') echo 'active'; ?>"><i class="fa fa-user"></i> <?php echo Yii::t('app', 'Account'); ?></a></li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/add" class="<?php if(Yii::$app->controller->action->id == 'add') echo 'active'; ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('app', 'Add new work'); ?></a></li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/works" class="<?php if(Yii::$app->controller->id == 'work' && Yii::$app->controller->action->id == 'index') echo 'active'; ?>"><i class="fa fa-star"></i> <?php echo Yii::t('app', 'My works'); ?></a></li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/bought" class="<?php if(Yii::$app->controller->action->id == 'bought') echo 'active'; ?>"><i class="fa fa-star"></i> <?php echo Yii::t('app', 'Bought works'); ?></a></li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/wishlist" class="<?php if(Yii::$app->controller->action->id == 'wish-list') echo 'active'; ?>"><i class="fa fa-eye"></i> <?php echo Yii::t('app', 'Wishlist'); ?></a></li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/balance" class="<?php if(Yii::$app->controller->id == 'balance' && Yii::$app->controller->action->id == 'index') echo 'active'; ?>"><i class="fa fa-usd"></i> <?php echo Yii::t('app', 'Balance'); ?></a></li>
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/login" class="<?php if(Yii::$app->controller->action->id == 'login') echo 'active'; ?>"><i class="fa fa-lock"></i> <?php echo Yii::t('app', 'Login'); ?></a></li>
                                <?php } else { ?>
                                    <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/logout"><i class="fa fa-unlock"></i> <?php echo Yii::t('app', 'Logout'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>" class="<?php if(Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') echo 'active'; ?>"><i class="fa fa-home"></i> <?php echo Yii::t('app', 'Home'); ?></a></li>
                                <li class="dropdown"><a href="#"  class="<?php if(Yii::$app->controller->id == 'account' || Yii::$app->controller->id == 'work' || (Yii::$app->controller->id == 'section' && Yii::$app->controller->action->id == 'wish-list')) echo 'active'; ?>"><i class="fa fa-star-half-empty"></i> <?php echo Yii::t('app', 'Profile'); ?><i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/account" class="<?php if(Yii::$app->controller->id == 'account') echo 'active'; ?>"><i class="fa fa-user"></i> <?php echo Yii::t('app', 'Account'); ?></a></li>
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/add" class="<?php if(Yii::$app->controller->action->id == 'add') echo 'active'; ?>"><i class="fa fa-plus"></i> <?php echo Yii::t('app', 'Add new work'); ?></a></li>
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/works" class="<?php if(Yii::$app->controller->id == 'work' && Yii::$app->controller->action->id == 'index') echo 'active'; ?>"><i class="fa fa-star"></i> <?php echo Yii::t('app', 'My works'); ?></a></li>
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/bought" class="<?php if(Yii::$app->controller->action->id == 'bought') echo 'active'; ?>"><i class="fa fa-star"></i> <?php echo Yii::t('app', 'Bought works'); ?></a></li>
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/wishlist" class="<?php if(Yii::$app->controller->action->id == 'wish-list') echo 'active'; ?>"><i class="fa fa-eye"></i> <?php echo Yii::t('app', 'Wishlist'); ?></a></li>
                                        <?php if (Yii::$app->user->isGuest) { ?>
                                            <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/login"><i class="fa fa-lock"></i> <?php echo Yii::t('app', 'Login'); ?></a></li>
                                        <?php } else { ?>
                                            <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/logout"><i class="fa fa-unlock"></i> <?php echo Yii::t('app', 'Logout'); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#" class="<?php if(Yii::$app->controller->action->id == 'random') echo 'active'; ?>"><i class="fa fa-book"></i> <?php echo Yii::t('app', 'Works'); ?><i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>"><i class="fa fa-files-o"></i> <?php echo Yii::t('app', 'All'); ?></a></li>
                                        <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/random" class="<?php if(Yii::$app->controller->action->id == 'random') echo 'active'; ?>"><i class="fa fa-random"></i> <?php echo Yii::t('app', 'Random'); ?></a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/discussions" class="<?php if(Yii::$app->controller->id == 'discussions') echo 'active'; ?>"><i class="fa fa-edit"></i> <?php echo Yii::t('app', 'Discussions'); ?></a></li>
                                <li><a href="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/contact" class="<?php if(Yii::$app->controller->action->id == 'contact') echo 'active'; ?>"><i class="fa fa-pencil"></i> <?php echo Yii::t('app', 'Contact'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="search_box pull-right">
                            <form action="#" method="post" class="search_form">
                                <input name="search" value="<?php if(!empty(Yii::$app->request->get()['search_title'])) echo Yii::$app->request->get()['search_title']; ?>" type="text" placeholder="<?php echo Yii::t('app', 'Search'); ?>" maxlength="200"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->

    <?= Alert::widget(); ?>
    <?= $content ?>

    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><img src="/images/common/logo-full-186x50.png" alt="logo"></h2>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a>
                                    <div class="iframe-img">
                                        <img src="/images/banner/footer-banner1.png" alt="">
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a>
                                    <div class="iframe-img">
                                        <img src="/images/banner/footer-banner2.png" alt="">
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a>
                                    <div class="iframe-img">
                                        <img src="/images/banner/footer-banner3.png" alt="">
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a>
                                    <div class="iframe-img">
                                        <img src="/images/banner/footer-banner4.png" alt="">
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="/images/common/map.png" alt="map">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">
                <div class="row">

                    <?php echo Section::getFooter(); //Rendering footer categories ?>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left"> findreferat.info. <?php echo date('Y'); ?></p>
                    <p class="pull-right"><?php echo Yii::t('app', 'All rights reserved.'); ?></p>
                </div>
            </div>
        </div>

        <input type="hidden" name="sure_text" value="<?php echo Yii::t('app', 'Are you sure?'); ?>">
        <input type="hidden" name="ok_text" value="<?php echo Yii::t('app', 'OK'); ?>">
        <input type="hidden" name="cancel_text" value="<?php echo Yii::t('app', 'Cancel'); ?>">
        <input type="hidden" name="lang" value="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>">
        <input type="hidden" name="minPrice" value="<?php echo Yii::$app->params['workMinPrice']; ?>">
        <input type="hidden" name="maxPrice" value="<?php echo Yii::$app->params['workMaxPrice']; ?>">

    </footer><!--/Footer-->

    <?php $this->endBody() ?>
    <script type="text/javascript">stLight.options({publisher: "ce6a91eb-240b-41d7-bc32-b076d097e254", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<!--    <script>-->
<!--        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){-->
<!--            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),-->
<!--            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)-->
<!--        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');-->
<!---->
<!--        ga('create', 'UA-60570268-1', 'auto');-->
<!--        ga('send', 'pageview');-->
<!---->
<!--    </script>-->
</body>
</html>
<?php $this->endPage() ?>
