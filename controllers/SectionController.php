<?php
namespace frontend\controllers;

use app\models\Wishlist;
use app\models\WorkCategories;
use app\models\Works;
use frontend\models\Pagination;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Section controller
 */
class SectionController extends BaseController
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
                        'actions' => ['search'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['random'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['wish-list'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add-to-wish-list'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['detail'],
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
        $param = Yii::$app->request->get();

        $pagination = new Pagination([
            'total' => Works::getCountWorks($param['id']),
        ]);

        if(!empty($param['page'])){
            $pagination->page = $param['page'];
        }

        $pages = $pagination->pager();

        return $this->render('index', [
            'title' => $param['title'],
            'works' => Works::getWorks($param['id'], $pagination->limit),
            'pages' => $pages,
            'currentPage' => $pagination->page,
            'isFirst' => $pagination->isFirst,
            'isLast' => $pagination->isLast,
            'link' => Yii::$app->homeUrl . Yii::$app->language . '/section/' . $param['id'] . '/' . $param['title'] . '/',
            'params' => [$param['id']]
        ]);
    }

    /**
     * @return string
     */
    public function actionSearch()
    {
        $param = Yii::$app->request->get();

        if(empty($param['search_title'])){
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
        }

        $pagination = new Pagination([
            'total' => Works::getSearchCountWorks(trim($param['search_title'])),
        ]);

        if(!empty($param['page'])){
            $pagination->page = $param['page'];
        }

        $pages = $pagination->pager();

        return $this->render('index', [
            'title' => Yii::t('app', 'Search'),
            'works' => Works::getSearchWorks(trim($param['search_title']), $pagination->limit),
            'pages' => $pages,
            'currentPage' => $pagination->page,
            'isFirst' => $pagination->isFirst,
            'isLast' => $pagination->isLast,
            'link' => Yii::$app->homeUrl . Yii::$app->language . '/search/' . trim($param['search_title']) . '/',
        ]);
    }

    /**
     * @return string
     */
    public function actionRandom()
    {
        return $this->render('index', [
            'title' => Yii::t('app', 'Random works'),
            'works' => Works::getRandomWorks(),
            'pages' => null,
            'currentPage' => null,
            'isFirst' => null,
            'isLast' => null,
            'link' => null,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionWishList(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language . '/login');
        }

        $param = Yii::$app->request->get();

        $pagination = new Pagination([
            'total' => Wishlist::getCountWorks(),
        ]);

        if(!empty($param['page'])){
            $pagination->page = $param['page'];
        }

        $pages = $pagination->pager();

        return $this->render('index', [
            'title' => Yii::t('app', 'Wishlist'),
            'works' => Wishlist::getWorks($pagination->limit),
            'pages' => $pages,
            'currentPage' => $pagination->page,
            'isFirst' => $pagination->isFirst,
            'isLast' => $pagination->isLast,
            'link' => Yii::$app->homeUrl . Yii::$app->language . '/wishlist/',
            'isWishList' => true,
        ]);
    }

    /**
     * @throws \yii\base\ExitException
     */
    public function actionAddToWishList(){
        $param = Yii::$app->request->post();

        if(Yii::$app->user->isGuest){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'You should login to your account, to add work in your wishlist.')
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

        if(Wishlist::isWishListExist($param['id'])){
            echo Json::encode([
                'status'  => '2',
                'message' => Yii::t('app', 'You already have added this work in your wish list.')
            ]);
            Yii::$app->end();
        }

        $wishList = new Wishlist();
        $wishList->setUserId(Yii::$app->user->getId());
        $wishList->setWorkId($param['id']);
        $wishList->save();

        echo Json::encode([
            'status'  => '1',
            'message' => Yii::t('app', 'You have added this work in your wish list successfully.')
        ]);
        Yii::$app->end();

    }

    /**
     * @return \yii\web\Response
     */
    public function actionDetail(){
        $param = Yii::$app->request->get();

        if(empty($param['id'])){
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
        }

        $work = Works::findOne(['id' => $param['id'], 'visible' => Works::VISIBLE_SUCCESS, 'active' => Works::ACTIVE_SUCCESS]);

        if(empty($work)){
            return $this->redirect(Yii::$app->homeUrl . Yii::$app->language);
        }

        $work_categories = WorkCategories::getWorkCategories($work->id);

        try {
            $work->setViewsCount($work->getViewsCount() + 1);
            $work->save();
        } catch (\Exception $e) {
            //If will be an error, lets continue the script.
        }

        return $this->render('detail', [
            'title' => $param['title'],
            'work' => $work,
            'work_categories' => $work_categories
        ]);
    }

    /**
     * @param $categories
     * @return array
     */
    public static function createArrayFromCategories($categories){
        $params = [];

        if(!empty($categories)) {
            foreach ($categories as $category) {
                $params[] = $category['id'];
            }
        }

        return $params;
    }

}
