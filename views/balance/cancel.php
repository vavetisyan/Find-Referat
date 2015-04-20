<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 02/18/2015
 * Time: 11:29
 */

use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\RecommendedWorks;
use frontend\widgets\Time;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Balance') . ' | ' . Yii::$app->params['siteName'];
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">

                    <?php echo Section::widget(); //Rendering categories ?>

                    <?php echo Aphorism::widget(); //Rendering aphorisms ?>

                    <?php echo Banner::widget(); //Rendering banners ?>

                </div>
            </div>

            <div class="col-sm-9 padding-right">

                <div class="category-tab shop-details-tab"><!--category-tab-->

                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li><a><?php echo Yii::t('app', 'Balance'); ?></a></li>
                        </ul>
                    </div>

                    <div class="tab-content">

                        <div class="tab-pane fade new_work active in" id="reviews" >
                            <div class="col-sm-12">

                                <?php echo Time::widget(); //rendering time ?>

                                <span class="no_work balance_error"><?php echo Yii::t('app', 'Something went wrong.<br>Please try again.'); ?></span>

                            </div>
                        </div>

                    </div>
                </div><!--/category-tab-->

                <?php echo RecommendedWorks::widget(); //Rendering recommended works ?>

            </div>
        </div>
    </div>
</section>