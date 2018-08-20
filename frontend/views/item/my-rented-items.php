<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 5/12/2017
 * Time: 4:57 PM
 */

use common\components\CustomPagination;
use common\models\Connection;
use common\models\Marka;
use frontend\widgets\LeftInfo;
use yii\bootstrap\Html;
$this->title = 'My Rented Items';
?>

<section id="user-page">
    <div class="container">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
            <div class="actions clearfix">
                <form class="">
                    <div class="form-group btn-group">
                        <label class="control-label">Return date:</label>
                        <div class="filter-select">
                            <?= Html::dropDownList('date', Yii::$app->request->get('date'),
                                [
                                    'up' => 'Up',
                                    'down' => 'Down',
                                ],
                                [
                                    'class' => 'form-control',
                                    'onchange' => "this.form.submit()",
                                ])
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <?= LeftInfo::widget()?>
            </div>
            <?if(!empty($orders)):?>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 clearfix">
                    <div class="row">
                        <?foreach ($orders as $order):?>
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xs-12">
                                <div class="panel profile-widget">
                                    <div class="cover-bg" style="background-image:url(<?= "/uploads/items/".$order->item_id.'/'.$order->item->images[0]->path?>)"></div>
                                    <div class="profile-img">
                                        <a href="<?= Yii::$app->user->id == $order->user->id ? '/user/my-items?status=available' : '/user/'.$order->user->username?>/rental-items">
                                            <img src="<?= $order->user->image ? '/uploads/users/115-115/'.$order->user->image : '/images/default.jpg'?>">
                                        </a>
                                    </div>
                                    <div class="profile-name">
                                        <div class="name-data clearfix">
                                            <p class="pull-left">
                                                <a href="<?= Yii::$app->user->id == $order->user->id ? '/user/my-items?status=available' : '/user/'.$order->user->username?>/rental-items">
                                                    <?if($order->user->display_type == 1):?>
                                                        <?= $order->user->first_name .' '. $order->user->last_name[0]?>.
                                                    <?elseif ($order->user->display_type == 2):?>
                                                        <?= $order->user->first_name .' '. $order->user->last_name?>
                                                    <?elseif ($order->user->display_type == 3):?>
                                                        <?= $order->user->display_name?>
                                                    <?endif;?>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p><?= Marka::findOne($order->item->model->mark_id)->mark?> - <?=$order->item->model->model?></p>
                                        <div class="row list-separated profile-stat">
                                            <div class="col-md-5 col-lg-5 col-sm-6 col-xs-6">
                                                <div class="uppercase profile-stat-text"> Price </div>
                                                <div class="uppercase profile-stat-title"><?= $order->rental_price?></div>
                                            </div>
                                            <div class="col-md-7 col-lg-7 col-sm-6 col-xs-6">
                                                <div class="uppercase profile-stat-text"> Return date </div>
                                                <?
                                                $date = new DateTime($order->to);
                                                ?>
                                                <div class="uppercase profile-stat-title"><?= $date->format('d M Y')?></div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <?= Html::a('Edit Item', ['/user/my-items/edit-item', 'id' => $order->item->id, 'category_id' => $order->item->category_id], ['class' => 'btn btn-blue'])?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?endforeach;?>
                    </div>
                    <?= CustomPagination::widget([
                        'pagination' => $pages,
                        'maxButtonCount'=>5,
                    ]);?>
                </div>
            <?else:?>
                <div class="empty-container text-center">
                    <img class="img-responsive" src="/images/no-results.png">
                </div>
            <?endif;?>
        </div>
    </div>
</section>
