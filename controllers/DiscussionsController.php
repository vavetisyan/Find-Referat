<?php
namespace frontend\controllers;

use app\models\Discussions;
use frontend\models\Pagination;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 01/28/2015
 * Time: 01:03
 * Discussions controller
 */
class DiscussionsController extends BaseController
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
                        'actions' => ['add'],
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
        $param = Yii::$app->request->get();

        $pagination = new Pagination([
            'total' => Discussions::find()->where(['is_show' => Discussions::IS_SHOW_TRUE])->count(),
            'displayItemsCount' => Discussions::DISPLAY_ITEMS_COUNT
        ]);

        if(!empty($param['page'])){
            $pagination->page = $param['page'];
        }

        $pages = $pagination->pager();

        return $this->render('index', [
            'messages' => Discussions::getMessages($pagination->limit),
            'pages' => $pages,
            'currentPage' => $pagination->page,
            'isFirst' => $pagination->isFirst,
            'isLast' => $pagination->isLast,
            'link' => Yii::$app->homeUrl . Yii::$app->language . '/discussions/',
        ]);
    }

    public function actionAdd(){
        $param = Yii::$app->request->post();

        if(Yii::$app->user->isGuest){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'For adding a message, you should logged in.')
            ]);
            Yii::$app->end();
        }

        if(!Discussions::validateParam($param)){
            echo Json::encode([
                'status' => '-1',
            ]);
            Yii::$app->end();
        }

        $discussion = new Discussions();
        $discussion->setUserId(Yii::$app->user->getId());
        $discussion->setMessage(htmlspecialchars(trim($param['message'])));
        $discussion->setIsShow(Discussions::IS_SHOW_FALSE);
        $discussion->save();

        if($discussion->save()){
            echo Json::encode([
                'status' => '1',
                'message' => Yii::t("app", "Thank you for adding a message. After approving it will appear on the site.")
            ]);
            Yii::$app->end();
        }

        echo Json::encode([
            'status' => '-1',
        ]);
        Yii::$app->end();
    }

}
