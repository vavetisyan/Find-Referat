<?php
namespace frontend\controllers;

use app\models\BuyingWorks;
use app\models\Categories;
use app\models\WorkCategories;
use app\models\Works;
use frontend\models\Work;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/18/2014
 * Time: 12:20
 * Work controller
 */
class WorkController extends BaseController
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
                        'actions' => ['add'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['download'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['bought'],
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
        $myWorks = Works::find()
            ->where(['user_id' => Yii::$app->user->getId()])
            ->orderBy('visible DESC, id DESC')
        ->all();

        return $this->render('index', [
            'myWorks' => $myWorks
        ]);
    }

    /**
     * @return string
     */
    public function actionAdd(){

        $params = Yii::$app->request->post();
        $errors = array();
        $work = '';

        if(!empty($params['work'])){
            $errors = $this->addNewWork($params['work']);
            $work = $params['work'];
        }

        //Get all categories
        $categories = Categories::find()->all();

        return $this->render('add', [
            'categories' => $categories,
            'errors' => $errors,
            'work' => $work
        ]);
    }

    /**
     * @param $work
     * @return array
     * @throws \yii\db\Exception
     */
    public function addNewWork($work){
        $errors = array();
        $price_error = false;
        $categories_error = false;

        //Validate work
        $work_error = Work::isWorkValid($_FILES['work']);

        //Validate price
        if(!Work::isPriceValid($work['price'])){
            $price_error = Yii::t('app', 'Price is not valid.');
        }

        //Validate categories
        if(empty($work['categories'])){
            $categories_error = Yii::t('app', 'You should choose at least one section.');
        }

        $works = new Works();
        $works->setUserId(Yii::$app->user->getId());
        $works->setTitle(htmlspecialchars($work['title']));
        $works->setDescription(htmlspecialchars($work['description']));
        $works->setPrice($work['price']);
        $works->setVisible(Works::VISIBLE_PENDING);
        $works->setLang(Yii::$app->language);
        $works->setCreatedDate(date('Y-m-d H:i:s'));

        if($works->validate() && !$price_error && !$work_error && !$categories_error){

            $transaction = Works::getDb()->beginTransaction();
            try {
                if((!empty($_FILES['work']['name']['file_name']))) {
                    //Upload work
                    $work_name = Work::uploadWork($_FILES['work']);
                    $works->setFileName($work_name);
                }
                //Add new work
                $works->save();

                foreach($work['categories'] as $category_id) {
                    $work_categories = new WorkCategories();
                    $work_categories->setWorkId($works->getId());
                    $work_categories->setCategoryId($category_id);
                    $work_categories->save();
                }

                $transaction->commit();
                $this->redirect(Yii::$app->homeUrl . Yii::$app->language . '/works');
            } catch (\Exception $e) {
                $transaction->rollback();
                $errors['server_error'] = Yii::t('app', 'Internal server error. Please try later.');
            }

        } else {
            $errors = $works->getErrors();
            $errors['price'][] = $price_error;
            $errors['category'][] = $categories_error;
            $errors['file_name'][] = $work_error;
        }

        return $errors;
    }

    /**
     * @throws \yii\base\ExitException
     */
    public function actionEdit(){
        $params = Yii::$app->request->post();

        if(!Works::validateParams($params)){
            echo Json::encode([
                'status' => '-1',
            ]);
            Yii::$app->end();
        }

        if(!Works::isMyWork($params['id']) || !Works::isWorkPending($params['id'])){
            echo Json::encode([
                'status' => '-1',
            ]);
            Yii::$app->end();
        }

        $work = Works::findOne(['id' => $params['id']]);

        $work->setTitle(htmlspecialchars($params['title']));
        $work->setDescription(htmlspecialchars($params['description']));
        $work->setPrice($params['price']);

        if($work->validate()){
            $work->save();

            echo Json::encode([
                'status' => '1',
                'content' => $params,
                'message' => Yii::t("app", "Your changes have been done.")
            ]);
            Yii::$app->end();
        }

        echo Json::encode([
            'status' => '-1',
        ]);
        Yii::$app->end();
    }

    /**
     * @throws \yii\base\ExitException
     * @throws \yii\db\Exception
     */
    public function actionDelete(){
        $params = Yii::$app->request->post();

        if(empty($params['id'])){
            echo Json::encode([
                'status' => '-1',
            ]);
            Yii::$app->end();
        }

        if(!Works::isMyWork($params['id'])){
            echo Json::encode([
                'status' => '-1',
            ]);
            Yii::$app->end();
        }

        $transaction = Works::getDb()->beginTransaction();
        try {
            $work = Works::findOne(['id' => $params['id']]);
            $work->delete();
            WorkCategories::deleteAll(['work_id' => $params['id']]);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollback();
            echo Json::encode([
                'status' => '2',
                'message' => Yii::t("app", "Internal server error. Please try later.")
            ]);
            Yii::$app->end();
        }

        echo Json::encode([
            'status' => '1',
            'message' => Yii::t("app", "Your work successfully deleted.")
        ]);
        Yii::$app->end();
    }

    /**
     * @throws \yii\base\ExitException
     */
    public function actionDownload(){
        $params = Yii::$app->request->get();

        if(!empty($params['id'])){

            if(Works::isMyWork($params['id']) || BuyingWorks::canIDownloadWork($params['id'])){
                $work = Works::findOne(['id' => $params['id']]);
                //Begin file download
                $file_path = Yii::$app->params['workPath'] . $work->user_id . '/' . $work->file_name;
                header("Cache-control: private");
                header("Content-type: application/force-download");
                header("Content-transfer-encoding: binary\n");
                header('Content-disposition: attachment; filename="' . $work->file_name . '"');
                header("Content-Length: " . filesize($file_path));
                readfile($file_path);
                Yii::$app->end();
                //End file download
            }

        }

        echo '<meta charset="UTF-8">';
        echo Yii::t('app', 'You are not allowed perform this action.');
        Yii::$app->end();

    }

    /**
     * @return string
     */
    public function actionBought(){
        return $this->render('bought', [
            'bought' => BuyingWorks::getBuyingWorks()
        ]);
    }

}