<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/17/14
 * Time: 22:02
 */

namespace frontend\widgets;


use app\models\Categories;
use yii\base\Widget;

class Section extends Widget{

    private static $categories;
    public static $param;
    public $params;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        self::$param = $this->params;
        //Get all categories
        self::$categories = Categories::find()->all();
        return $this->render('sectionView', ['categories' => self::$categories]);
    }

    /**
     * @param $categories
     * @param $id
     * @return bool
     */
    public static function haveChild($categories, $id){
        foreach ($categories as $category) {
            if($category->parent_id == $id){
                return true;
            }
        }

        return false;
    }

    /**
     * @param $categories
     * @param $key
     */
    public static function theChild($categories, $key){
        $html = '<div id="' . $categories[$key]->title . '" class="panel-collapse collapse">';
        $html .= '<div class="panel-body">';
        $html .= '<ul>';

        foreach ($categories as $category) {
            if($category->parent_id == $categories[$key]->id){
                $html .= '<li><a href="' . \Yii::$app->homeUrl . \Yii::$app->language . '/section/' . $category->id  . '/' . urlencode(\Yii::t('app', $category->title)) . '">' . \Yii::t('app', $category->title) . ' </a></li>';
            }
        }

        $html .= '</ul></div></div>';

        echo $html;
    }

    /**
     * Get footer categories view
     */
    public static function getFooter(){
        if(!empty(self::$categories)) {
            foreach (self::$categories as $key => $category) {

                if ($key == 0) {
                    echo '<div class="col-sm-2"><div class="single-widget"><ul class="nav nav-pills nav-stacked">';
                } elseif ($key % 10 == 0 && $key != count(self::$categories)) {
                    echo '</ul></div></div><div class="col-sm-2"><div class="single-widget"><ul class="nav nav-pills nav-stacked">';
                }

                $active = (self::isActive($category->id)) ? 'footer_active' : '';
                echo '<li class="' . $active . '"><a href="' . \Yii::$app->homeUrl . \Yii::$app->language . '/section/' . $category->id . '/' . urlencode(\Yii::t('app', $category->title)) . '">' . \Yii::t('app', $category->title) . ' </a></li>';

                if (count(self::$categories) - 1 == $key) {
                    echo '</ul></div></div>';
                }

            }
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public static function isActive($id){
        if(!empty(self::$param)){
            if(in_array($id, self::$param)){
                return true;
            }
        }

        return false;
    }
}