<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfers".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property string $paypal_email
 * @property double $money
 * @property integer $completed
 * @property string $created_date
 * @property string $updated_date
 */
class Transfers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paypal_email'], 'required', 'message'=> Yii::t('app', 'Email is required.')],
            [['money'], 'required', 'message'=> Yii::t('app', 'Amount is required.')],
            [['user_id', 'email', 'paypal_email', 'money'], 'required'],
            [['paypal_email'], 'email', 'message' => Yii::t('app', 'Email is not a valid email address.')],
            [['user_id', 'completed'], 'integer'],
            [['money'], 'integer', 'message' => Yii::t('app', 'Amount must be a number.')],
            [['created_date', 'updated_date'], 'safe'],
            [['email', 'paypal_email'], 'string', 'max' => 255]
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
            'email' => Yii::t('app', 'Email'),
            'paypal_email' => Yii::t('app', 'Paypal Email'),
            'money' => Yii::t('app', 'Money'),
            'completed' => Yii::t('app', 'Completed'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }

    /**
     * @param $money
     * @return bool
     */
    public static function validateMoney($money){
        return !empty($money) && $money <= Yii::$app->user->identity->getBalance() && $money > Yii::$app->params['workMinPrice'];
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPaypalEmail()
    {
        return $this->paypal_email;
    }

    /**
     * @param string $paypal_email
     */
    public function setPaypalEmail($paypal_email)
    {
        $this->paypal_email = $paypal_email;
    }

    /**
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param float $money
     */
    public function setMoney($money)
    {
        $this->money = $money;
    }

    /**
     * @return int
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param int $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
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
