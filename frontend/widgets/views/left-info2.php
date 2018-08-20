<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 1/27/2017
 * Time: 1:59 PM
 */
use common\models\Connection;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>
<div class="sidebar-body">
    <div class="profile-userpic">
        <img src="<?= $user->image ? '/uploads/users/'.$user->image : '/images/default.jpg'?>" class="img-responsive" alt="" data-pin-nopin="true">
        <div class="profile-edit ">
            <i class="fa fa-link"></i> <?= $connection->type ? $connection->type : 'N/A'?>
        </div>
    </div>
    <div class="profile-usertitle-name">
        <?if($user->display_type == 1):?>
            <?= $user->first_name .' '. $user->last_name[0]?>
        <?elseif ($user->display_type == 2):?>
            <?= $user->first_name .' '. $user->last_name?>
        <?elseif ($user->display_type == 3):?>
            <?= $user->display_name?>
        <?endif;?>
        <div class="choose text-center">
            <?if(!Yii::$app->user->isGuest ):?>
                <ul class="nav nav-pills nav-justified">
                    <li class="icon-green"><span><i class="icon-1"></i> <?= $degree['type1']?></span></li>
                    <li class="icon-blue"><span><i class="icon-2"></i> <?= $degree['type2']?></span></li>
                    <li class="icon-yallow"><span><i class="icon-3"></i> <?= $degree['type3']?></span></li>
                </ul>
            <?endif;?>
        </div>
    </div>

    <div class="profile-usermenu">
        <ul>
            <li>
                <a class="<?= Yii::$app->request->pathInfo == 'user/'.$user->username.'/rental-items' ? 'active' : ''?>" href="/user/<?= $user->username?>/rental-items">
                    <span class="pull-right"><?= $rental_count?></span>
                    Rental Items
                </a>
            </li>
            <li>
                <a class="<?= Yii::$app->request->pathInfo == 'user/'.$user->username.'/mutual-connections' ? 'active' : ''?>"  href="/user/<?= $user->username?>/mutual-connections">
                    <span class="pull-right"><?= $connection_count?></span>
                    Mutual Connections
                </a>
            </li>
        </ul>
    </div>
    <div class="profile-userbuttons">
        <a class="btn btn-line degree" href="" data-toggle="modal" data-target="#degreeModal"><i class="fa fa-link"></i> <?= $connection->type ? 'Change' : 'Set'?> Degree</a>
        <a href="javascript:void(0)" class="btn btn-line" data-toggle="<?= 'modal'?>" data-target="#ownerModal"><i class="fa fa-envelope-o"></i> Send Message</a>
    </div>
</div>
<?if(!Yii::$app->user->isGuest):?>
    <!-- Modal -->
    <div class="modal fade" id="ownerModal" tabindex="-1" role="dialog" aria-labelledby="ownerModalLabel">
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
                                <a href="/user/<?= $user->username?>/rental-items"><i class="fa fa-link"></i> <?= $connection->type ? $connection->type : 'N/A'?></a>
                            </div>
                        </div>
                        <div class="mt-comment clearfix">
                            <div class="mt-comment-img">
                                <?= Html::img($user->image ? '/uploads/users/115-115/'.$user->image : '/images/default.jpg', ['alt' => 'Owner'])?>
                            </div>
                            <div class="mt-comment-body">
                                <div class="mt-comment-info">
                                    <?if($user->display_type == 1):?>
                                        <?= $user->first_name .' '. $user->last_name[0]?>
                                    <?elseif ($user->display_type == 2):?>
                                        <?= $user->first_name .' '. $user->last_name?>
                                    <?elseif ($user->display_type == 3):?>
                                        <?= $user->display_name?>
                                    <?endif;?>
                                </div>
                                <div class="mt-comment-text">
                                    <div class="choose">
                                        <?if(!empty(!Yii::$app->user->isGuest)):?>
                                            <ul class="nav nav-pills">
                                                <?  $degree = Connection::degree($user->id)?>
                                                <li class="icon-green"><span><i class="icon-1"></i> <?= $degree['type1']?></span></li>
                                                <li class="icon-blue"><span><i class="icon-2"></i> <?= $degree['type2']?></span></li>
                                                <li class="icon-yallow"><span><i class="icon-3"></i> <?= $degree['type3']?></span></li>
                                            </ul>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($chat_model, 'message')->textarea(['placeholder' => 'Message', 'class' => 'form-control'])->label(false) ?>
                    <?= $form->field($chat_model, 'userId')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
                    <?= $form->field($chat_model, 'user_id2')->hiddenInput(['value' => $user->id])->label(false) ?>
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
<?endif;?>