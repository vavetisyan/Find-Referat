<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 01/30/15
 * Time: 17:22
 */

namespace frontend\widgets;

use yii\base\Widget;

class Aphorism extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('aphorismView');
    }
}