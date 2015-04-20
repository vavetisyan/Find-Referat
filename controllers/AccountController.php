<?php
namespace frontend\controllers;

use app\models\BuyingWorks;
use app\models\Users;
use app\models\Works;
use frontend\models\Image;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 11/30/2014
 * Time: 23:39
 * Account controller
 */
class AccountController extends BaseController
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
                        'actions' => ['get-balance'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['change-user-default-language'],
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->post();
        $errors = array();
        $active_tab = 'profile';

        if(!empty($params['profile'])) {
            $errors = $this->changeProfile($params['profile']);
        }

        if(!empty($params['settings'])) {
            $errors = $this->changeSettings($params['settings']);
            $active_tab = 'settings';
        }

        //Get uploaded works count by user
        $added_works_count = Works::find()->where(['user_id' => Yii::$app->user->getId(), 'active' => Works::ACTIVE_SUCCESS])->count();
        //Get buying works count by user
        $buying_works_count = BuyingWorks::find()->where(['user_id' => Yii::$app->user->getId()])->count();
        //Get views count by user
        $views_count = Works::find()->where(['user_id' => Yii::$app->user->getId(), 'active' => Works::ACTIVE_SUCCESS])->sum('views_count');

        return $this->render('index', [
            'added_works_count'    => $added_works_count,
            'buying_works_count'   => $buying_works_count,
            'views_count'          => $views_count,
            'active_tab'           => $active_tab,
            'errors'               => $errors
        ]);
    }

    /**
     * @param $profile
     * @return array
     */
    public function changeProfile($profile){
        $errors = array();
        $sex_error = false;

        $user = Users::findIdentity(Yii::$app->user->getId());
        $user->setFirstName($profile['first_name']);
        $user->setLastName($profile['last_name']);
        $user->setSex($profile['sex']);
        $user->setEmail($profile['email']);

        if(!Users::isSexValid($profile['sex'])){
            $sex_error = Yii::t('app', 'Sex is not valid.');
        }

        $image_error = Image::isImageValid($_FILES['profile']);

        if(!$sex_error && !$image_error && $user->validate()){

            $transaction = Users::getDb()->beginTransaction();
            try {
                if((!empty($_FILES['profile']['name']['avatar']))) {
                    //Upload image
                    $image_name = Image::uploadImage($_FILES['profile']);
                    $user->setAvatar($image_name);
                }
                //Change user profile details
                $user->save();

                $transaction->commit();
                $this->redirect(Yii::$app->homeUrl . Yii::$app->language . '/account');
            } catch (\Exception $e) {
                $transaction->rollback();
                $errors['server_error'] = Yii::t('app', 'Internal server error. Please try later.');
            }

        } else {
            $errors = $user->getErrors();
            $errors['sex'][] = $sex_error;
            $errors['avatar'][] = $image_error;
        }

        return $errors;
    }

    /**
     * @param $settings
     * @return array
     */
    public function changeSettings($settings){
        $errors = array();
        $old_password_error = false;

        $user = Users::findIdentity(Yii::$app->user->getId());

        if($settings['old_password'] != $user->getRev()){
            $old_password_error = Yii::t('app', "Old password is wrong.");
        }

        $user->setUsername($settings['username']);
        $user->setPassword($settings['new_password']);
        $user->setRev($settings['new_password']);

        if(!$old_password_error && $user->validate()){
            $user->setHashPassword($settings['new_password']);

            $user->save();
            $this->redirect(Yii::$app->homeUrl . Yii::$app->language . '/account');
        } else {
            $errors = $user->getErrors();
            $errors['old_password'] = $old_password_error;
        }

        return $errors;
    }

    /**
     * @throws \yii\base\ExitException
     */
    public function actionGetBalance(){
        echo Json::encode([
            'status'  => '1',
            'balance' => Yii::$app->user->identity->getBalance()
        ]);
        Yii::$app->end();
    }

    /**
     * @throws \yii\base\ExitException
     */
    public function actionChangeUserDefaultLanguage(){
        $params = Yii::$app->request->post();

        if(!empty($params['name']) && $this->languageCheckerByName($params['name'])){
            try {
                $user = Users::findIdentity(Yii::$app->user->getId());
                $user->setDefaultLang(array_search($params['name'], Yii::$app->params['languages']));
                $user->save();
            } catch (\Exception $e) {
                 //Don nothing
            }
        }

        Yii::$app->end();
    }

}
