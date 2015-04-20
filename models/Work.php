<?php
namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Work
 */
class Work extends Model
{
    /**
     * Finds out if work is valid
     *
     * @param FILES array $work
     * @return boolean
     */
    public static function isWorkValid($work)
    {
        if(empty($work['name']['file_name'])){
            return Yii::t('app', 'Work can not be empty.');
        }

        //Validate work type
        $ext = pathinfo($work['name']['file_name'], PATHINFO_EXTENSION);
        if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'bmp' || $ext == 'php' || $ext == 'js' || $ext == 'html' || $ext == 'htm' || $ext == 'css' || $ext == 'phtml' || $ext == 'tpl' || $ext == 'htaccess' || $ext == 'java' || $ext == 'aspx' || $ext == 'exe'){
            return Yii::t('app', 'Format is not valid.');
        }

        //Validate work size
        if($work['size']['file_name'] > Yii::$app->params['workMaxSize']){
            return Yii::t('app', 'Work should not exceed 3mb (3072kb).');
        }

        return false;
    }

    /**
     * Upload work
     *
     * @param FILES array $work
     * @return string
     */
    public static function uploadWork($work)
    {
        $dir_path = Yii::$app->params['workPath'] . Yii::$app->user->getId() . '/';

        if (!file_exists($dir_path)) {
            mkdir($dir_path, 0777);
        }

        if(!move_uploaded_file($work["tmp_name"]['file_name'], $dir_path . $work["name"]['file_name'])){
            return false;
        }

        return $work["name"]['file_name'];
    }

    /**
     * @param $price
     * @return bool
     */
    public static function isPriceValid($price){
        return isset($price) && $price >= Yii::$app->params['workMinPrice'] && $price <= Yii::$app->params['workMaxPrice'];
    }

}