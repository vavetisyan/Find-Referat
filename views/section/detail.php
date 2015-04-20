<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/17/15
 * Time: 00:48
 */
use frontend\widgets\RecommendedWorks;
use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\Time;
use frontend\controllers\SectionController;

$this->title = Yii::t('app', $title) . ' | ' . Yii::$app->params['siteName'];
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">

                    <?php echo Section::widget(['params' => SectionController::createArrayFromCategories($work_categories)]); //Rendering categories ?>

                    <?php echo Aphorism::widget(); //Rendering aphorisms ?>

                    <?php echo Banner::widget(); //Rendering banners ?>

                </div>
            </div>

            <div class="col-sm-9 padding-right">

                <div class="category-tab shop-details-tab"><!--category-tab-->

                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li><a><?php echo Yii::t('app', 'Detail'); ?></a></li>
                        </ul>
                    </div>

                    <div class="tab-content">

                        <div class="tab-pane fade new_work active in" id="reviews" >
                            <div class="col-sm-12">
                                <input type="hidden" value="<?php echo $work['id']; ?>">

                                <?php echo Time::widget(); //rendering time ?>

                                <div class="detail_cat">
                                    <?php foreach($work_categories as $category) { ?>
                                        <a href="<?php echo Yii::$app->homeUrl . Yii::$app->language . '/section/' . $category['id'] . '/' . urlencode(Yii::t('app', $category['title'])); ?>"><?php echo Yii::t('app', $category['title']); ?></a>
                                    <?php } ?>
                                </div>

                                <h4><?php echo Yii::t('app', 'Work'); ?></h4>
                                <div>
                                    <img src="/images/common/default_work.png" style="height: 90px" alt="">
                                </div>

                                <div class="price-range"><!--price-range-->
                                    <h4><?php echo Yii::t('app', 'Price'); ?><span class="price_span">$ <?php if(isset($work['price'])) echo $work['price']; ?></span></h4>
                                </div><!--/price-range-->

                                <h4 class="detail_h4"><?php echo Yii::t('app', 'Title'); ?></h4>
                                <div class="detail_content detail_content_title"><?php if(!empty($work['title'])) echo $work['title']; ?></div>

                                <h4 class="detail_h4"><?php echo Yii::t('app', 'Description'); ?></h4>
                                <textarea class="detail_content detail_content_desc" readonly><?php if(!empty($work['description'])) echo $work['description']; ?></textarea>

                                <button type="submit" class="btn btn-default pull-right detail_h4 buy_work">
                                    <img width="20" src="/images/common/loading.gif" class="loading" alt=""><i class="fa fa-chevron-circle-down"></i> <?php echo Yii::t('app', 'Buy'); ?>
                                </button>

                                <div class="btn" style="width: 100%">
                                    <!-- Begin fb share -->
                                    <span class='st_facebook_hcount' displayText='Facebook'></span>
                                    <!-- End fb share -->

                                    <!-- Begin twitter share -->
                                    <span class='st_twitter_hcount' displayText='Tweet'></span>
                                    <!-- End twitter share -->

                                    <!-- Begin linkedin share -->
                                    <span class='st_linkedin_hcount' displayText='LinkedIn'></span>
                                    <!-- End linkedin share -->

                                    <!-- Begin google+ share -->
                                    <span class='st_googleplus_hcount' displayText='Google +'></span>
                                    <!-- End google+ share -->
                                </div>

                            </div>
                        </div>

                    </div>
                </div><!--/category-tab-->

                <?php echo RecommendedWorks::widget(); //Rendering recommended works ?>

            </div>
        </div>
    </div>
</section>