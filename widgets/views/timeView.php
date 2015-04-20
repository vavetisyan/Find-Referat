<?php
/**
 * Created by PhpStorm.
 * @author VOLODYA AVETISYAN <volodya.avetisyan@gmail.com>
 * Date: 12/24/2014
 * Time: 16:04
 */
?>
<?php if(!Yii::$app->user->isGuest){ ?>
    <ul>
        <li><a style="text-transform: none"><i class="fa fa-user"></i><?php echo Yii::$app->user->identity->getUsername(); ?></a></li>
        <li><a><i class="fa fa-clock-o"></i><span class="clock_time"></span></a></li>
        <li><a><i class="fa fa-calendar-o"></i><?php echo date("d M Y"); ?></a></li>
    </ul>
    <script>
        setInterval(function(){
            var date_time = new Date();
            $('.clock_time').text(date_time.getHours() + ":" + date_time.getMinutes() + ":" + date_time.getSeconds());
        }, 1000);
    </script>
<?php } ?>