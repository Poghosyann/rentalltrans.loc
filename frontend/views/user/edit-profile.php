<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 2/16/2017
 * Time: 3:29 PM
 */
use common\components\Helper;
use common\widgets\Alert;
use frontend\widgets\LeftInfo;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit Profile';

?>
<section id="user-page">
    <div class="container all-products edit-profile">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <?= LeftInfo::widget()?>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9 clearfix">
                <div class="portlet-form">
                    <div class="caption-title">
                        <h4>Personal Information</h4>
                        <?= Alert::widget() ?>
                    </div>
                    <?php $form = ActiveForm::begin(['validateOnBlur'=>false,'options' => ['enctype' => 'multipart/form-data']]) ?>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 199px; height: 199px;">
                                                <img data-src="holder.js/100%x100%" alt="100%x100%" src="<?= $model->image ? '/uploads/users/115-115/'.$model->image : '/images/fa-camera.png'?>" style="height: 100%; width: 100%; display: block;">
                                            </div>
                                            <div>
                                                <?= $form->field($model, 'image')->fileInput()->label(false) ?>
                                                <a href="#" class="fileinput-exists" data-dismiss="fileinput"><i class="fa fa-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="image-buttons-other">
                                            <a href="javascript:" id="uploads">Change Image</a><span> (i.e. .jpg or .png)</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'first_name', [
                                            'template' => '<label class="">First Name <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'last_name', [
                                            'template' => '<label class="">Last Name <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <label class="">Display as</label>
                                        <div class="mt-radio-list">
                                            <label class="mt-radio mt-radio-center">
                                                <input type="radio" name="User[display_type]" id="optionsRadios22" value="1" <?=$model->display_type == 1 ? 'checked' : ''?> checked>
                                                <?= $model->first_name .' '. $model->last_name[0]?>.
                                                <span></span>
                                            </label>
                                            <label class="mt-radio mt-radio-center">
                                                <input type="radio" name="User[display_type]" id="optionsRadios23" value="2" <?=$model->display_type == 2 ? 'checked' : ''?>>
                                                <?= $model->first_name .' '. $model->last_name?>
                                                <span></span>
                                            </label>
                                        </div>
                                        <label class="mt-radio margin-top-input">
                                            <input type="radio" name="User[display_type]" id="optionsRadios23" <?=$model->display_type == 3 ? 'checked' : ''?> value="3" >
                                            <?= $form->field($model, 'display_name', [
                                                'template' => '{input}',
                                            ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="caption-title sub-caption">
                                <h4>Contact Info</h4>
                            </div>
                        </div>
                        <div class="caption-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <?= $form->field($model, 'country_id')->dropDownList(
                                            ArrayHelper::map($countries, 'id', 'name'),
                                            [
                                                'prompt'=>'',
                                                'class' => 'js-states form-control',
                                                'value' => 7,
                                            ])
                                            ->label('Countries <span class="required" aria-required="true"> * </span>')
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'city_id')->dropDownList(
                                            ArrayHelper::map($cities, 'id', 'name'),
                                            [
                                                'prompt'=>'',
                                                'class' => 'js-states form-control',
                                                'value' => null,
                                            ])
                                            ->label('City <span class="required" aria-required="true"> * </span>')
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'address_line_1', [
                                            'template' => '<label class="">Address Line 1 <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'address_line_2', [
                                            'template' => '<label class="">Address Line 2 </label>{input}',
                                        ])->textInput([ 'class' => 'form-control'])->label(false);?>
                                    </div>


                                    <div class="form-group">
                                        <?= $form->field($model, 'cell_phone', [
                                            'template' => '<label class="">Cellphone (e.g. 123-456-7890) <span class="required" aria-required="true"> * </span></label>{input}',
                                        ])->textInput([
                                                'class' => 'form-control',
                                            ])->label(false);?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($model, 'other_phone', [
                                            'template' => '<label class="">Other Phone (e.g. 123-456-7890) </label>{input}',
                                        ])->textInput([
                                            'class' => 'form-control',
                                        ])->label(false);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 clearfix">
                                <div class="button-grope pull-right">
                                    <?= Html::a('Cancel','/user/rented-items', ['class' =>'btn btn-line reset']) ?>
                                    <?= Html::submitButton('Save Changes', ['class' => 'btn btn-blue']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

