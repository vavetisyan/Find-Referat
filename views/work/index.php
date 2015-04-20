<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/20/14
 * Time: 11:56
 */
use app\models\Works;
use frontend\widgets\Time;
use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\RecommendedWorks;
use frontend\widgets\Util;

$this->title = Yii::t('app', 'My works') . ' | ' . Yii::$app->params['siteName'];
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
                            <td class="width_120"><?php echo Yii::t('app', 'Status'); ?></td>
                            <td class="width_100"><?php echo Yii::t('app', 'Avatar'); ?></td>
                            <td class="width_150"><?php echo Yii::t('app', 'Title'); ?></td>
                            <td class="width_200"><?php echo Yii::t('app', 'Description'); ?></td>
                            <td class="width_50"><?php echo Yii::t('app', 'Price'); ?></td>
                            <td class="width_65"><?php echo Yii::t('app', 'Bought'); ?></td>
                            <td class="width_105"><?php echo Yii::t('app', 'Viewed'); ?></td>
                            <td class="width_100"><?php echo Yii::t('app', 'Work'); ?></td>
                            <td class="width_40"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($myWorks)){ ?>
                            <?php foreach($myWorks as $key => $work){ ?>
                                <tr class="works_tr <?php echo 'work_tr_' . Works::$visible_class[$work->visible]; ?> <?php echo 'work_id_' . $work->id; ?>">
                                    <input type="hidden" name="id" value="<?php echo $work->id; ?>">
                                    <td class="work_status work_cursor" href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <img src="<?php echo '/images/common/' . Works::$visible_class[$work->visible] . '.png'; ?>" alt="" title="<?php echo Yii::t('app', Works::$visible_class[$work->visible]); ?>">
                                    </td>
                                    <td class="works_avatar work_cursor" href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <img src="<?php echo (file_exists(Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/' . Yii::$app->user->identity->getAvatar())) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/' . Yii::$app->user->identity->getAvatar()  : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . Yii::$app->user->identity->getSex() . '.jpg' ; ?>" alt="avatar">
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <h4 class="work_title"><?php echo Util::shortTitle($work->title, 130); ?></h4>
                                    </td>
                                    <td class="work_desc_justify work_cursor"  href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <p class="work_description"><?php echo Util::shortTitle($work->description, 200); ?></p>
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <p class="work_price"><?php echo $work->price; ?></p>
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <p><?php echo $work->buying_count; ?></p>
                                    </td>
                                    <td class="work_cursor" href="#modal-container-<?php echo $work->id; ?>" data-toggle="modal">
                                        <p><?php echo $work->views_count; ?></p>
                                    </td>
                                    <td class="my_works_file">
                                        <a href="/download/<?php echo $work->id; ?>" target="_blank" title="<?php echo Yii::t('app', 'download'); ?>">
                                            <img src="<?php echo '/images/common/default_work.png' ?>" alt="">
                                        </a>
                                    </td>
                                    <td class="work_delete">
                                        <a class="cart_quantity_delete" style="cursor: pointer;" title="<?php echo Yii::t('app', 'delete'); ?>"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <!-- Begin modal -->
                                <div class="modal fade" id="modal-container-<?php echo $work->id; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                <form id="contact-form" class="work_form" action="#" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $work->id; ?>">

                                                    <div class="work_modal_div">
                                                        <h4><?php echo Yii::t('app', 'Status'); ?></h4>
                                                        <p class="<?php echo 'work_tr_' . Works::$visible_class[$work->visible]; ?>">
                                                            <img src="<?php echo '/images/common/' . Works::$visible_class[$work->visible] . '.png'; ?>" alt="">
                                                            <span style="margin-left: 10px"><?php echo Yii::t('app', Works::$visible_class[$work->visible]); ?></span>
                                                        </p>
                                                    </div>
                                                    <div class="work_modal_div">
                                                        <h4><?php echo Yii::t('app', 'Title'); ?></h4>
                                                        <p>
                                                            <input name="title" value="<?php echo $work->title; ?>" class="form-control" maxlength="500">
                                                            <?php //echo $work->title; ?>
                                                        </p>
                                                    </div>
                                                    <div class="work_modal_div">
                                                        <h4><?php echo Yii::t('app', 'Description'); ?></h4>
                                                        <p>
                                                            <textarea name="description" rows="6" class="form-control" maxlength="3000"><?php echo $work->description; ?></textarea>
                                                        </p>
                                                    </div>
                                                    <div class="work_modal_div">
                                                        <h4><?php echo Yii::t('app', 'Price'); ?><span class="price_span price_span<?php echo $key; ?>"></span></h4>
                                                        <p>
                                                            <input type="text" name="price" class="span<?php echo $key; ?> sl2" value="<?php echo $work->price; ?>" data-slider-min="<?php echo Yii::$app->params['workMinPrice']; ?>" data-slider-max="<?php echo Yii::$app->params['workMaxPrice']; ?>" data-slider-value="[<?php echo $work->price; ?>]" style="width: 100%"><br />
                                                            <b>$ <?php echo Yii::$app->params['workMinPrice']; ?></b> <b class="pull-right last_price">$ <?php echo Yii::$app->params['workMaxPrice']; ?></b>
                                                            <?php //echo $work->price; ?>
                                                        </p>
                                                    </div>
                                                </form>
                                                <!-- End content -->

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'Close'); ?></button>
                                                <?php if(Works::isPending($work->visible)){ ?>
                                                    <button type="button" class="btn btn-primary change_work"><?php echo Yii::t('app', 'Save changes'); ?></button>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- End modal -->
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="no_work">
                                    <?php echo Yii::t('app', "You don't have added work"); ?>
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
<?php if(!empty($myWorks)){ ?>
<script>
    setInterval(function(){
        <?php foreach($myWorks as $key => $work){ ?>
        $('.price_span<?php echo $key; ?>').text('$ ' + $('.span<?php echo $key; ?>').val());
        <?php } ?>
    }, 1000);
</script>
<?php } ?>