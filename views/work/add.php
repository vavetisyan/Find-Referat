<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/18/2014
 * Time: 13:39
 */
use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\Time;
use frontend\widgets\RecommendedWorks;

$this->title = Yii::t('app', 'Add new work') . ' | ' . Yii::$app->params['siteName'];
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
                            <li><a><?php echo Yii::t('app', 'Add new work'); ?></a></li>
                        </ul>
                    </div>

                    <div class="tab-content">

                        <div class="tab-pane fade new_work active in" id="reviews" >
                            <div class="col-sm-12">

                                <?php echo Time::widget(); //rendering time ?>

                                <p><?php echo Yii::t('app', 'In this section you can add a new work. To add a new work, you need to upload a work, write a title and a description, select the price and the section. After adding the work, it will be under review, which may be approved or rejected for various reasons. After approving it will appear on the site. You can inform about the different stages in the section of my work.'); ?></p>

                                <form action="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/add" method="post" enctype="multipart/form-data">
                                    <span>

                                        <div class="help-block-error" style="color: #a94442;">
                                            <?php if(!empty($errors['file_name'])){
                                                foreach($errors['file_name'] as $file_name) {
                                                    echo $file_name;
                                                }
                                            } ?>
                                        </div>
                                        <h4><?php echo Yii::t('app', 'Work'); ?>*</h4>
                                        <div class="view_product upload_avatar">
                                            <div id="upload_file_name_span">
                                                <img src="" style="height: 125px" alt="">
                                            </div>
                                            <input type="file" name="work[file_name]" id="file_avatar">
                                        </div>


                                        <div class="help-block-error" style="color: #a94442;">
                                            <?php if(!empty($errors['title'])){
                                                foreach($errors['title'] as $title) {
                                                    echo $title;
                                                }
                                            } ?>
                                        </div>
                                        <h4><?php echo Yii::t('app', 'Title'); ?>*</h4>
                                        <input type="text" name="work[title]" value="<?php if(!empty($work['title'])) echo $work['title']; ?>"  maxlength="500">

                                         <div class="help-block-error" style="color: #a94442;">
                                             <?php if(!empty($errors['description'])){
                                                 foreach($errors['description'] as $description) {
                                                     echo $description;
                                                 }
                                             } ?>
                                         </div>
                                        <h4><?php echo Yii::t('app', 'Description'); ?></h4>
                                        <textarea type="text" name="work[description]" class="work_desc" maxlength="3000"><?php if(!empty($work['description'])) echo $work['description']; ?></textarea>

                                        <div class="help-block-error" style="color: #a94442;">
                                            <?php if(!empty($errors['price'])){
                                                foreach($errors['price'] as $price) {
                                                    echo $price;
                                                }
                                            } ?>
                                        </div>
                                        <div class="price-range"><!--price-range-->
                                            <h4><?php echo Yii::t('app', 'Price'); ?><span class="price_span"></span></h4>
                                            <div class="well">
                                                <input type="text" name="work[price]" class="span2" value="<?php if(!empty($work['price'])) { echo $work['price']; } else { echo Yii::$app->params['workDefaultPrice']; } ?>" data-slider-min="<?php echo Yii::$app->params['workMinPrice']; ?>" data-slider-max="<?php echo Yii::$app->params['workMaxPrice']; ?>" data-slider-value="[<?php if(!empty($work['price'])) { echo $work['price']; } else { echo Yii::$app->params['workDefaultPrice']; } ?>]" id="sl2"  style="width: 100%"><br />
                                                <b>$ <?php echo Yii::$app->params['workMinPrice']; ?></b> <b class="pull-right last_price">$ <?php echo Yii::$app->params['workMaxPrice']; ?></b>
                                            </div>
                                        </div><!--/price-range-->

                                        <div class="help-block-error" style="color: #a94442;">
                                            <?php if(!empty($errors['category'])){
                                                foreach($errors['category'] as $category) {
                                                    echo $category;
                                                }
                                            } ?>
                                        </div>

                                        <div class="category_checks">
                                            <h4><?php echo Yii::t('app', 'Sections'); ?>*</h4>
                                            <?php if(!empty($categories)){ ?>
                                                <?php foreach($categories as $value){ ?>
                                                    <?php if(!Section::haveChild($categories, $value->id)){ ?>
                                                        <label>
                                                            <input type="checkbox" name="work[categories][]" value="<?php echo $value->id; ?>" <?php if(!empty($work['categories']) && in_array($value->id, $work['categories'])) echo 'checked'; ?>>
                                                            <b><?php echo Yii::t('app', $value->title); ?></b>
                                                        </label>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>

                                    </span>
                                    <button type="submit" class="btn btn-default pull-right">
                                        <?php echo Yii::t('app', 'Add'); ?>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div><!--/category-tab-->

                <?php echo RecommendedWorks::widget(); //Rendering recommended works ?>

            </div>
        </div>
    </div>
</section>
<script>
    //Show uploaded image
    window.onload = function() {

        var fileInput = document.getElementById('file_avatar');
        var fileDisplayArea = document.getElementById('upload_file_name_span');


        fileInput.addEventListener('change', function(e) {
            var file = fileInput.files[0];
            var imageType = /image.*/;

            if (!file.type.match(imageType)) {
                var reader = new FileReader();

                reader.onload = function(e) {

                    var img = new Image();
                    img.src = '/images/common/default_work.png';

                    fileDisplayArea.innerHTML = "";
                    fileDisplayArea.appendChild(img);
                };

                reader.readAsDataURL(file);
            } else {
                fileDisplayArea.innerHTML = "<span><?php echo Yii::t('app', 'Wrong format'); ?></span>";
            }
        });

    };

    setInterval(function(){
        $('.price_span').text('$ ' + $('.span2').val());
    }, 1000);

</script>