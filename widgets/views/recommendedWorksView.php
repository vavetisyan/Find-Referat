<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 13/1/2015
 * Time: 22:06
 */
use frontend\widgets\Util;
?>
<?php if(!empty($recommendedWorks)){ ?>
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center"><?php echo Yii::t('app', 'recommended works'); ?></h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php $i = 0;
                foreach($recommendedWorks as $work){
                    if($i == 0){
                        echo '<div class="item active">';
                    } elseif ($i % 3 == 0 && $i != count($recommendedWorks)-1){
                        echo '</div><div class="item">';
                    } ?>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <input type="hidden" value="<?php echo $work['id']; ?>">
                                    <img class="width_height_rec" src="<?php echo (file_exists(Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'])) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'] : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . $work['sex'] . '.jpg' ; ?>" alt="avatar">
                                    <h2><?php echo $work['price']; ?> $</h2>
                                    <p><?php echo Util::shortTitle($work['title']); ?></p>
                                    <a class="btn btn-default add-to-cart buy_work">
                                        <img width="20" src="/images/common/loading.gif" class="loading" alt=""><i class="fa fa-chevron-circle-down"></i><?php echo Yii::t('app', 'Buy'); ?>
                                    </a>
                                    <a href="<?php echo Yii::$app->homeUrl . Yii::$app->language . '/detail/' . $work['id'] . '/' . Util::customUrlEncodeTitle($work['title']); ?>" class="btn btn-default add-to-cart"><i class="fa fa-level-up"></i><?php echo Yii::t('app', 'Detail'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if(count($recommendedWorks)-1 == $i){
                        echo '</div>';
                    }
                    $i++;
                } ?>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div><!--/recommended_items-->
    <script>
        setInterval(function(){
            $('.width_height_rec').each(function(){
                if($(this).width() >= $(this).height()){
                    $(this).width(180);
                    $(this).css('height', 'auto');
                } else {
                    $(this).css('width', 'auto');
                    $(this).height(160);
                }
            });
        }, 200);
    </script>
<?php } ?>