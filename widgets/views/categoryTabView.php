<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 15/1/2015
 * Time: 16:17
 */

use frontend\widgets\Util;
?>
<?php if(!empty($works)){ ?>
    <div class="category-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <?php foreach($works as $key => $category){ ?>
                    <li <?php if($key == 0) echo 'class="active"'; ?>><a href="#<?php echo $key; ?>" data-toggle="tab"><?php echo Yii::t('app', $category['header']); ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php foreach($works as $key => $category){ ?>
                <div class="tab-pane fade <?php if($key == 0) echo 'active'; ?> in" id="<?php echo $key; ?>" >
                    <?php if(!empty($category['body'])){ ?>
                        <?php foreach($category['body'] as $work){ ?>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <input type="hidden" value="<?php echo $work['id']; ?>">
                                            <img class="width_height_cat_tab" src="<?php echo (file_exists(Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'])) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'] : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . $work['sex'] . '.jpg' ; ?>" alt="avatar">
                                            <h2><?php echo $work['price']; ?> $</h2>
                                            <p><?php echo Util::shortTitle($work['title']) ; ?></p>
                                            <a class="btn btn-default add-to-cart buy_work">
                                                <img width="20" src="/images/common/loading.gif" class="loading" alt=""><i class="fa fa-chevron-circle-down"></i><?php echo Yii::t('app', 'Buy'); ?>
                                            </a>
                                            <a href="<?php echo Yii::$app->homeUrl . Yii::$app->language . '/detail/' . $work['id'] . '/' . Util::customUrlEncodeTitle($work['title']); ?>" class="btn btn-default add-to-cart"><i class="fa fa-level-up"></i><?php echo Yii::t('app', 'Detail'); ?></a>
                                        </div>
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
            <?php } ?>
        </div>
    </div><!--/category-tab-->
    <script>
        setInterval(function(){
            $('.width_height_cat_tab').each(function(){
                if($(this).width() >= $(this).height()){
                    $(this).width(180);
                    $(this).css('height', 'auto');
                } else {
                    $(this).css('width', 'auto');
                    $(this).height(160);
                }
            });
        }, 300);
    </script>
<?php } ?>