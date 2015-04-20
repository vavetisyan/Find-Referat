<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 02/17/2015
 * Time: 14:44
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

                                <p><?php echo Yii::t('app', 'In this section you can load your balance. To do this you need to click (Pay now) button, then you will move to the page of the payment system (PayPal), where you will do your transfer. After checking, your balance will be loaded.'); ?></p>

<!--                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
<!--                                    <input type="hidden" name="cmd" value="_s-xclick">-->
<!--                                    <input type="hidden" name="hosted_button_id" value="KZGCV67XAVXPG">-->
<!--                                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">-->
<!--                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">-->
<!--                                </form>-->

                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="WNM8VGF9SGKZJ">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>

                                <div class="col-sm-1">
                                    <h2 class="or"><?php echo Yii::t('app', 'OR'); ?></h2>
                                </div>

                                <div class="col-sm-12">

                                    <p style="margin-top: 80px;margin-bottom: 20px;"><?php echo Yii::t('app', 'In this section, you can transfer your balance to your (PayPal) payment system. To do this you must complete your email address to which you are registered (PayPal) payment system, then you will need to enter how much money you want to transfer. In the end you need to press the transfer button.'); ?></p>

                                    <form action="#" class="transfer_form" method="post" enctype="multipart/form-data">
                                        <span>
                                            <h4><?php echo Yii::t('app', 'Email'); ?>*</h4>
                                            <div class="category_checks transfer_bottom">
                                                <label class="transfer_label">
                                                    <input type="checkbox" name="transfers[email]" value="<?php echo Yii::$app->user->identity->getEmail(); ?>">
                                                    <b><?php echo Yii::t('app', 'Use my email address') . ' (' . Yii::$app->user->identity->getEmail() . ')'; ?></b>
                                                </label>
                                            </div>
                                            <input type="text" name="transfers[paypal_email]" value=""  maxlength="500">

                                            <h4><?php echo Yii::t('app', 'Amount'); ?>*</h4>
                                            <input type="text" name="transfers[money]" value=""  maxlength="10">
                                        </span>
                                        <button type="submit" class="btn">
                                            <img width="20px" src="/images/common/loading.gif" class="loading" alt="">
                                            <?php echo Yii::t('app', 'Transfer'); ?>
                                        </button>
                                    </form>
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