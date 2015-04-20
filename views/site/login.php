<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Login') . ' | ' . Yii::$app->params['siteName'];
?>
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2><?php echo Yii::t('app', 'Login to your account'); ?></h2>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'inputOptions' => ($inputOptions = [
                                'class' => ''
                            ])
                        ]]); ?>
                    <?= $form->field($model, 'username', ['template' => "{input}\n{hint}\n{error}"])->textInput(['placeholder' => Yii::t('app', 'Username')]) ?>
                    <?= $form->field($model, 'password', ['template' => "{input}\n{hint}\n{error}"])->passwordInput(['placeholder' => Yii::t('app', 'Password')]) ?>
                    <?= $form->field($model, 'rememberMe')->checkbox(['template' => "<span style='line-height: 10px'>{input}" . Yii::t('app', 'Keep me signed in') . "\n{hint}\n{error}</span><span style='line-height: 10px'>" . Yii::t('app', "If you forgot your password you can <a href='" . Yii::$app->homeUrl . Yii::$app->language . "/request-password-reset' style='color: #fdb45e;'>reset it</a>") . "</span>", 'value' => 0]) ?>

                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-default', 'name' => 'login-button']) ?>

                    <?php ActiveForm::end(); ?>

                </div>
                <!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or"><?php echo Yii::t('app', 'OR'); ?></h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2><?php echo Yii::t('app', 'New User Signup!'); ?></h2>

                    <form id="form-signup" action="<?php echo Yii::$app->homeUrl . Yii::$app->language; ?>/login" method="post" role="form">

                        <input type="hidden" name="_csrf" value="eU5vbi5hV0s2Oh4hTyQwISEkHA1vIC8POBc3IV0WPg8DLToWYjFmOQ==">

                        <div class="form-group field-signup-username">
                            <input type="text" id="signup-username" name="signup[username]" value="<?php if(!empty($signup['username'])) echo $signup['username']; ?>" placeholder="<?php echo Yii::t('app', 'Username') ?>">
                            <p class="help-block help-block-error" style="color: #a94442;">
                                <?php if(!empty($errors['username'])){
                                    foreach($errors['username'] as $username) {
                                        echo $username;
                                    }
                                } ?>
                            </p>
                        </div>

                        <div class="form-group field-signup-password">
                            <input type="password" id="signup-password" name="signup[password]"  value="<?php if(!empty($signup['password'])) echo $signup['password']; ?>" placeholder="<?php echo Yii::t('app', 'Password') ?>">
                            <p class="help-block help-block-error" style="color: #a94442;">
                                <?php if(!empty($errors['password'])){
                                    foreach($errors['password'] as $password) {
                                        echo $password;
                                    }
                                } ?>
                            </p>
                        </div>

                        <div class="form-group field-signup-first_name">
                            <input type="text" id="signup-first_name" name="signup[first_name]" value="<?php if(!empty($signup['first_name'])) echo $signup['first_name']; ?>" placeholder="<?php echo Yii::t('app', 'First name') ?>">
                            <p class="help-block help-block-error" style="color: #a94442;">
                                <?php if(!empty($errors['first_name'])){
                                    foreach($errors['first_name'] as $first_name) {
                                        echo $first_name;
                                    }
                                } ?>
                            </p>
                        </div>

                        <div class="form-group field-signup-last_name">
                            <input type="text" id="signup-last_name" name="signup[last_name]" value="<?php if(!empty($signup['last_name'])) echo $signup['last_name']; ?>" placeholder="<?php echo Yii::t('app', 'Last name') ?>">
                            <p class="help-block help-block-error" style="color: #a94442;">
                                <?php if(!empty($errors['last_name'])){
                                    foreach($errors['last_name'] as $last_name) {
                                        echo $last_name;
                                    }
                                } ?>
                            </p>
                        </div>

                        <div class="form-group field-signup-email">
                            <input type="text" id="signup-email" name="signup[email]" value="<?php if(!empty($signup['email'])) echo $signup['email']; ?>" placeholder="<?php echo Yii::t('app', 'Email') ?>">
                            <p class="help-block help-block-error" style="color: #a94442;">
                                <?php if(!empty($errors['email'])){
                                    foreach($errors['email'] as $email) {
                                        echo $email;
                                    }
                                } ?>
                            </p>
                        </div>

                        <button type="submit" class="btn btn-default" name="signup-button"><?php echo Yii::t('app', 'Signup') ?></button>
                    </form>

                </div>
                <!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->