<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 13/1/15
 * Time: 22:04
 */

namespace frontend\widgets;


use app\models\Categories;
use app\models\Works;
use yii\base\Widget;

class RecommendedWorks extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if(\Yii::$app->user->isGuest){
            $recommendedWorks = Works::getRandomWorks();
        } else {
            $recommendedWorks = Works::getRecommendedWorks();
        }

        return $this->render('recommendedWorksView', ['recommendedWorks' => $recommendedWorks]);
    }
}