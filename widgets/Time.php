<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/24/14
 * Time: 16:02
 */

namespace frontend\widgets;


use yii\base\Widget;

class Time extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('timeView');
    }
}