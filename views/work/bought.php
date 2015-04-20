<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 01/06/15
 * Time: 13:31
 */
use frontend\widgets\Time;
use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\RecommendedWorks;
use frontend\widgets\Util;

$this->title = Yii::t('app', 'Bought works') . ' | ' . Yii::$app->params['siteName'];
?>
<section id="cart_items">
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

                <div id="reviews" class="work_text">
                    
                    <?php echo Time::widget(); //rendering time ?>

                    <!--<p>Lorem ipsum dolor sit amet.</p>-->
                </div>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="cart_menu">
                            <td class="width_100"><?php echo Yii::t('app', 'Avatar'); ?></td>
                            <td class="width_150"><?php echo Yii::t('app', 'Title'); ?></td>
                            <td class="width_200"><?php echo Yii::t('app', 'Description'); ?></td>
                            <td class="width_50"><?php echo Yii::t('app', 'Price'); ?></td>
                            <td class="width_70"><?php echo Yii::t('app', 'Date'); ?></td>
                            <td class="width_100"><?php echo Yii::t('app', 'Work'); ?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($bought)){ ?>
                            <?php foreach($bought as $work){ ?>
                                <tr class="works_tr">
                                    <td class="works_avatar work_cursor" href="#modal-container-<?php echo $work['id']; ?>" data-toggle="modal">
                                        <img src="<?php echo (file_exists(Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'])) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'] : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . $work['sex'] . '.jpg' ; ?>" alt="avatar">
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work['id']; ?>" data-toggle="modal">
                                        <h4 class="work_title"><?php echo Util::shortTitle($work['title'], 130); ?></h4>
                                    </td>
                                    <td class="work_desc_justify work_cursor" href="#modal-container-<?php echo $work['id']; ?>" data-toggle="modal">
                                        <p class="work_description"><?php echo Util::shortTitle($work['description'], 200); ?></p>
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work['id']; ?>" data-toggle="modal">
                                        <p class="work_price"><?php echo $work['price']; ?></p>
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work['id']; ?>" data-toggle="modal">
                                        <p><?php echo $work['created_date']; ?></p>
                                    </td>
                                    <td class="my_works_file">
                                        <a href="/download/<?php echo $work['work_id']; ?>" target="_blank" title="<?php echo Yii::t('app', 'download'); ?>">
                                            <img src="<?php echo '/images/common/default_work.png' ?>" alt="">
                                        </a>
                                    </td>
                                </tr>
                                <!-- Begin modal -->
                                <div class="modal fade" id="modal-container-<?php echo $work['id']; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel" style="color: #696763">
                                                    <?php echo Yii::t('app', 'Work'); ?>
                                                </h4>
                                            </div>
                                            <div class="modal-body" style="overflow-y: auto; height: 400px;padding-top: 0">

                                                <!-- Begin content -->
                                                <div class="work_modal_div">
                                                    <p>
                                                        <img class="bought_img" src="<?php echo (file_exists(Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'])) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . $work['user_id'] . '/' . $work['avatar'] : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . $work['sex'] . '.jpg' ; ?>" alt="avatar">
                                                    </p>
                                                </div>
                                                <div class="work_modal_div">
                                                    <h4><?php echo Yii::t('app', 'Title'); ?></h4>
                                                    <p>
                                                        <div class="bought_text"><?php echo $work['title']; ?></div>
                                                    </p>
                                                </div>
                                                <?php if(!empty($work['description'])){ ?>
                                                    <div class="work_modal_div">
                                                        <h4><?php echo Yii::t('app', 'Description'); ?></h4>
                                                        <p>
                                                            <div class="bought_text"><?php echo $work['description']; ?></div>
                                                        </p>
                                                    </div>
                                                <?php } ?>
                                                <div class="work_modal_div">
                                                    <h4><?php echo Yii::t('app', 'Price'); ?><span class="price_span"><?php echo $work['price']; ?> $</span></h4>
                                                </div>
                                                <!-- End content -->

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'Close'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End modal -->
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="no_work">
                                    <?php echo Yii::t('app', "You don't have bought works"); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php echo RecommendedWorks::widget(); //Rendering recommended works ?>

            </div>
        </div>

    </div>
</section> <!--/#cart_items-->