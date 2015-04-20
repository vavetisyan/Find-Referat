<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/1/12
 * Time: 00:58
 */

namespace frontend\widgets;


use yii\base\Widget;

class Slider extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('sliderView');
    }
}