<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buying_works".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $work_id
 * @property string $created_date
 */
class BuyingWorks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buying_works';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'work_id'], 'required'],
            [['user_id', 'work_id'], 'integer'],
            [['created_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'work_id' => Yii::t('app', 'Work ID'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @param $work_id
     * @return bool
     */
    public static function canIDownloadWork($work_id){
        $work = BuyingWorks::find()
            ->where(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['work_id' => $work_id])
            ->all();

        if(empty($work)){
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public static function getBuyingWorks(){
        $sql = 'SELECT bw.id, bw.created_date, w.id work_id, w.title, w.description, w.price, w.file_name, w.user_id, u.avatar, u.sex
                  FROM buying_works bw
                      INNER JOIN works w ON w.id = bw.work_id
                      INNER JOIN users u ON u.id = w.user_id
                 WHERE bw.user_id = ' . Yii::$app->user->getId() . ' ORDER BY bw.id DESC';

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param $work_id
     * @return bool
     */
    public static function isWorkBought($work_id){
        $boughtWork = BuyingWorks::findOne(['user_id' => Yii::$app->user->getId(), 'work_id' => $work_id]);

        if(empty($boughtWork)){
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getWorkId()
    {
        return $this->work_id;
    }

    /**
     * @param int $work_id
     */
    public function setWorkId($work_id)
    {
        $this->work_id = $work_id;
    }

}
