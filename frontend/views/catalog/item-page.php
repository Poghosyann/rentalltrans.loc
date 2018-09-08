<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 3/3/2017
 * Time: 3:26 PM
 */

use common\models\Connection;
use common\models\Marka;
use kartik\checkbox\CheckboxX;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'RentAllTrans.com - ' . $item->id;

?>
<?php $form = ActiveForm::begin(['action' => '/payment/pay', 'id' => 'forum_post', 'method' => 'post',]) ?>
<section id="item-page">
    <div class="container items-page">
        <div class="portlet-header clearfix">
            <div class="caption hidden-xs hidden-sm">
                <ol class="breadcrumb">

                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 margin_bottom">
                <div class="row">

                    <div class="nav nav-pills nav-item-info fix-nav toTheTop">
                        <div class="col-md-6">
                            <div class="product-information">
                                <div class="info">
                                    <p><?= Marka::findOne($item->model->mark_id)->mark?> - <?=$item->model->model?> or analog</p>
                                </div>
                                <div >
                                    <img style="width: 100%" src="<?=  !empty($item->image_main) ? '/uploads/item/'.$item->image_main : "/uploads/items/".$item->id.'/'.$item->images[0]->path?>">
                                </div>
                                <div class="brand-logo">
<!--                                    <img src="--><?//= $item->user->image ? '/uploads/users/115-115/'.$item->user->image : '/images/default.jpg'?><!--">-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-information">
                                <div class="info">
                                    <p>Information about transport</p>
                                </div>
                                <span><b>Type of body: </b> <?= $item->typeBody->title?></span>
                                <span><b>Doors: </b> <?= $item->quantity_doors?></span>
                                <span><b>Class: </b> <?= $item->class->title?></span>
                                <span><b>Transmission: </b> <?= $item->transmissionVehicles->title?></span>
                                <span><b>Climate control: </b> Yes</span>
                                <span><b>Steering wheel: </b> right</span>
                                <span><b>Year of manufacture: </b> <?= $item->year_manufacture?></span>

                                <div class="info">
                                    <p>Getting transport</p>
                                </div>
                                <span><b>Location: </b> Yerevan</span>
                                <span><b>Date: </b> <?= $session_rent['from']?></span>
                                <!--this span added for time-->
                                <span><b>Time: </b> <?= $session_rent['from_h']?>:<?= $session_rent['from_i']?></span>
                               <!--this span added for time-->
                                <div class="info">
                                    <p>Return of transport</p>
                                </div>
                                <span><b>Location: </b> Yerevan</span>
                                <span><b>Date: </b> <?= $session_rent['to']?></span>
                                <!--this span added for time-->
                                <span><b>Time: </b> <?= $session_rent['to_h']?>:<?= $session_rent['to_i']?></span>
                                <!--this span added for time-->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="product-information">
                    <div class="info">
                        <?if(!empty($additional_products1)):?>
                            <p>Prices of additional insurance for one day
                            <div class="row" id="additional-insurance">
                                <?foreach ($additional_products1 as $product1):?>
                                    <label class="my-checkbox checkbox" title="<?= Html::encode($product1->description) ?>">
                                        <div class="col-xs-6 col-md-7">
                                            <span>
                                                <?= $product1->name?>
                                            </span>
                                        </div>
                                        <div class="col-xs-6 col-md-5">
                                            <?
                                                if($session_rent['days'] > 4){
                                                    $casco =  ($item->car_price * 0.05)/100;
                                                }else{
                                                    $casco =  ($item->car_price * 0.08)/100;
                                                }
                                            ?>
                                            <span>Price AMD <?= ($product1->id == 10 ? $casco : $product1->price)?></span>
                                            <?= $form->field($model_rent_price,"additional[$product1->id]")
                                                ->checkbox(['class' => 'hide', 'value' => ($product1->id == 10 ? $casco : $product1->price)])
                                                ->label(false)?>
                                        </div>
                                    </label>
                                <?endforeach;?>
                            </div>
                        <?endif;?>
                        <?if(!empty($additional_products2)):?>
                            <p>Prices for additional services for one day
                            <div class="row" id="additional-services">
                                <?foreach ($additional_products2 as $product2):?>
                                    <label class="my-checkbox checkbox"  title="<?= Html::encode($product2->description) ?>">
                                        <div class="col-xs-6 col-md-7">
                                            <span><?= $product2->name?></span>
                                        </div>
                                        <div class="col-xs-6 col-md-5">
                                            <span>Price AMD <?= $product2->price?></span>
                                            <?= $form->field($model_rent_price,"additional[$product2->id]")
                                                ->checkbox(['class' => 'hide', 'value' => $product2->price])
                                                ->label(false)?>
                                        </div>
                                    </label>
                                <?endforeach;?>
                            </div>
                        <?endif;?>
                    </div>
                </div>

                <div class="product-information" style="min-height: 305px;">
                    <div class="info">
                        <?if(!empty($additional_products3)):?>
                            <p>Prices for transport delivery </p>
                            <div class="row" id="transport-delivery">
                                <?foreach ($additional_products3 as $product3):?>
                                    <label class="my-checkbox checkbox"  title="<?= Html::encode($product3->description) ?>">
                                        <div class="col-xs-6 col-md-7">
                                            <span title="flan fstan Insurance flan fstan Insurance flan fstan Insurance flan fstan Insurance flan fstan">
                                                <?= $product3->name?>
                                            </span>
                                        </div>
                                        <div class="col-xs-6 col-md-5">
                                            <span>Price AMD <?= $product3->price?></span>
                                            <?= $form->field($model_rent_price,"additional[$product3->id]")
                                                ->checkbox(['class' => 'hide', 'value' => $product3->price])
                                                ->label(false)?>
                                        </div>
                                    </label>
                                <?endforeach;?>
                            </div>
                        <?endif;?>
                    </div>
                </div>

                <div class="price-information"  style="min-height: 305px;" data-rent="<?= $session_rent['days']?>">

                    <div class="row">
                        <div class="pull-right">
                            <p class="product-price">
                                <span>Price for additional insurance: </span>AMD <span id="price-for-additional-insurance"> 0</span>
                            </p>

                            <p class="product-price">
                                <span>Price for additional services: </span>AMD <span id="price-for-additional-services"> 0</span>
                            </p>

                            <p class="product-price">
                                <span>Prices for transport delivery: </span>AMD <span id="prices-for-transport-delivery"> 0</span>
                            </p>

                            <p class="product-price">
                                <span>Price for transport: </span>AMD <span id="price-for-transport"> <?= $total_price?></span>
                            </p>
                            <p class="product-price">
                                <span>Total: </span>AMD <span id="total-price"> <?= $total_price?></span>
                            </p>
                        </div>
                    </div>
                    <div class="product-buttons row">
                        <hr>
                        <div class="pull-right">
                            <br>
                            <?= Html::submitButton('Rent Now', ['class' => 'btn btn-blue']) ?>
                        </div>
                        <div class="form-group-required">

                            <?= $form->field($model_rent_price,'checkbox')->checkbox(['uncheckValue' => null])
                                ->label("Acquainted and agree <a  data-toggle=\"modal\" data-target=\"#myModal\">Site Terms</a>,
                                               <a  data-toggle=\"modal\" data-target=\"#modal-privacy-policy\">Privacy Policy</a>")?>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
<?php ActiveForm::end(); ?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg site-terms" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $site_terms->title?></h5>
            </div>
            <div class="modal-body">
                <?= $site_terms->description?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg site-terms" id="modal-privacy-policy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $privacy_policy->title?></h5>
            </div>
            <div class="modal-body">
                <?= $privacy_policy->description?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
