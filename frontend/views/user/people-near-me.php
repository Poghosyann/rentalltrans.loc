<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 5/26/2017
 * Time: 10:47 AM
 */

use common\components\CustomPagination;
use common\models\Connection;
use frontend\widgets\LeftInfo;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'People Near Me';
?>

<section id="user-page">
    <div class="container">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
            <div class="actions clearfix top-margin">
                <?php $form = ActiveForm::begin([
                    'validateOnBlur'=>false,
                    'action' => '/user/people-near-me',
                    'method' => 'get',
                    'options' => [
                        'class' => ''
                    ]]);
                ?>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-5 hidden-xs hidden-sm">
                        <input name="search" type="search" class="form-control" value="" placeholder="Search for people near me">
                    </div>
                    <div class="form-group col-lg-2 col-md-3 hidden-xs hidden-sm">
                        <button type="submit" class="btn btn-blue-line"><i class="fa fa-search"></i> Search</button>
                    </div>
                    <div class="form-group btn-group pull-right">
                        <label class="control-label">Name:</label>
                        <div class="filter-select">
                            <?= Html::dropDownList('name', Yii::$app->request->get('name'),
                                [
                                    '0' => 'A-Z',
                                    '1' => 'Z-A',
                                ],
                                [
                                    'class' => 'form-control',
                                    'onchange' => "this.form.submit()",
                                ])
                            ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <?= LeftInfo::widget()?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 clearfix">
                <div class="row">
                    <?if(!empty($users)):?>
                        <?foreach ($users as $user):?>
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xs-12">
                                <div class="my-connections">
                                    <div class="my-con-header clearfix">
                                        <? $connection = Connection::findOne(['user_id' => Yii::$app->user->id, 'user_id1' => $user->id]);?>

                                        <a href="javascript:void(0)"><i class="fa fa-link"></i> <?= $connection->type ?? 'N/A'?></a>
                                    </div>
                                    <div class="mt-comment clearfix">
                                        <div class="mt-connection-img">
                                            <a href="/user/<?= $user->username?>/rental-items">
                                                <img src="<?= $user->image ? '/uploads/users/115-115/'.$user->image : '/images/default.jpg'?>" width="63">
                                            </a>
                                        </div>
                                        <div class="mt-connection-body">
                                            <div class="mt-connection-info">
                                                <a href="/user/<?= $user->username?>/rental-items">
                                                    <?if($user->display_type == 1):?>
                                                        <?= $user->first_name .' '. $user->last_name[0]?>.
                                                    <?elseif ($user->display_type == 2):?>
                                                        <?= $user->first_name .' '. $user->last_name?>
                                                    <?elseif ($user->display_type == 3):?>
                                                        <?= $user->display_name?>
                                                    <?endif;?>
                                                </a>
                                            </div>
                                            <?if(!Yii::$app->user->isGuest):?>
                                                <div class="mt-connection-text">
                                                    <div class="choose">
                                                        <ul class="nav nav-pills nav-justified">
                                                            <?  $degree = Connection::degree($user->id)?>
                                                            <li class="icon-green"><span><i class="icon-1"></i> <?= $degree['type1']?></span></li>
                                                            <li class="icon-blue"><span><i class="icon-2"></i> <?= $degree['type2']?></span></li>
                                                            <li class="icon-yallow"><span><i class="icon-3"></i> <?= $degree['type3']?></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>
                                    <div class="mt-connection-button">
                                        <a href="javascript:void(0)" class="btn btn-line" data-toggle="<?= 'modal'?>" data-target="#ownerModal<?=$user->id?>"><i class="fa fa-envelope-o"></i> Send Message</a>
                                    </div>
                                </div>
                            </div>
                            <?if(!Yii::$app->user->isGuest):?>
                                <!-- Modal -->
                                <div class="modal fade" id="ownerModal<?=$user->id?>" tabindex="-1" role="dialog" aria-labelledby="ownerModalLabel">
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
<!--                                                        <div class="pull-right">-->
<!--                                                            <a href="/user/--><?//= $user->username?><!--/rental-items"><i class="fa fa-link"></i> --><?//= $item->type ? $item->type : 'N/A'?><!--</a>-->
<!--                                                        </div>-->
                                                    </div>
                                                    <div class="mt-comment clearfix">
                                                        <div class="mt-comment-img">
                                                            <?= Html::img($user->image ? '/uploads/users/115-115/'.$user->image : '/images/default.jpg', ['alt' => 'Owner'])?>
                                                        </div>
                                                        <div class="mt-comment-body">
                                                            <div class="mt-comment-info">
                                                                <?if($user->display_type == 1):?>
                                                                    <?= $user->first_name .' '. $user->last_name[0]?>.
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
                        <?endforeach;?>
                    <?else:?>
                        <div class="empty-container text-center">
                            <img class="img-responsive" src="/images/no-results.png">
                        </div>
                    <?endif;?>
                </div>
                <?= CustomPagination::widget([
                    'pagination' => $pages,
                    'maxButtonCount'=>5,
                ]);?>
            </div>
        </div>
    </div>
</section>
