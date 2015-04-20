<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = Yii::t('app', 'Contact') . ' | ' . Yii::$app->params['siteName'];
?>
<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center"><?php echo Yii::t('app', 'Contact us'); ?></h2>
                    <div class="status alert alert-success" style="display: none"></div>

                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'class' => 'contact-form row']); ?>
                    <?= $form->field($model, 'name', ['template' => "{input}\n{hint}\n{error}"])->textInput(['maxLength' => 500, 'placeholder' => Yii::t('app', 'Name')]) ?>
                    <?= $form->field($model, 'email', ['template' => "{input}\n{hint}\n{error}"])->textInput(['maxLength' => 500, 'placeholder' => Yii::t('app', 'Email')]) ?>
                    <?= $form->field($model, 'subject', ['template' => "{input}\n{hint}\n{error}"])->textInput(['maxLength' => 500, 'placeholder' => Yii::t('app', 'Subject')]) ?>
                    <?= $form->field($model, 'body', ['template' => "{input}\n{hint}\n{error}"])->textArea(['rows' => 6, 'id' => 'message', 'maxLength' => 1000, 'placeholder' => Yii::t('app', 'Your Message Here')]) ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <div class="social-networks">
                        <h2 class="title text-center"><?php echo Yii::t('app', 'Social Networking'); ?></h2>
                        <ul>
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--/#contact-page-->