<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_categories".
 *
 * @property integer $id
 * @property integer $work_id
 * @property integer $category_id
 */
class WorkCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_id', 'category_id'], 'required'],
            [['work_id', 'category_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'work_id' => Yii::t('app', 'Work ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public static function getWorkCategories($id){
        $sql = 'SELECT c.id, c.title FROM categories c
                    INNER JOIN work_categories wc ON c.id = wc.category_id
                    INNER JOIN works w ON w.id = wc.work_id
                    WHERE w.id = ' . $id;

        return Yii::$app->db->createCommand($sql)->queryAll();
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

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

}
