<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/23/2017
 * Time: 2:27 AM
 */

$this->title = 'Catalog';

use common\components\CustomPagination;
use common\models\Connection;
use common\models\Marka;
use frontend\widgets\LeftFilter;
use frontend\widgets\LeftInfo;
use frontend\widgets\Search;
use frontend\widgets\Search1;
use frontend\widgets\SearchModal;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>
    <section id="all-products">
        <!-- 'all-products all-products-catalog' class name-->
    <div class="container all-products all-products-catalog">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
        </div>
        <!--this class catalog-row-->
        <div class="row catalog-row">
            <!--this class catalog-row-->
            <!--this cols -->
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <!--this classes 'fix-search, fix-search-catalog'-->
                <?= Search1::widget(['type' => 'btn-blue-line'])?>
            </div>
            <!--all cols -->
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9 clearfix margin_bottom">
                <?if(!empty($items)):?>
                    <?foreach ($items as $item):?>
                        <?if(isset($item['order']["id"]) && (strtotime($item['order']["to"]) > strtotime(date("Y-m-d")) && $item['order']["status"] == 1)) :?>

                            <?else:?>

                            <?php
                                if($item->price_weekly && $days <= 10  && $days >= 7){
                                    $total_price = $days * $item->price_weekly;
                                }elseif ($item->price_3_days && $days <= 6  && $days >= 4){
                                    $total_price =  $days * $item->price_3_days;
                                }elseif ($item->price_daily && $days <= 3 ){
                                    $total_price = $days * $item->price_daily;
                                }
                            ?>

                            <div class="row">
                            <div class="panel profile-widget">
                                <!--this cols -->
                                <div class="col-sm-3 col-md-3 col-lg-3 col-xs-12">
                                    <div class="bg-img">
                                        <img src="<?= !empty($item->image_main) ? '/uploads/item/'.$item->image_main : "/uploads/items/".$item->id.'/'.$item->images[0]->path?>">
                                    </div>
<!--                                    <div class="brand-logo">-->
<!--                                        <img src="--><?//= $item->user->image ? '/uploads/users/115-115/'.$item->user->image : '/images/default.jpg'?><!--">-->
<!--                                    </div>-->
                                </div>
                                <!--this cols -->
                                <div class="product-body col-sm-6 col-md-6 col-lg-6 col-xs-12">
                                    <div class="row list-separated profile-stat">
                                        <p style="font-size: 20px"><b><?= Marka::findOne($item->model->mark_id)->mark?> - <?=$item->model->model?> or analog</b></p>
                                        <br>
                                        <p><b>Location: </b> <?= $item->city->name?></p>
                                        <p><b>Type of body: </b> <?= $item->typeBody->title?></p>
                                        <p><b>Doors: </b> <?= $item->quantity_doors?></p>
                                        <p><b>Class: </b> <?= $item->class->title?></p>
                                        <p><b>Transmission: </b> <?= $item->transmissionVehicles->title?></p>
                                        <p><b>Climate control: </b> Yes</p>
                                        <p><b>Steering wheel: </b> <?= $item->steering_wheel?></p>
                                        <p><b>Year of manufacture: </b> <?= $item->year_manufacture?></p>
                                        <p><b>Deposit with CASCO:</b> AMD <?= $item->insurance ? $item->deposit : \common\models\Setting::findOne(2)->value?></p>
                                        <p><b>Deposit without CASCO: </b> AMD 600 000</p>
                                    </div>
                                    <div class="choose text-center">

                                    </div>
                                </div>
                                <!--this cols -->
                                <div class="col-sm-4 col-xs-12 price">
                                    <div>
                                        <p>Price for <?= $days?> days: <span>AMD <?= $total_price?></span></p>
                                    </div>
                                    <div class="text-center">
                                        <?= Html::a('Select', '/item/'.$item->id, ['class' => 'btn btn-blue', 'target' => '_blank'])?>
                                    </div>
                                </div>

                                <div style="clear: both"></div>
                            </div>
                        </div>

                        <?endif;?>
                    <?endforeach;?>
                <?else:?>
                    <div class="empty-container text-center">
                        <img class="img-responsive" src="/images/no-results.png">
                    </div>
                <?endif;?>
                <?= CustomPagination::widget([
                    'pagination' => $pages,
                    'maxButtonCount'=>5,
                ]);?>
            </div>
            <!--all cols -->
        </div>
    </div>
</section>

<?= SearchModal::widget()?>