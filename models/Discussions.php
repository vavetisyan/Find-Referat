<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discussions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property integer $is_show
 * @property string $created_date
 */
class Discussions extends \yii\db\ActiveRecord
{
    const IS_SHOW_TRUE  = 1;
    const IS_SHOW_FALSE = 0;
    const MESSAGE_LIMIT = 1000;
    const DISPLAY_ITEMS_COUNT = 15;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discussions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id', 'is_show'], 'integer'],
            [['message'], 'string'],
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
            'message' => Yii::t('app', 'Message'),
            'is_show' => Yii::t('app', 'Is Show'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @param $limit
     * @return array
     */
    public static function getMessages($limit = null){
        $sql = 'SELECT d.*, u.first_name, u.last_name, u.avatar, u.sex FROM `discussions` d
                      INNER JOIN `users` u ON d.`user_id` = u.`id`
                     WHERE d.`is_show` = ' . self::IS_SHOW_TRUE . ' ORDER BY d.`created_date` DESC';

        if(!empty($limit)){
            $sql .= ' LIMIT ' . $limit['offset'] . ', ' . $limit['limit'];
        }

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param $param
     * @return bool
     */
    public static function validateParam($param){
        return !empty($param['message']) && strlen(trim($param['message'])) <= self::MESSAGE_LIMIT;
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
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getIsShow()
    {
        return $this->is_show;
    }

    /**
     * @param int $is_show
     */
    public function setIsShow($is_show)
    {
        $this->is_show = $is_show;
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param string $created_date
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = $created_date;
    }
}
