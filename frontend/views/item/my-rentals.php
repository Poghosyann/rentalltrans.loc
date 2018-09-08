<?php

use common\components\CustomPagination;
use common\models\Marka;
use frontend\widgets\LeftInfo;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'RentAllTrans.com';
?>
<section id="user-page">
    <div class="container">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
            <div class="actions clearfix">
                <?php $form = ActiveForm::begin([
                    'validateOnBlur'=>false,
                    'action' => '', 'method' => 'get',
                    'options' => [
                        'class' => ''
                    ]]);
                ?>
                <?if(!empty($categories)):?>
                    <div class="form-group btn-group">
                        <label class="control-label">Category:</label>
                        <div class="filter-select">
                            <?= Html::dropDownList('category', Yii::$app->request->get('category'),
                                $categories,
                                [
                                    'class' => 'form-control',
                                    'onchange' => "this.form.submit()",
                                ])
                            ?>
                        </div>
                    </div>
                <?endif;?>
                <div class="form-group btn-group">
                    <label class="control-label">Price:</label>
                    <div class="filter-select">
                        <?= Html::dropDownList('price', Yii::$app->request->get('price'),
                            [
                                'low' => 'Low to High',
                                'high' => 'High to Low',
                            ],
                            [
                                'class' => 'form-control',
                                'onchange' => "this.form.submit()",
                            ])
                        ?>
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
                    <?if(!empty($items)):?>
                        <?foreach ($items as $item):?>

                            <div class="panel profile-widget">
                                <!--this cols -->
                                <div class="col-sm-3 col-md-3 col-lg-3 col-xs-12">
                                    <?if(isset($item->image->path)):?>
                                        <div class="bg-img">
                                            <img src="<?= "/uploads/items/".$item->id.'/'.$item->images[0]->path?>">
                                        </div>
                                    <?endif;?>
                                    <div class="brand-logo">
                                        <img src="<?= $item->user->image ? '/uploads/users/115-115/'.$item->user->image : '/images/default.jpg'?>">
                                    </div>
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
                                    </div>
                                    <div class="choose text-center">

                                    </div>
                                </div>
                                <? if($item->status == 'Available'):?>
                                    <div class="mt-icon av">Available</div>
                                <?elseif ($item->status == 'Draft'):?>
                                    <div class="mt-icon dr">Draft</div>
                                <?elseif ($item->status == 'Not Available'):?>
                                    <div class="mt-icon nv">Not Available</div>
                                <?endif;?>
                                <!--this cols -->
                                <div class="col-sm-4 col-xs-12 price">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4">
                                            <div class="profile-stat-text"> 1-3 days </div>
                                            <div class="days-price"><?= $item->price_daily ?> AMD</div>
                                        </div>
                                        <div class="col-md-4 col-xs-4">
                                            <div class="profile-stat-text"> 4-6 days </div>
                                            <div class="days-price"><?= $item->price_3_days ?? '-'?> AMD</div>
                                        </div>
                                        <div class="col-md-4 col-xs-4">
                                            <div class="profile-stat-text"> 7-10 days </div>
                                            <div class="days-price"><?= $item->price_weekly ?? '-'?> AMD</div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <div class="text-center">
                                            <?= Html::a('Edit Item', ['/user/my-items/edit-item', 'id' => $item->id, 'category_id' => $item->category_id], ['class' => 'btn btn-blue'])?>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both"></div>
                            </div>
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
