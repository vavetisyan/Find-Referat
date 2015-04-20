<?php
namespace frontend\controllers;

use app\models\Users;
use app\models\Wishlist;
use app\models\Works;
use app\models\BuyingWorks;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Buy controller
 */
class BuyController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
                        'actions' => ['buy'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @throws \yii\base\ExitException
     */
    public function actionBuy(){
        $param = Yii::$app->request->post();

        if(Yii::$app->user->isGuest){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'You should login to your account, to buy work.')
            ]);
            Yii::$app->end();
        }

        if(!is_numeric($param['id']) || !Works::isWorkExist($param['id'])){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'Work is not valid.')
            ]);
            Yii::$app->end();
        }

        if(BuyingWorks::isWorkBought($param['id']) || Works::isMyWork($param['id'])){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'You have added this work or You already have bought this work.')
            ]);
            Yii::$app->end();
        }

        $work = Works::findOne(['id' => $param['id']]);

        if(Yii::$app->user->identity->getBalance() < $work->getPrice()){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'Your balance not enough to buy this work, load your balance.')
            ]);
            Yii::$app->end();
        }

        if($this->buy($work)){
            echo Json::encode([
                'status'  => '1',
                'message' => Yii::t('app', 'You have bought this work, you can see it in your (Bought works) section.')
            ]);
            Yii::$app->end();
        }

        echo Json::encode([
            'status'  => '2',
            'message' => Yii::t('app', 'Internal server error. Please try later.')
        ]);
        Yii::$app->end();
    }

    /**
     * @param $work
     * @return bool
     * @throws \yii\db\Exception
     */
    private function buy($work){
        $transaction = Users::getDb()->beginTransaction();
        try {
            $work_price = $work->getPrice();
            $percent = Yii::$app->params['percent'];
            $final_balance = number_format((float)($work_price - ($work_price * $percent / 100)), 1, '.', '');

            $user = Users::findIdentity(Yii::$app->user->getId());
            $user->setBalance($user->getBalance() - $work_price);
            $user->save();

            $seller = Users::findOne($work->getUserId());
            $seller->setBalance(number_format((float)($seller->getBalance() + $final_balance), 1, '.', ''));
            $seller->save();

            $buying_works = new BuyingWorks();
            $buying_works->setUserId(Yii::$app->user->getId());
            $buying_works->setWorkId($work->getId());
            $buying_works->save();

            $work->setBuyingCount($work->getBuyingCount() + 1);
            $work->save();

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

}
