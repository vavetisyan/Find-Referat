<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/1/2015
 * Time: 01:00
 */
?>
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                        <li data-target="#slider-carousel" data-slide-to="3"></li>
                        <li data-target="#slider-carousel" data-slide-to="4"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>F</span><span class="red">I</span><span>N</span><span class="red">D</span>REFERAT</h1>
                                <h2><?php echo Yii::t('app', 'A variety of work'); ?></h2>
                                <p><?php echo Yii::t('app', 'The possibility of buying or selling in various fields.'); ?></p>
                                <!--<button type="button" class="btn btn-default get">Get it now</button>-->
                            </div>
                            <div class="col-sm-6">
                                <img src="/images/slider/1.png" class="girl img-responsive" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1 style="visibility: hidden"><span>F</span><span class="red">I</span><span>N</span><span class="red">D</span>REFERAT</h1>
                                <h2><?php echo Yii::t('app', 'Confucius'); ?></h2>
                                <p><?php echo Yii::t('app', 'He, who learns but does not think, is lost. He who thinks but does not learn is in great danger.'); ?></p>
                                <!--<button type="button" class="btn btn-default get">Get it now</button>-->
                            </div>
                            <div class="col-sm-6">
                                <img src="/images/slider/2.png" class="girl img-responsive" alt="">
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-12">
                                <img src="/images/slider/3.jpg" class="girl img-responsive" alt="">
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-12">
                                <img src="/images/slider/4.jpg" class="girl img-responsive" alt="" />
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-12">
                                <img src="/images/slider/5.jpg" class="girl img-responsive" alt="" />
                            </div>
                        </div>

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->