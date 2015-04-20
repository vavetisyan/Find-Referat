<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/9/14
 * Time: 17:00
 */
use frontend\widgets\LanguageSelector;
?>
<div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
        <?php echo $languages[Yii::$app->language]; ?>
        <span class="caret"></span>
    </button>
    <?php unset($languages[Yii::$app->language]); ?>

    <ul class="dropdown-menu">
        <?php foreach($languages as $lang_key => $lang_value){ ?>
            <li class="lang"><a href="<?php echo LanguageSelector::createLanguageUrl($lang_key); ?>"><?php echo $lang_value; ?></a></li>
        <?php } ?>
    </ul>
</div>