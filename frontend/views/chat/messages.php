<?php

use common\models\Connection;
use common\models\Marka;
use common\models\RefundPrice;
use common\models\User;
use common\widgets\Alert;
use frontend\widgets\ChatRoom;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use common\models\Setting;

$this->title = 'Messages';
$this->registerJsFile('/js/chat2.js',['position' => \yii\web\View::POS_END, 'depends' => [\yii\web\YiiAsset::className()]]);
$max_days = (int) Setting::findOne(7)->value;

?>

<section id="chat-content">
    <div class="container">
        <div class="portlet-header clearfix">

        </div>
        <div class="row">
            <?= Alert::widget()?>
            <div class="col-md-4 col-sm-4">
                <div class="chat-inner sidebar-body toTheTop">
                    <div class="chat-header clearfix">
                        <div class="chat-caption">
                            Messages
                        </div>
                    </div>
                    <div class="chat-search-group">
                        <div class="portlet-input input-inline">
                            <div class="input-icon right">
                                <i class="fa fa-search"></i>
                                <input id="queue-search" type="text" class="form-control input-circle" placeholder="Search...">
                            </div>
                        </div>
                        <form class="" method="get">
                            <div class="actions row">

                                <div class="col-md-12 col-sm-12 col-xs-12 form-group btn-group">
                                    <?= Html::dropDownList('day', $user_data['dey'] ?? 7,
                                        [
                                            'all' => 'All',
                                            'last' => 'Last Chat',
                                            'unread' => 'Unread',
                                        ],
                                        [
                                            'class' => 'form-control js-states chat-dey',
                                            'id' => 'rentdate2-to_location'
                                        ])
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div data-scroll-speed="1" class="chat-group inner-content-chat1 chat-height" id="<?= !empty($banner_left) ? $banner_left->id_class : ''?>">
                        <ul class="media-list list-items">
                            <div id="chat-user">
                                <?= $chat_users ?>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <? if (!empty($user2)):?>
                    <div class="portlet-light-bordered">
                        <?if (!empty($order)):?>
                            <div class="chat-portlet-header">
                                <div class="row">
                                    <div class="image-buyrent-content col-md-2 col-sm-2 col-xs-3">
                                        <div class="thumbnail-chat">
                                            <img class="img-port img-responsive" src="/uploads/items/<?= $order->item->id?>/<?= $order->item->getImages()->one()->path?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-9 information-body">
                                        <div class="card-rentbuy-title">
                                            <?= Marka::findOne($order->item->model->mark_id)->mark?> - <?=$order->item->model->model?> or analog
                                        </div>
                                        <div class="card-rentbuy-subtitle">
                                            ORDER ID: <?= $order->id?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-xs-4">
                                                <div class="days-price">
                                                    <div class="when-text">From</div>
                                                    <div class="days-for-card"><?= $order->from?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <div class="days-price">
                                                    <div class="when-text">To</div>
                                                    <div class="days-for-card"><?= $order->to?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <div class="days-price">
                                                    <div class="when-text">Total</div>
                                                    <?
                                                    $startDate = new DateTime($order->from);
                                                    $endDate = new DateTime($order->to);
                                                    $interval = $startDate->diff($endDate);

                                                    $days = $interval->days == 0 ? 1 : $interval->days;
                                                    ?>
                                                    <div class="days-for-card"><?= $days?> Days</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="pull-right text-right">
                                            <div class="product-price">
                                                <?= $order->rental_price + $order->service_price?> AMD
                                            </div>
                                            <div class="accept-deciline">

                                                <?
                                                $date = new DateTime('now');
                                                ?>

                                                <?if($order->item_user_id == Yii::$app->user->id):?>
                                                    <?if($order->status == 1):?>
                                                        <p>
                                                            <?if ($order->from > $date->format('Y-m-d')):?>
                                                                <a href="/payment/status/5/<?= $order->id ?>" class="btn btn-red">Cancel</a>
                                                            <?else:?>
                                                                Accepted
                                                            <?endif;?>
                                                        </p>
                                                    <?elseif($order->status == 2):?>
                                                        <p>Canceled</p>
                                                    <?elseif ($order->status == 3 || ($order->status == 4) || ($order->status == 5)):?>
                                                        <p>Canceled</p>
                                                    <?elseif (($order->status == 0) && ($order->to < $date->format('Y-m-d'))):?>
                                                        <p>Expired</p>
                                                    <?elseif ($order->status == 0):?>
                                                        <a href="/payment/status/1/<?= $order->id ?>" class="btn btn-blue">Accept</a>
                                                        <a href="/payment/status/2/<?= $order->id ?>" class="btn btn-red">Cancel</a>
                                                    <?endif;?>
                                                <?else:?>
                                                    <?if(($order->status == 1)):?>
                                                        <p>
                                                            <?if (($order->from > $date->format('Y-m-d'))):?>
                                                                <a href="/payment/status/4/<?= $order->id ?>" class="btn btn-red">Cancel</a>
                                                            <?else:?>
                                                                Accepted
                                                            <?endif;?>
                                                        </p>
                                                    <?elseif($order->status == 2):?>
                                                        <p>Canceled</p>
                                                    <?elseif (($order->status == 3) || ($order->status == 4) || ($order->status == 5)):?>
                                                        <p>Canceled</p>
                                                    <?elseif (($order->status == 0) && $order->to < $date->format('Y-m-d')):?>
                                                        <p>Expired</p>
                                                    <?elseif (($order->status != 3) && ($order->from >= $date->format('Y-m-d')) && ($order->status != 6) && ($order->status != 7)):?>
<!--                                                        <a href="/payment/status/3/--><?//= $order->id ?><!--" class="btn btn-red">Cancel</a>-->
                                                    <?endif;?>
                                                <?endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                        <div class="portlet-body-chat">
                            <div id="mess" class="chat-group inner-content-chat">
                                <div class="portlet-body-chat">
                                    <ul class="chats">
                                        <div id="chat-box" >
                                            <?=$data?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="chat-form row">
                                <div class="input-cont col-md-10 col-sm-9">
                                    <input data-userid="<?= $user2->id?>" data-userid1="<?= Yii::$app->user->id?>" data-session="<?= Yii::$app->session->getId()?>" name="Chat[message]" id="chat_message" placeholder="Type a message here..." class="form-control">
                                </div>
                                <div class="btn-cont col-md-2 col-sm-3">
                                    <button type="submit" class="btn btn-send-comment btn-blue" data-url="<?=Url::to(['/chat/send-chat']);?>"  data-alias="<?= $user2->username;?>" data-orderid="<?= $order_id?>"><i class="fa fa-paper-plane"></i> Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?else:?>
                    <div class="empty-container text-center">
                        <img class="img-responsive" src="/images/no-results.png">
                        <h2>NO MESSAGE SELECTED</h2>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
</section>

