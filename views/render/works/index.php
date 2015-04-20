<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/10/2015
 * Time: 20:11
 */

use app\models\Works;
use frontend\widgets\Pagination;
use frontend\widgets\Util;
?>
<!--features_items-->
<div class="features_items">
    <h2 class="title text-center"><?php echo $title; ?></h2>
    <?php if(!empty($works)){ ?>
        <?php foreach($works as $work){ ?>
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <input type="hidden" value="<?php echo $work['id']; ?>">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img class="width_height" src="<?php echo (file_exists(Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'])) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'] : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . $work['sex'] . '.jpg' ; ?>" alt="avatar">
                            <h2><?php echo $work['price']; ?> $</h2>
                            <p><?php echo Util::shortTitle($work['title']); ?></p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-chevron-circle-down"></i><?php echo Yii::t('app', 'Buy'); ?></a>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-level-up"></i><?php echo Yii::t('app', 'Detail'); ?></a>
                        </div>
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <p><?php echo $work['title']; ?></p>
                                <p><?php echo $work['description']; ?></p>
                                <h2><?php echo $work['price']; ?> $</h2>
                                <a class="btn btn-default add-to-cart buy">
                                    <img width="20" src="/images/common/loading.gif" class="loading" alt=""><i class="fa fa-chevron-circle-down"></i><?php echo Yii::t('app', 'Buy'); ?>
                                </a>
                                <a href="<?php echo Yii::$app->homeUrl . Yii::$app->language . '/detail/' . $work['id'] . '/' . Util::customUrlEncodeTitle($work['title']); ?>" class="btn btn-default add-to-cart"><i class="fa fa-level-up"></i><?php echo Yii::t('app', 'Detail'); ?></a>
                            </div>
                        </div>
                        <?php if(Works::isAddedThisWeek($work['created_date'])){ ?>
                            <img src="/images/common/new.png" class="new" alt="">
                        <?php } ?>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li>
                                <?php if(!Yii::$app->user->isGuest){
                                    if(empty($isWishList)){ ?>
                                        <a style="cursor: pointer" class="addtowishlist"><i class="fa fa-plus-square"></i><?php echo Yii::t('app', 'Add to wishlist'); ?></a>
                                    <?php }
                                } ?>
                                <a><i class="fa fa-bullseye"></i><?php echo Yii::t('app', 'Views'); ?>: <?php echo $work['views_count']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="col-sm-3 no_work_cat_tab">
            <?php echo Yii::t('app', 'Is empty'); ?>
        </div>
    <?php } ?>

</div>
<!--features_items-->

<?php echo Pagination::widget([
    'link' => $link,
    'pages' => $pages,
    'currentPage' => $currentPage,
    'isFirst' => $isFirst,
    'isLast' => $isLast,
]); //Rendering pagination ?>