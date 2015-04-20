<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/9/2015
 * Time: 22:27
 */

namespace frontend\models;


use yii\base\Object;

class Pagination extends Object{

    /**
     * @var int current page
     */
    public $page  = 1;

    /**
     * @var int total number of items
     */
    public $total = 0;

    /**
     * @var int size of page (numbers)
     */
    public $defaultPageSize = 15;

    /**
     * @var int range of page (numbers)
     */
    public $defaultPageRange = 5;

    /**
     * @var bool current page is first
     */
    public $isFirst = false;

    /**
     * @var bool current page is last
     */
    public $isLast = false;

    /**
     * @var int display items count
     */
    public $displayItemsCount = 12;

    /**
     * @var array limit of items
     */
    public $limit = ['offset' => 0, 'limit' => 11];

    /**
     * @return array|null
     */
    public function pager(){

        if($this->total <= $this->displayItemsCount){
            return null;
        }

        $pageCount = ceil($this->total / $this->displayItemsCount);

        if($this->page > $pageCount || $this->page < 1){
            $this->page = 1;
        }

        if($this->page == 1){
            $this->isFirst = true;
        }

        if($this->page == $pageCount){
            $this->isLast = true;
        }

        $this->limit = [
          'offset' => ($this->page - 1) * $this->displayItemsCount,
          'limit'  => $this->displayItemsCount
        ];

        if($pageCount <= $this->defaultPageSize){
            $pages = $this->getPagesArray(1, $pageCount);
        } else {
            if($this->page <= $this->defaultPageSize - $this->defaultPageRange){
                $pages = $this->getPagesArray(1, $this->defaultPageSize);
            } elseif($this->page < ($pageCount - $this->defaultPageRange)){
                $pages = $this->getPagesArray($this->page - ($this->defaultPageSize - $this->defaultPageRange - 1), $this->page + $this->defaultPageRange);
            } else {
                $pages = $this->getPagesArray($pageCount - $this->defaultPageSize, $pageCount);
            }
        }

        return $pages;

    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function getPagesArray($start, $end){
        for($i = $start; $i <= $end; $i++){
            $pages[] = $i;
        }

        return $pages;
    }

}