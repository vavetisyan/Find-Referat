<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "works".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $file_name
 * @property double $price
 * @property integer $buying_count
 * @property integer $views_count
 * @property string $visible
 * @property string $active
 * @property string $lang
 * @property string $created_date
 * @property string $updated_date
 */
class Works extends \yii\db\ActiveRecord
{
    const ACTIVE_SUCCESS = 1;

    const VISIBLE_PENDING = 2;
    const VISIBLE_DENY = 0;
    const VISIBLE_SUCCESS = 1;

    const RANDOM_LIMIT = 12;
    const RANDOM_CATEGORY_LIMIT = 4;

    public static $visible_class = [
        2 => 'reviewed',
        1 => 'approved',
        0 => 'rejected'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'works';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['title'], 'required', 'message'=> Yii::t('app', 'Title is required.')],
            [['user_id', 'buying_count', 'views_count'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_date', 'updated_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['file_name'], 'string', 'max' => 1000],
            [['lang'], 'string', 'max' => 3]
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'file_name' => Yii::t('app', 'File Name'),
            'price' => Yii::t('app', 'Price'),
            'buying_count' => Yii::t('app', 'Buying Count'),
            'views_count' => Yii::t('app', 'Views Count'),
            'visible' => Yii::t('app', 'Visible'),
            'active' => Yii::t('app', 'Active'),
            'lang' => Yii::t('app', 'Lang'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }

    /**
     * @param $category_id
     * @return int
     */
    public static function getCountWorks($category_id){
        $sql = 'SELECT count(*) AS `count` FROM `works` w
                  INNER JOIN `work_categories` wc ON w.id = wc.work_id
                  INNER JOIN `categories` c ON c.id = wc.category_id
                 WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . ' AND c.id = ' . $category_id . '
                  ORDER BY w.`id` DESC';

        $count = Yii::$app->db->createCommand($sql)->queryOne();

        if(!empty($count['count'])){
            return $count['count'];
        }

        return 0;
    }

    /**
     * @param int $category_id
     * @param array $limit
     * @return array
     */
    public static function getWorks($category_id = 0, $limit = null){
        if(empty($category_id)){
            $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                      INNER JOIN `users` u ON w.`user_id` = u.`id`
                     WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . ' ORDER BY w.`id` DESC';
        } else {
            $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                      INNER JOIN `work_categories` wc ON w.id = wc.work_id
                      INNER JOIN `categories` c ON c.id = wc.category_id
                      INNER JOIN `users` u ON w.`user_id` = u.`id`
                     WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . ' AND c.id = ' . $category_id . '
                      ORDER BY w.`id` DESC';
        }

        if(!empty($limit)){
            $sql .= ' LIMIT ' . $limit['offset'] . ', ' . $limit['limit'];
        }

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param $title
     * @return int
     */
    public static function getSearchCountWorks($title){
        $sql = 'SELECT COUNT(*) AS `count` FROM `works` w
                 WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . ' AND (w.title like "%' . $title . '%" OR w.description like "%' . $title . '%") ORDER BY w.`id` DESC';

        $count = Yii::$app->db->createCommand($sql)->queryOne();

        if(!empty($count['count'])){
            return $count['count'];
        }

        return 0;
    }

    /**
     * @param $title
     * @param array $limit
     * @return array
     */
    public static function getSearchWorks($title, $limit = null){
        $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                  INNER JOIN `users` u ON w.`user_id` = u.`id`
                 WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . ' AND (w.title like "%' . $title . '%" OR w.description like "%' . $title . '%") ORDER BY w.`id` DESC';

        if(!empty($limit)){
            $sql .= ' LIMIT ' . $limit['offset'] . ', ' . $limit['limit'];
        }

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param int $limit
     * @return array
     */
    public static function getRandomWorks($limit = self::RANDOM_LIMIT){
        $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                  INNER JOIN `users` u ON w.`user_id` = u.`id`
                 WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . '
                 ORDER BY RAND() DESC LIMIT ' . $limit;

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public static function getRandomWorksByCategory($category_id, $limit = self::RANDOM_CATEGORY_LIMIT){
        $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                  INNER JOIN `users` u ON w.`user_id` = u.`id`
                  INNER JOIN `work_categories` wk ON w.`id` = wk.`work_id`
                 WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . '
                  AND wk.category_id = ' . $category_id . '
                  GROUP BY id ORDER BY RAND() LIMIT ' . $limit;

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param int $limit
     * @return array
     */
    public static function getRecommendedWorks($limit = self::RANDOM_LIMIT){
        $sql = 'SELECT w.*, u.first_name, u.last_name, u.avatar, u.sex FROM `works` w
                   INNER JOIN `users` u ON w.`user_id` = u.`id`
                   INNER JOIN `work_categories` wk ON w.`id` = wk.`work_id`
                 WHERE w.`visible` = ' . self::VISIBLE_SUCCESS . ' AND w.`active` = ' . self::ACTIVE_SUCCESS . '
                   AND wk.category_id IN ( SELECT wk.category_id FROM work_categories wk
                                               INNER JOIN works w ON wk.work_id = w.id
                                               INNER JOIN buying_works bw ON bw.work_id = w.id
                                            WHERE bw.user_id = ' . Yii::$app->user->getId() . ' GROUP BY wk.category_id )
                 GROUP BY id ORDER BY RAND() LIMIT ' . $limit;

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param $params
     * @return bool
     */
    public static function validateParams($params){
        return !empty($params['id']) && !empty($params['title']) && isset($params['price']) && isset($params['description']);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function isWorkExist($id){
        $work = Works::findOne(['id' => $id, 'active' => self::ACTIVE_SUCCESS]);

        if(empty($work)){
            return false;
        }

        return true;
    }

    /**
     * @param $work_id
     * @return bool
     */
    public static function isMyWork($work_id){
        $work = Works::find()
            ->where(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['id' => $work_id])
            ->all();

        if(empty($work)){
            return false;
        }

        return true;
    }

    public static function isWorkPending($work_id){
        $work = Works::find()
            ->where(['id' => $work_id])
            ->andWhere(['visible' => self::VISIBLE_PENDING])
            ->all();

        if(empty($work)){
            return false;
        }

        return true;
    }

    /**
     * @param $visible
     * @return bool
     */
    public static function isPending($visible){
        return $visible == self::VISIBLE_PENDING;
    }

    /**
     * @param $date
     * @return bool
     */
    public static function isAddedThisWeek($date){
        $today = date('Y-m-d H:i:s');

        if((strtotime($today) - strtotime($date)) / (60 * 60 * 24) <= 7){
            return true;
        }

        return false;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param string $file_name
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getBuyingCount()
    {
        return $this->buying_count;
    }

    /**
     * @param int $buying_count
     */
    public function setBuyingCount($buying_count)
    {
        $this->buying_count = $buying_count;
    }

    /**
     * @return int
     */
    public function getViewsCount()
    {
        return $this->views_count;
    }

    /**
     * @param int $views_count
     */
    public function setViewsCount($views_count)
    {
        $this->views_count = $views_count;
    }

    /**
     * @return string
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param string $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
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