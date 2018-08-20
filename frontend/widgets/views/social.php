<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 10/11/2016
 * Time: 6:20 PM
 */
?>
<div class="follow right">
    <?php foreach($social as $item):?>
        <a target="_blank" class="entry" href="<?= $item->url?>"><i class="<?= $item->icon?>"></i></a>
    <?php endforeach;?>
</div>