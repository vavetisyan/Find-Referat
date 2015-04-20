<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/1/15
 * Time: 13:50
 */

namespace frontend\widgets;


use yii\base\Widget;

class Pagination extends Widget{

    public $link = '';
    public $pages = [];
    public $currentPage = 1;
    public $isFirst = false;
    public $isLast = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('paginationView', [
            'link' => $this->link,
            'pages' => $this->pages,
            'currentPage' => $this->currentPage,
            'isFirst' => $this->isFirst,
            'isLast' => $this->isLast,
        ]);
    }
}