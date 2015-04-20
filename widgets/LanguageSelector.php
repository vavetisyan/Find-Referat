<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/9/14
 * Time: 16:53
 */

namespace frontend\widgets;


use yii\base\Widget;

class LanguageSelector extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('languageSelectorView', ['languages' => \Yii::$app->params['languages']]);
    }

    /**
     * Create language urls
     *
     * @param $language
     * @return mixed|string
     */
    public static function createLanguageUrl($language){
        if(\Yii::$app->request->url == '/' || \Yii::$app->request->url == '/' . \Yii::$app->language) {
            return '/' . $language;
        } elseif(strpos(\Yii::$app->request->url, '/' . \Yii::$app->language . '/') !== false){
            return str_replace('/' . \Yii::$app->language . '/', '/' . $language . '/', \Yii::$app->request->url);
        } else{
            return '/' . $language . '/' . substr(\Yii::$app->request->url, 1);
        }
    }

} 