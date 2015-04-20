<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/10/2015
 * Time: 20:25
 */

use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\Slider;
use frontend\widgets\RecommendedWorks;
use frontend\widgets\CategoryTab;

/* @var $this yii\web\View */
$this->title = Yii::t('app', $title) . ' | ' . Yii::$app->params['siteName'];
?>

<?php echo Slider::widget(); //Rendering slider ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">

                    <?php echo Section::widget(['params' => (!empty($params)) ? $params : '']); //Rendering categories ?>

                    <?php echo Aphorism::widget(); //Rendering aphorisms ?>

                    <?php echo Banner::widget(); //Rendering banners ?>

                </div>
            </div>

            <div class="col-sm-9 padding-right">

                <?php
                $isWishList = (!empty($isWishList)) ? $isWishList : false ;
                echo $this->render('//render/works/index', [
                    'title' => $title,
                    'works' => $works,
                    'link' => $link,
                    'pages' => $pages,
                    'currentPage' => $currentPage,
                    'isFirst' => $isFirst,
                    'isLast' => $isLast,
                    'isWishList' => $isWishList,
                ]); //Rendering works ?>

                <?php echo CategoryTab::widget()//Rendering category tab works ?>

                <?php echo RecommendedWorks::widget(); //Rendering recommended works ?>

            </div>
        </div>
    </div>
</section>