<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 03/13/15
 * Time: 04:07
 */

namespace frontend\widgets;

use yii\base\Widget;

class Util extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        // Do nothing
    }

    /**
     * @param $title
     * @return string
     */
    public static function customUrlEncodeTitle($title){
        return urlencode(str_replace('/', '', str_replace('?', '', str_replace('&', '', $title))));
    }

    /**
     * @param $title
     * @return string
     */
    public static function shortTitle($title, $limit = 31){
        if(strlen($title) <= $limit){
            return $title;
        }

        $title = trim(mb_substr($title, 0, $limit));
        $arr = explode(' ', $title);

        if(count($arr) > 1){
            unset($arr[count($arr) - 1]);
        }

        $title = implode(' ', $arr);

        return  $title . ' ...';
    }
}