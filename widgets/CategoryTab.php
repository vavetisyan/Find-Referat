<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 15/1/15
 * Time: 16:15
 */

namespace frontend\widgets;

use app\models\Categories;
use app\models\Works;
use frontend\models\Work;
use yii\base\Widget;

class CategoryTab extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $categories = Categories::find()->orderBy('RAND()')->limit(Categories::RANDOM_CATEGORY_LIMIT)->all();
        $works = [];

        if(!empty($categories)) {
            foreach ($categories as $key => $category) {
                $works[$key]['header'] = $category->title;
                $works[$key]['body']   = Works::getRandomWorksByCategory($category->id);
            }
        }

        return $this->render('categoryTabView', ['works' => $works]);
    }
}