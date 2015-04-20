<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name'], 'required', 'message'=> Yii::t('app', 'Name is required.')],
            [['email'], 'required', 'message'=> Yii::t('app', 'Email is required.')],
            [['subject'], 'required', 'message'=> Yii::t('app', 'Subject is required.')],
            [['body'], 'required', 'message'=> Yii::t('app', 'Message is required.')],
            // email has to be a valid email address
            ['email', 'email', 'message' => Yii::t('app', 'Email is not a valid email address.')],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'message' => Yii::t('app', 'The verification code is incorrect.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
