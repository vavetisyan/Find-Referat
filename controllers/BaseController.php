<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Base controller
 */
class BaseController extends Controller
{

    public function init(){
        parent::init();
        $param = Yii::$app->request->get();
        if(isset($param['language']) && self::languageChecker($param['language'])){
            Yii::$app->language = $param['language'];
        } elseif(!Yii::$app->user->isGuest){
            Yii::$app->language = Yii::$app->user->identity->getDefaultLang();
        } else {
            Yii::$app->language = self::setDefaultLanguageByCountry(self::getCountryByIP());
        }
    }

    /**
     * Check is language true
     *
     * @param $language
     * @return bool
     */
    public static function languageChecker($language){
        return array_key_exists($language, Yii::$app->params['languages']);
    }

    /**
     * Check is language true
     *
     * @param $name
     * @return bool
     */
    public static function languageCheckerByName($name){
        return in_array($name, Yii::$app->params['languages']);
    }

    /**
     * @return string
     */
    public static function getCountryByIP(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.hostip.info/country.php?ip=' . $_SERVER['REMOTE_ADDR']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
        $response = curl_exec($ch);

        return $response;
    }

    /**
     * @param $country
     * @return string
     */
    public static function setDefaultLanguageByCountry($country){
        foreach(Yii::$app->params['countriesOfficialLanguage'] as $language => $countries){
            if(in_array($country, $countries)){
                return $language;
            }
        }

        return Yii::$app->params['defaultLanguage'];
    }

}
