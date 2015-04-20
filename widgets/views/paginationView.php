<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 1/1/2015
 * Time: 13:50
 */

if(!empty($pages)) {
    echo '<ul class="pagination">';
    if (!$isFirst) {
        echo '<li><a href="' . $link . ($currentPage - 1) . '">&laquo;</a></li>';
    }

    foreach ($pages as $page) {
        if ($page == $currentPage) {
            echo '<li class="active"><a>' . $page . '</a></li>';
        } else {
            echo '<li><a href="' . $link . $page . '">' . $page . '</a></li>';
        }
    }

    if (!$isLast) {
        echo '<li><a href="' . $link . ($currentPage + 1) . '">&raquo;</a></li>';
    }
    echo '</ul>';
}
?>