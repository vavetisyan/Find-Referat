<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $work_id
 * @property string $created_date
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishlist';
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
     * @return int
     */
    public static function getCountWorks(){
        $sql = 'SELECT count(*) AS `count` FROM `works` w
                  INNER JOIN `wishlist` wl ON w.`id` = wl.`work_id`
                 WHERE wl.user_id = ' . Yii::$app->user->getId() . ' AND w.`visible` = ' . Works::VISIBLE_SUCCESS . ' AND w.`active` = ' . Works::ACTIVE_SUCCESS . '
                 ORDER BY wl.created_date DESC';

        $count = Yii::$app->db->createCommand($sql)->queryOne();

        if(!empty($count['count'])){
            return $count['count'];
        }

        return 0;
    }

    /**
     * @param $limit
     * @return array
     */
    public static function getWorks($limit = null){
        $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                  INNER JOIN `users` u ON w.`user_id` = u.`id`
                  INNER JOIN `wishlist` wl ON w.`id` = wl.`work_id`
                 WHERE wl.user_id = ' . Yii::$app->user->getId() . ' AND w.`visible` = ' . Works::VISIBLE_SUCCESS . ' AND w.`active` = ' . Works::ACTIVE_SUCCESS . '
                 ORDER BY wl.created_date DESC';

        if(!empty($limit)){
            $sql .= ' LIMIT ' . $limit['offset'] . ', ' . $limit['limit'];
        }

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param $work_id
     * @return bool
     */
    public static function isWishListExist($work_id){
        $wishList = Wishlist::findOne(['user_id' => Yii::$app->user->getId(), 'work_id' => $work_id]);

        if(empty($wishList)){
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
