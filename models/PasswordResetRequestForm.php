<?php
namespace frontend\models;

use Yii;
use app\models\Users;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'filter', 'filter' => 'trim'],
            [['email'], 'required', 'message'=> Yii::t('app', 'Email is required.')],
            [['email'], 'email', 'message' => Yii::t('app', 'Email is not a valid email address.')],
            [['email'], 'exist',
                'targetClass' => '\app\models\Users',
                'filter' => ['active' => Users::STATUS_ACTIVE],
                'message' => Yii::t('app', 'There is no user with such email.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user Users */
        $user = Users::findOne([
            'active' => Users::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!Users::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject(Yii::t('app', 'Password reset for ') . $user->getUsername())
                    ->send();
            }
        }

        return false;
    }
}
