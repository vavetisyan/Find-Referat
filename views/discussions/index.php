<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 01/28/2015
 * Time: 01:04
 */

use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\RecommendedWorks;
use frontend\widgets\CategoryTab;
use frontend\widgets\Pagination;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Discussions') . ' | ' . Yii::$app->params['siteName'];
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

                <div class="response-area">

                    <div class="blank-arrow">
                        <label class="discussion_name"><?php echo Yii::t('app', 'Your message'); ?></label>
                    </div><br>
                    <textarea name="message" rows="5" maxlength="1000"></textarea><br><br>
                    <a class="btn btn-primary add_message">
                        <img width="20" src="/images/common/loading.gif" class="loading" alt=""><?php echo Yii::t('app', 'Add'); ?>
                    </a>
                    <br><br><br>

                    <ul class="media-list">
                        <?php if(!empty($messages)){ ?>
                            <?php foreach($messages as $message){ ?>
                                <li class="media">
                                    <a class="pull-left">
                                        <img src="<?php echo (file_exists(Yii::$app->params['imagePath'] . $message['user_id'] . '/' . $message['avatar'])) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . $message['user_id'] . '/' . $message['avatar'] : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . $message['sex'] . '.jpg' ; ?>" alt="avatar">
                                    </a>
                                    <div class="media-body">
                                        <ul class="sinlge-post-meta">
                                            <li><i class="fa fa-clock-o"></i><?php echo date("H:i:s",strtotime($message['created_date'])) ?></li>
                                            <li><i class="fa fa-calendar"></i><?php echo date("d M Y",strtotime($message['created_date'])) ?></li>
                                            <li><i class="fa fa-user"></i><?php echo $message['first_name'] . ' ' . $message['last_name']; ?></li>
                                        </ul>
                                        <p><?php echo $message['message']; ?></p>
                                    </div>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div><!--/Response-area-->

                <?php echo Pagination::widget([
                    'link' => $link,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'isFirst' => $isFirst,
                    'isLast' => $isLast,
                ]); //Rendering pagination ?>

                <?php echo RecommendedWorks::widget(); //Rendering recommended works ?>

            </div>
        </div>
    </div>
</section>