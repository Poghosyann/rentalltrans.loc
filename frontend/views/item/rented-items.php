<?
use common\components\CustomPagination;
use common\models\Connection;
use frontend\widgets\LeftInfo;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Items I\'ve Rented';
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
                                <a href="<?= Yii::$app->user->id == $order->itemUser->id ? '/user/my-items?status=available' : '/user/'.$order->itemUser->username?>/rental-items">
                                    <img src="<?= $order->itemUser->image ? '/uploads/users/115-115/'.$order->itemUser->image : '/images/default.jpg'?>">
                                </a>
                            </div>
                            <div class="profile-name">
                                <div class="name-data clearfix">
                                    <p class="pull-left">
                                        <a href="<?= Yii::$app->user->id == $order->itemUser->id ? '/user/my-items?status=available' : '/user/'.$order->itemUser->username?>/rental-items">
                                            <?if($order->itemUser->display_type == 1):?>
                                                <?= $order->itemUser->first_name .' '. $order->itemUser->last_name[0]?>.
                                            <?elseif ($order->itemUser->display_type == 2):?>
                                                <?= $order->itemUser->first_name .' '. $order->itemUser->last_name?>
                                            <?elseif ($order->itemUser->display_type == 3):?>
                                                <?= $order->itemUser->display_name?>
                                            <?endif;?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="product-body">
                                <p><?= $order->item->model->model?></p>
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
                                    <a href="javascript:void(0)" class="btn btn-line" data-toggle="<?= 'modal'?>" data-target="#ownerModal<?=$order->itemUser->id?>"><i class="fa fa-envelope-o"></i> Contact Owner</a>
                                </div>
                            </div>
                        </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="ownerModal<?=$order->itemUser->id?>" tabindex="-1" role="dialog" aria-labelledby="ownerModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <div class="modal-icon"><img src="/images/ico.png"></div>
                                        <h5 class="modal-title">Contact Owner</h5>
                                    </div>
                                    <?php $form = ActiveForm::begin(['action' => '/chat/send-messages']);?>
                                    <div class="contact-owner modal-body">
                                        <div class="seller-information">
                                            <div class="seller-info-header clearfix">
                                                <div class="pull-left to-owner">To:</div>
                                                <div class="pull-right">
                                                    <a href="/user/<?= $order->itemUser->username?>/rental-items"><i class="fa fa-link"></i> <?= $connection->type ?? 'N/A'?></a>
                                                </div>
                                            </div>
                                            <div class="mt-comment clearfix">
                                                <div class="mt-comment-img">
                                                    <?= Html::img($order->itemUser->image ? '/uploads/users/115-115/'.$order->itemUser->image : '/images/default.jpg', ['alt' => 'Owner'])?>
                                                </div>
                                                <div class="mt-comment-body">
                                                    <div class="mt-comment-info">
                                                        <?if($order->itemUser->display_type == 1):?>
                                                            <?= $order->itemUser->first_name .' '. $order->itemUser->last_name[0]?>.
                                                        <?elseif ($order->itemUser->display_type == 2):?>
                                                            <?= $order->itemUser->first_name .' '. $order->itemUser->last_name?>
                                                        <?elseif ($order->itemUser->display_type == 3):?>
                                                            <?= $order->itemUser->display_name?>
                                                        <?endif;?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="to-rent">Item To Rent:</div>
                                        <div class="row for-item">
                                            <div class="image-buyrent-content col-md-2 col-sm-2 col-xs-3">
                                                <img class="img-responsive" src="<?= "/uploads/items/".$order->item->id.'/'.$order->item->images[0]->path?>" alt="item">
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-9 information-body">
                                                <div class="card-rentbuy-title">
                                                    <?= $order->item->model->model?>
                                                </div>
                                                <div class="card-rentbuy-subtitle">
                                                    <?= Html::a($order->item->category->title, '/browse/'.$order->item->category->alias, ['class' => 'category-name'])?>
                                                </div>
                                            </div>
                                        </div>

                                        <?= $form->field($chat_model, 'message')->textarea(['placeholder' => 'Message', 'class' => 'form-control'])->label(false) ?>
                                        <?= $form->field($chat_model, 'userId')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
                                        <?= $form->field($chat_model, 'user_id2')->hiddenInput(['value' => $order->itemUser->id])->label(false) ?>
                                        <?= $form->field($chat_model, 'order_id')->hiddenInput(['value' => $order->id])->label(false) ?>
                                        <?= $form->field($chat_model, 'base_url')->hiddenInput(['value' => Yii::$app->request->absoluteUrl])->label(false) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-line" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-blue">Send Message</button>
                                    </div>
                                    <?php ActiveForm::end(); ?>
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