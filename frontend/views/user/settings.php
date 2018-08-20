<?
use common\widgets\Alert;
use dosamigos\switchinput\SwitchBox;
use frontend\widgets\LeftInfo;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>
<section id="user-page">
    <div class="container">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">
                    <li><?= Html::a('Browse ', '/browse/all')?></li>
                    <?if(Yii::$app->user->identity->display_type == 1):?>
                        <li><?= Yii::$app->user->identity->first_name .' '. Yii::$app->user->identity->last_name[0]?>.</li>
                    <?elseif (Yii::$app->user->identity->display_type == 2):?>
                        <li><?= Yii::$app->user->identity->first_name .' '. Yii::$app->user->identity->last_name?></li>
                    <?elseif (Yii::$app->user->identity->display_type == 3):?>
                        <li><?= Yii::$app->user->identity->display_name?></li>
                    <?endif;?>
                    <li><?= 'Settings'?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <?= LeftInfo::widget()?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 clearfix">
                <div class="portlet-form sub-level">
                    <div class="caption-title">
                        <h4>Personal Information</h4>
                        <?= !empty(Yii::$app->request->post('personal-information')) ?  Alert::widget() : null ?>
                    </div>
                    <?php $form = ActiveForm::begin(['validateOnBlur'=>false,]); ?>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7 col-xs-12">
                                    <div class="row form-group">
                                        <label class="control-label col-md-8 col-xs-6">Hide My Items</label>
                                        <div class="col-md-4 col-xs-6 text-right hide-items">
                                            <? $hideItems->hide_items = $user->hide_from ? 1 : $user->hide_items?>
                                            <?= $form->field($hideItems, 'hide_items')->widget(SwitchBox::className(),[
                                                'options' => [
                                                    'label' => false,
                                                    'class' => 'alert-status',
                                                ],
                                                'clientOptions' => [
                                                    'checked' => true,
                                                  //  'size' => 'mini', 03/30/2017
                                                    'onText' => 'Yes',
                                                    'offText' => 'No',
                                                    ['label' => 'Yes', 'value' => 1],
                                                    ['label' => 'No', 'value' => 0]
                                                ]
                                            ])->label(false);?>
                                        </div>
                                    </div>
                                    <div class="input-daterange personal <?= ($user->hide_items || $user->hide_from) ? ' ' : 'hide'?>">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <?= $form->field($hideItems, 'from', ['template' => '
                                                    <label class="small-lb">From</label>
                                                    <div class="input-icon"><i class="fa fa-calendar"></i>{input}</div>'])
                                                    ->textInput(['class' => 'form-control', 'value' => $user->hide_from ? Yii::$app->formatter->asDate($user->hide_from, 'php:m/d/Y') : ''])->label(false);
                                                ?>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <?= $form->field($hideItems, 'to', ['template' => '
                                                    <label class="small-lb">To</label>
                                                    <div class="input-icon"><i class="fa fa-calendar"></i>{input}</div>'])
                                                    ->textInput(['class' => 'form-control', 'value' =>  $user->hide_to ? Yii::$app->formatter->asDate($user->hide_to  , 'php:m/d/Y') : ''])->label(false);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 clearfix">
                                <div class="button-grope pull-right">
                                    <?= Html::submitInput('Update', ['class' => 'btn btn-blue', 'name' => 'personal-information']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="portlet-form sub-level">
                    <div class="caption-title">
                        <h4>Change Email</h4>
                        <?= !empty(Yii::$app->request->post('change-email')) ?  Alert::widget() : null ?>
                    </div>
                    <?php $form = ActiveForm::begin(['validateOnBlur'=>false,]); ?>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7 col-xs-12">
                                    <?= $form->field($change_email, 'change_email')
                                        ->textInput(['maxlength' => true, 'value' => $user->email])
                                        ->label(' Email <span class="required" aria-required="true"> * </span>')
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 clearfix">
                                <div class="button-grope pull-right">
                                    <?= Html::submitInput('Update', ['class' => 'btn btn-blue', 'name' => 'change-email']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="portlet-form sub-level">
                    <div class="caption-title">
                        <h4>Change Password</h4>
                        <?= !empty(Yii::$app->request->post('change-password')) ?  Alert::widget() : null ?>
                    </div>
                    <?php $form = ActiveForm::begin(['validateOnBlur'=>false,]); ?>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7 col-xs-12">
                                    <?= $form->field($change_password, 'old_password')->passwordInput(['maxlength' => true])
                                        ->label('Old Password <span class="required" aria-required="true"> * </span>')
                                    ?>

                                    <?= $form->field($change_password, 'new_password')->passwordInput(['maxlength' => true])
                                        ->label('New Password <span class="required" aria-required="true"> * </span>')
                                    ?>

                                    <?= $form->field($change_password, 'confirm_password')->passwordInput(['maxlength' => true])
                                        ->label('Confirm Password <span class="required" aria-required="true"> * </span>')
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 clearfix">
                                <div class="button-grope pull-right">
                                    <?= Html::submitInput('Update', ['class' => 'btn btn-blue', 'name' => 'change-password']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="portlet-form sub-level">
                    <div class="caption-title">
                        <h4>Additional Settings</h4>
                        <?= !empty(Yii::$app->request->post('additional-settings')) ?  Alert::widget() : null ?>
                    </div>
                    <?php $form = ActiveForm::begin(['validateOnBlur'=>false,]); ?>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7 col-xs-12">
                                    <div class="row form-group">
                                        <label class="control-label col-md-8 col-xs-6">Receive Notifications On Email</label>
                                        <div class="col-md-4 text-right">
                                            <? $additional_settings->notifications_email = $user->notifications_email?>
                                            <?= $form->field($additional_settings, 'notifications_email')->widget(SwitchBox::className(),[
                                                'options' => [
                                                    'label' => false,
//                                                    'class' => 'hide-items',
                                                ],
                                                'clientOptions' => [
                                                    'checked' => true,
                                                    'onText' => 'Yes',
                                                    'offText' => 'No',
                                                    ['label' => 'Yes', 'value' => 1],
                                                    ['label' => 'No', 'value' => 0]
                                                ]
                                            ])->label(false);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-xs-6 clearfix">
                                <div class="button-grope pull-right">
                                    <?= Html::submitInput('Update', ['class' => 'btn btn-blue', 'name' => 'additional-settings']) ?>
                                </div>
                            </div>
                        </div>
                     <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
