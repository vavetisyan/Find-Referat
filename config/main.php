<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'debug', 'gii'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'en',
    'components' => [
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//        ],
        'user' => [
            'identityClass' => 'app\models\Users', // User must implement the IdentityInterface
            'enableAutoLogin' => true,
            //'loginUrl' => ['user/login'],
            // ...
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        //Url Manager
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //Home page
                '<language:(en|ru|am)>'=>'site/index',
                'home'=>'site/index',
                '<language:(en|ru|am)>/home'=>'site/index',
                'home/<page:\d+>'=>'site/index',
                '<language:(en|ru|am)>/home/<page:\d+>'=>'site/index',

                //Random page
                'random'=>'section/random',
                '<language:(en|ru|am)>/random'=>'section/random',

                //Discussions page
                'discussions'=>'discussions/index',
                '<language:(en|ru|am)>/discussions'=>'discussions/index',
                'discussions/<page:\d+>'=>'discussions/index',
                '<language:(en|ru|am)>/discussions/<page:\d+>'=>'discussions/index',
                'adddiscussions'=>'discussions/add',
                '<language:(en|ru|am)>/adddiscussions'=>'discussions/add',

                //Contact page
                'contact' => 'site/contact',
                '<language:(en|ru|am)>/contact' => 'site/contact',

                //Section page
                'section/<id:\d+>/<title>'=>'section/index',
                '<language:(en|ru|am)>/section/<id:\d+>/<title>'=>'section/index',
                'section/<id:\d+>/<title>/<page:\d+>'=>'section/index',
                '<language:(en|ru|am)>/section/<id:\d+>/<title>/<page:\d+>'=>'section/index',

                //Detail page
                'detail/<id:\d+>/<title>'=>'section/detail',
                '<language:(en|ru|am)>/detail/<id:\d+>/<title>'=>'section/detail',

                //Account page
                'account' => 'account',
                '<language:(en|ru|am)>/account' => 'account',
                'getbalance' => 'account/get-balance',

                //Wish list page
                'wishlist'=>'section/wish-list',
                '<language:(en|ru|am)>/wishlist'=>'section/wish-list',
                'wishlist/<page:\d+>'=>'section/wish-list',
                '<language:(en|ru|am)>/wishlist/<page:\d+>'=>'section/wish-list',
                'addtowishlist'=>'section/add-to-wish-list',
                '<language:(en|ru|am)>/addtowishlist'=>'section/add-to-wish-list',

                //Search page
                'search'=>'section/search',
                '<language:(en|ru|am)>/search'=>'section/search',
                'search/<search_title>'=>'section/search',
                '<language:(en|ru|am)>/search/<search_title>'=>'section/search',
                'search/<search_title>/<page:\d+>'=>'section/search',
                '<language:(en|ru|am)>/search/<search_title>/<page:\d+>'=>'section/search',

                //Buy
                'buy'=>'buy/buy',
                '<language:(en|ru|am)>/buy'=>'buy/buy',

                //Login page
                'login' => 'site/login',
                '<language:(en|ru|am)>/login' => 'site/login',

                //Logout page
                'logout' => 'site/logout',
                '<language:(en|ru|am)>/logout' => 'site/logout',

                //Request password reset page
                'request-password-reset' => 'site/request-password-reset',
                '<language:(en|ru|am)>/request-password-reset' => 'site/request-password-reset',

                //Reset password page
                'reset-password' => 'site/reset-password',
                '<language:(en|ru|am)>/reset-password' => 'site/reset-password',

                //Change user default language
                'changelang' => 'account/change-user-default-language',

                //My works page
                'works' => 'work/index',
                '<language:(en|ru|am)>/works' => 'work/index',

                //Bought works page
                'bought' => 'work/bought',
                '<language:(en|ru|am)>/bought' => 'work/bought',

                //Add new work page
                'add' => 'work/add',
                '<language:(en|ru|am)>/add' => 'work/add',

                //Edit new work page
                'edit' => 'work/edit',
                '<language:(en|ru|am)>/edit' => 'work/edit',

                //Delete new work page
                'delete' => 'work/delete',
                '<language:(en|ru|am)>/delete' => 'work/delete',

                //Delete new work page
                'balance' => 'balance/index',
                '<language:(en|ru|am)>/balance' => 'balance/index',

                //Download new work page
                'download/<id:\d+>' => 'work/download',
                '<language:(en|ru|am)>/download/<id:\d+>' => 'work/download',

                //Common pages
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<language:(en|ru|am)>/<controller:\w+>/<id:\d+>'=>'<controller>/view',

                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<language:(en|ru|am)>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<language:(en|ru|am)>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],

    ],

    'params' => $params,

    'modules' => ['debug' => 'yii\debug\Module', 'gii' => 'yii\gii\Module'],

];
