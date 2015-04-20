<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/17/2014
 * Time: 22:04
 */
use frontend\widgets\Section;
?>
<h2><?php echo Yii::t('app', 'Sections'); ?></h2>
<div class="panel-group category-products" id="accordian"><!--category-productsr-->
    <?php if(!empty($categories)){ ?>
        <?php foreach($categories as $key => $category){ ?>
            <?php if(!$category->parent_id){ ?>
                <div class="panel panel-default">
                    <?php if(Section::haveChild($categories, $category->id)){ ?>
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordian" href="<?php echo '#' . $category->title; ?>" class="<?php if(Section::isActive($category->id)) echo 'section_active'; ?>">
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    <?php echo Yii::t('app', $category->title); ?>
                                </a>
                            </h4>
                        </div>
                        <?php Section::theChild($categories, $key); ?>
                    <?php } else { ?>
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="<?php echo Yii::$app->homeUrl . Yii::$app->language . '/section/' . $category->id . '/' . urlencode(Yii::t('app', $category->title)); ?>" class="<?php if(Section::isActive($category->id)) echo 'section_active'; ?>">
                                    <span class="badge pull-right"><i class="fa fa-book"></i></span>
                                    <?php echo Yii::t('app', $category->title); ?>
                                </a>
                            </h4>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>