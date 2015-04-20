<?php
namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Image
 */
class Image extends Model
{
    /**
     * Finds out if image is valid
     *
     * @param FILES array $image
     * @return boolean
     */
    public static function isImageValid($image)
    {
        if(!empty($image['name']['avatar'])){

            //Validate image type
            $ext = pathinfo($image['name']['avatar'], PATHINFO_EXTENSION);
            if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif' && $ext != 'bmp'){
                return Yii::t('app', 'Image should be in .jpg, .jpeg, .png, .gif or .bmp format.');
            }

            //Validate image size
            if($image['size']['avatar'] > Yii::$app->params['imageMaxSize']){
                return Yii::t('app', 'Image should not exceed 2mb (2048kb).');
            }

            //Validate image dimensions
            $image_info = getimagesize($image["tmp_name"]['avatar']);
            if($image_info[0] < Yii::$app->params['imageMinWidth'] &&
                $image_info[0] > Yii::$app->params['imageMaxWidth'] &&
                $image_info[1] < Yii::$app->params['imageMinHeight'] &&
                $image_info[1] > Yii::$app->params['imageMaxHeight']){
                return Yii::t('app', 'Image size should be greater than 150x150 and less than 1000x1000.');
            }
        }

        return false;
    }

    /**
     * Upload image
     *
     * @param FILES array $image
     * @return string
     */
    public static function uploadImage($image)
    {
        $dir_path = Yii::$app->params['imagePath'] . Yii::$app->user->getId() . '/';

        if (!file_exists($dir_path)) {
            mkdir($dir_path, 0777);
        }

        if(!move_uploaded_file($image["tmp_name"]['avatar'], $dir_path . $image["name"]['avatar'])){
            return false;
        }

        return $image["name"]['avatar'];
    }
}