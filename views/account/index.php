<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 11/30/2014
 * Time: 23:39
 */
use frontend\widgets\Section;
use frontend\widgets\Aphorism;
use frontend\widgets\Banner;
use frontend\widgets\Time;
use frontend\widgets\RecommendedWorks;

$this->title = Yii::t('app', 'Account') . ' | ' . Yii::$app->params['siteName'];
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
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="<?php echo (file_exists(Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/' . Yii::$app->user->identity->getAvatar())) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/' . Yii::$app->user->identity->getAvatar()  : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . Yii::$app->user->identity->getSex() . '.jpg' ; ?>" alt="avatar">
        </div>
    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <h2><?php echo Yii::$app->user->identity->getFirstName() . ' ' . Yii::$app->user->identity->getLastName(); ?></h2>
            <p><?php echo Yii::$app->user->identity->getEmail(); ?></p>

            <span>
                <label><?php echo Yii::t('app', 'Balance'); ?>:</label>
                <span> $ <?php echo Yii::$app->user->identity->getBalance(); ?></span>
            </span>

            <p><b><?php echo Yii::t('app', 'Count of all your added works:'); ?> <span class="account_count"><?php echo $added_works_count; ?></span></b></p>
            <p><b><?php echo Yii::t('app', 'Count of all your bought works:'); ?> <span class="account_count"><?php echo $buying_works_count; ?></span></b></p>
            <p><b><?php echo Yii::t('app', 'Count of views of all your added works:'); ?> <span class="account_count"><?php echo (empty($views_count)) ? 0 : $views_count; ?></span></b></p>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li <?php if($active_tab == 'profile') echo 'class="active"'; ?>><a href=".profile" data-toggle="tab"><?php echo Yii::t('app', 'Profile'); ?></a></li>
            <li <?php if($active_tab == 'settings') echo 'class="active"'; ?>><a href=".reviews" data-toggle="tab"><?php echo Yii::t('app', 'Settings'); ?></a></li>
        </ul>
    </div>
    <div class="tab-content">

        <div class="tab-pane fade profile <?php if($active_tab == 'profile') echo 'active in'; ?>" id="reviews" >
            <div class="col-sm-12">

                <?php echo Time::widget(); //rendering time ?>

                <p><?php echo Yii::t('app', 'In this section you can change your account data: the picture, the first name, the last name, the gender, the username and the password. After making changes, click Change button to confirm. To change the username and the password, go to Settings section.<br><br>All fields are required.'); ?></p>

                <form action="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/account" method="post" enctype="multipart/form-data">
                    <span>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['avatar'])){
                                foreach($errors['avatar'] as $avatar) {
                                    echo $avatar;
                                }
                            } ?>
                        </div>
                        <div class="view_product upload_avatar">
                            <div id="upload_avatar_span">
                                <img src="<?php echo (file_exists(Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/' . Yii::$app->user->identity->getAvatar())) ? Yii::$app->homeUrl . Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/' . Yii::$app->user->identity->getAvatar()  : Yii::$app->homeUrl . Yii::$app->params['imagePath'] . '0/default_avatar_' . Yii::$app->user->identity->getSex() . '.jpg' ; ?>" alt="avatar">
                            </div>
                            <input type="file" name="profile[avatar]" id="file_avatar">
                        </div>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['first_name'])){
                                foreach($errors['first_name'] as $first_name) {
                                    echo $first_name;
                                }
                            } ?>
                        </div>
                        <input type="text" name="profile[first_name]" value="<?php echo Yii::$app->user->identity->getFirstName(); ?>"/>
                        <b><?php echo Yii::t('app', 'First name'); ?></b>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['last_name'])){
                                foreach($errors['last_name'] as $last_name) {
                                    echo $last_name;
                                }
                            } ?>
                        </div>
                        <input type="text" name="profile[last_name]" value="<?php echo Yii::$app->user->identity->getLastName(); ?>"/>
                        <b><?php echo Yii::t('app', 'Last name'); ?></b>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['email'])){
                                foreach($errors['email'] as $email) {
                                    echo $email;
                                }
                            } ?>
                        </div>
                        <input type="text" name="profile[email]" value="<?php echo Yii::$app->user->identity->getEmail(); ?>"/>
                        <b><?php echo Yii::t('app', 'Email'); ?></b>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['sex'])){
                                foreach($errors['sex'] as $sex) {
                                    echo $sex;
                                }
                            } ?>
                        </div>
                        <select name="profile[sex]">
                            <option value="male" <?php if(Yii::$app->user->identity->getSex() == 'male') echo 'selected'; ?>><?php echo Yii::t('app', 'Male'); ?></option>
                            <option value="female" <?php if(Yii::$app->user->identity->getSex() == 'female') echo 'selected'; ?>><?php echo Yii::t('app', 'Female'); ?></option>
                        </select>
                        <b><?php echo Yii::t('app', 'Sex'); ?></b>
                    </span>
                    <button type="submit" class="btn btn-default pull-right">
                        <?php echo Yii::t('app', 'Change'); ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="tab-pane fade reviews <?php if($active_tab == 'settings') echo 'active in'; ?>" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a style="text-transform: none"><i class="fa fa-user"></i><?php echo Yii::$app->user->identity->getUsername(); ?></a></li>
                    <li><a><i class="fa fa-clock-o"></i><span class="clock_time"></span></a></li>
                    <li><a><i class="fa fa-calendar-o"></i><?php echo date("d M Y"); ?></a></li>
                </ul>

                <p><?php echo Yii::t('app', 'In this section you can change your account data: the username and the password. After making changes, click Change button to confirm.<br><br>All fields are required.'); ?></p>

                <form action="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/account" method="post">
                    <span>
                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['username'])){
                                foreach($errors['username'] as $username) {
                                    echo $username;
                                }
                            } ?>
                        </div>
                        <input type="text" name="settings[username]" value="<?php echo Yii::$app->user->identity->getUsername(); ?>"/>
                        <b><?php echo Yii::t('app', 'Username'); ?></b>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['password'])){
                                foreach($errors['password'] as $password) {
                                    echo $password;
                                }
                            }
                            if(!empty($errors['old_password'])){
                                echo $errors['old_password'];
                            } ?>
                        </div>
                        <input type="password" name="settings[old_password]"/>
                        <b><?php echo Yii::t('app', 'Old password'); ?></b>

                        <div class="help-block-error" style="color: #a94442;">
                            <?php if(!empty($errors['password'])){
                                foreach($errors['password'] as $password) {
                                    echo $password;
                                }
                            } ?>
                        </div>
                        <input type="password" name="settings[new_password]"/>
                        <b><?php echo Yii::t('app', 'New password'); ?></b>
                    </span>
                    <button type="submit" class="btn btn-default pull-right">
                        <?php echo Yii::t('app', 'Change'); ?>
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
        var fileDisplayArea = document.getElementById('upload_avatar_span');


        fileInput.addEventListener('change', function(e) {
            var file = fileInput.files[0];
            var imageType = /image.*/;

            if (file.type.match(imageType)) {
                var reader = new FileReader();

                reader.onload = function(e) {

                    var img = new Image();
                    img.src = reader.result;

                    fileDisplayArea.innerHTML = "";
                    fileDisplayArea.appendChild(img);
                };

                reader.readAsDataURL(file);
            } else {
                fileDisplayArea.innerHTML = "<span><?php echo Yii::t('app', 'Wrong format'); ?></span>";
            }
        });

    };
</script>