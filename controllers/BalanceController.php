<?php
namespace frontend\controllers;

use app\models\Transfers;
use app\models\Users;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 01/23/2015
 * Time: 22:20
 * Balance controller
 */
class BalanceController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language . '/login');
        }
        $this->enableCsrfValidation = false;

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['success'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['cancel'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['transfer'],
                        'allow' => true,
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'index' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionCancel()
    {
        return $this->render('cancel');
    }

    public function actionTransfer(){
        if(!Yii::$app->request->isAjax){
            echo Json::encode([
                'status' => '0',
                'message' => Yii::t("app", "Internal server error. Please try later.")
            ]);
            Yii::$app->end();
        }

        $transaction = Transfers::getDb()->beginTransaction();
        try {
            $params = Yii::$app->request->post();

            $transfer = new Transfers();
            $transfer->setUserId(Yii::$app->user->getId());
            $transfer->setEmail(Yii::$app->user->identity->getEmail());
            $transfer->setPaypalEmail($params['paypal_email']);
            $transfer->setMoney($params['money']);
            $transfer->setCreatedDate(date('Y-m-d H:i:s'));

            if(!$transfer->validate()){

                $message = '';
                foreach($transfer->getErrors() as $errors){
                    foreach($errors as $error){
                        $message .= $error . '<br>';
                    }
                }

                echo Json::encode([
                    'status' => '0',
                    'message' => $message
                ]);
                Yii::$app->end();
            }

            if(!Transfers::validateMoney($params['money'])){
                echo Json::encode([
                    'status' => '0',
                    'message' => Yii::t('app', "The amount shouldn't exceed your balance.")
                ]);
                Yii::$app->end();
            }

            $transfer->save();

            //Update user balance
            $user = Users::findIdentity(Yii::$app->user->getId());
            $user->setBalance($user->getBalance() - $params['money']);
            $user->save();

            $transaction->commit();

            echo Json::encode([
                'status' => '1',
                'message' => Yii::t("app", "Your balance will be transferred to your (PayPal) after checking.")
            ]);
            Yii::$app->end();

        } catch (\Exception $e) {
            $transaction->rollback();
            echo Json::encode([
                'status' => '0',
                'message' => Yii::t("app", "Internal server error. Please try later.")
            ]);
            Yii::$app->end();
        }
    }

}
