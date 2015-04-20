<?php
namespace frontend\controllers;

use app\models\Users;
use app\models\Works;
use frontend\models\Pagination;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
        $param = Yii::$app->request->get();

        $pagination = new Pagination([
            'total' => Works::find()->where(['visible' => Works::VISIBLE_SUCCESS, 'active' => Works::ACTIVE_SUCCESS])->count(),
        ]);

        if(!empty($param['page'])){
            $pagination->page = $param['page'];
        }

        $pages = $pagination->pager();

        return $this->render('//section/index', [
            'title' => Yii::t('app', 'Home'),
            'works' => Works::getWorks(0, $pagination->limit),
            'pages' => $pages,
            'currentPage' => $pagination->page,
            'isFirst' => $pagination->isFirst,
            'isLast' => $pagination->isLast,
            'link' => Yii::$app->homeUrl . Yii::$app->language . '/home/',
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
        }

        $params = Yii::$app->request->post();
        $errors = array();
        $signup = array();

        $model = new LoginForm();


        if (!isset($params['signup']) && $model->load($params) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->user->identity->getDefaultLang());
        }

        if(!empty($params['signup'])){

            $user = new Users();
            $user->setUsername($params['signup']['username']);
            $user->setPassword($params['signup']['password']);
            $user->setRev($params['signup']['password']);
            $user->setFirstName($params['signup']['first_name']);
            $user->setLastName($params['signup']['last_name']);
            $user->setEmail($params['signup']['email']);
            $user->setDefaultLang(Yii::$app->language);
            $user->setCreatedDate(date('Y-m-d H:i:s'));
            $user->generateAuthKey();

            if($user->validate()){
                $user->setHashPassword($params['signup']['password']);

                $user->save();
                if (Yii::$app->getUser()->login($user)) {
                    //return $this->goHome();
                    return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
                }
            } else {
                $errors = $user->getErrors();
                $signup = $params['signup'];
            }

        }

        return $this->render('login', [
            'model' => $model,
            'signup' => $signup,
            'errors' => $errors,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        //return $this->goHome();
        return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

                //return $this->goHome();
                return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New password was saved.'));

            //return $this->goHome();
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
