<?php

use common\models\Category;
use common\models\Filter;
use common\models\ItemHasFilter;
use common\models\Model;
use common\models\Setting;
use common\widgets\Alert;
use frontend\widgets\LeftInfo;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <!--this cols-->
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
        <!--this cols-->
        <?= LeftInfo::widget()?>

    </div>
    <!--this cols-->
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9 clearfix">
        <!--this cols-->
        <!--this class name'add-item-portlet-form'-->
        <div class="portlet-form add-item-portlet-form">
            <!--this class name'add-item-portlet-form'-->
            <div class="caption">
                <h4><?= $title?></h4>
                <?= Alert::widget() ?>
            </div>
            <?php $form = ActiveForm::begin(['validateOnBlur'=>false,'options' => ['enctype' => 'multipart/form-data']]) ?>
            <div class="caption-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <?= $form->field($model, 'country_id')->dropDownList(
                                ArrayHelper::map($countries, 'id', 'name'),
                                [
                                    'prompt'=>'',
                                    'class' => 'form-control',
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
                                    'class' => 'form-control',
                                    'value' => null,
                                ])
                                ->label('City <span class="required" aria-required="true"> * </span>')
                            ?>
                        </div>
                        <?= $form->field($model, 'category_id')->dropDownList(
                            ArrayHelper::map(Category::find()->where(['status' => 1, 'add_item' => 1])->orderBy(['order' => SORT_ASC])->all(), 'id', 'title'),
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Category <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'class_id')->dropDownList(
                            ArrayHelper::map($item_class, 'id', 'title'),
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Class <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'mark_id')->dropDownList(
                            ArrayHelper::map($marka, 'id', 'mark'),
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Mark <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'model_id')->dropDownList(
                            ArrayHelper::map(Model::find()->where(['mark_id' => $model->mark_id])->all(), 'id', 'model'),
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Model <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'year_manufacture')->dropDownList(
                            $year,
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Year Manufacture <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'quantity_doors')->dropDownList(
                            [1=>1,2,3,4,5,6,7,8,9,10],
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Quantity of Doors of Transport <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'type_body_id')->dropDownList(
                            ArrayHelper::map($type_body, 'id', 'title'),
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Type of body of transport <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'transmission_vehicles_id')->dropDownList(
                            ArrayHelper::map($transmission_vehicles, 'id', 'title'),
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Transmission of vehicles <span class="required" aria-required="true"> * </span>')
                        ?>

                        <?= $form->field($model, 'steering_wheel')->dropDownList(
                            ['right' => 'Right', 'left' => 'Left'],
                            [
                                'prompt'=>'',
                                'class' => 'form-control',
                                'value' => null,
                            ])
                            ->label('Steering wheel <span class="required" aria-required="true"> * </span>')
                        ?>
                        <div class="form-group">
                            <?php echo $form->field(new ItemHasFilter(), 'filter_id')->checkboxList(
                                ArrayHelper::map(Filter::find()->joinWith(['categoryHasFilters'])->where(['category_has_filter.category_id' => $model->category->id])->all(), 'id', 'title'), [
                                'item' =>
                                    function ($index, $label, $name, $checked, $value) {
                                        $v = ItemHasFilter::findOne(['filter_id' => $value, 'item_id' => Yii::$app->request->get('id')]);

                                        if ($value == $v['filter_id']) {
                                            $checked = true;
                                        }

                                        return Html::checkbox($name, $checked, [
                                            'value' => $value,
                                            'label' => '<label for="filter_' . $value . '">' . $label . '</label>',
                                            'labelOptions' => [
                                                'class' => 'ckbox ckbox-primary col-md-6',
                                            ],
                                            'id' => 'filter_'.$value,
                                        ]);
                                    },
                                'separator'=>false,'template'=>'<div class="item">{input}{label}</div>',])->label('Filter');
                            ?>
                            <div style="clear: both"></div>
                        </div>
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


                        <!--<div class="form-group">
                            <label class="control-label">
                                Images
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="images-container clearfix">
                                <?/*for($i = 0; $i < Setting::findOne(5)->value ?? 5; $i++):*/?>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 109px; height: 111px;">
                                            <?/*= Html::img(isset($model->images[$i]) ? "/uploads/items/".$model->id.'/'.$model->images[$i]->path : '/images/fa-camera.png',[
                                                'data-src' => 'holder.js/100%x100%',
                                                'alt' => '100%x100%',
                                                'height' => '100%',
                                                'width' => '100%',
                                                'style' => 'display: block',
                                            ])*/?>
                                        </div>
                                        <div>
                                            <?/*= $form->field($model, 'image[]')->fileInput()->label(false) */?>
                                            <?/*= Html::a(Html::tag('i', '', ['class' => 'fa fa-close']), '#',
                                                ['data-dismiss' => 'fileinput','data-id' => $model->images[$i]->id, 'class' => 'fileinput-exists remove', 'style' => isset($model->images[$i]) ? 'display:block' : ''])
                                            */?>
                                        </div>
                                    </div>
                                <?/*endfor;*/?>
                            </div>
                        </div>-->

                        <!--this form group-->
                        <div class="form-group insurance">
                            <p>Insurance <span class="required" aria-required="true"> * </span></p>
                            <label class="label-container">Yes
                                <input type="radio" value="1" <?= $model->insurance ? 'checked' : ''?> name="Item[insurance]">
                                <span class="checkmark"></span>
                            </label>
                            <label class="label-container">no
                                <input data-deposite="<?= Setting::findOne(2)->value?>" value="0" type="radio" <?= !$model->insurance ? 'checked' : ''?> name="Item[insurance]">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <?= $form->field($model, 'deposit', [
                            'template' => '<label class="small-lb">Non-recoverable amount for deposit</label>
                               <div class="input-group">
                                   <span class="input-group-addon input-circle-left">AMD</span>
                                   {input}
                               </div>',
                        ])->textInput([ 'class' => 'form-control input-circle-right', 'value' => $model->insurance ? $model->deposit : Setting::findOne(2)->value, 'disabled' => $model->insurance ? false : true])->label(false);?>

                        <!--this form group-->
                        <div class="form-group liner-bottom">
                            <label class="control-label">
                                Rental Prices
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'price_daily', [
                                        'template' => '<label class="small-lb">1-3 days</label>
                                           <div class="input-group">
                                               <span class="input-group-addon input-circle-left">AMD</span>
                                               {input}
                                           </div>',
                                    ])->textInput([ 'class' => 'form-control input-circle-right', 'placeholder' => 'Price for 1 day'])->label(false);?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'price_3_days', [
                                        'template' => '<label class="small-lb">4-6 days</label>
                                           <div class="input-group">
                                               <span class="input-group-addon input-circle-left">AMD</span>
                                               {input}
                                           </div>',
                                    ])->textInput(['class' => 'form-control input-circle-right', 'placeholder' => 'Price for 1 day'])->label(false);?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'price_weekly', [
                                        'template' => '<label class="small-lb">7-10 days</label>
                                           <div class="input-group">
                                               <span class="input-group-addon input-circle-left">AMD</span>
                                               {input}
                                           </div>',
                                    ])->textInput(['class' => 'form-control input-circle-right', 'placeholder' => 'Price for 1 day'])->label(false);?>
                                </div>
                                <?if (!$model->isNewRecord && $model->publish):?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small-lb">Willing to rent to</label>
                                        <?= $form->field($model, 'status')->dropDownList([
                                            'Available' => 'Available',
                                            'Not Available' => 'Not Available',
                                        ], ['class' => 'js-states form-control'])->label(false);?>
                                    </div>
                                </div>
                                <?endif;?>
                            </div>
                            <p>By submitting, I agree to the <a href="/company/user-requirements" target="_blank"> User Requirements</a>, <a href="/company/site-terms" target="_blank">Site Terms</a> and <a href="/company/privacy-policy" target="_blank">Privacy Policy</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 clearfix">
                    <?if (!$model->isNewRecord):?>
                        <div class="button-grope pull-left">
                            <?= Html::a("<i class='fa fa-trash-o'></i>", ['delete', 'id' => $model->id, 'category_id' => $model->category_id], [
                                'class' => 'btn',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    <?endif;?>
                    <div class="button-grope pull-right">
                        <?= Html::a('Cancel','/user/rented-items', ['class' =>'btn btn-line reset']) ?>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>