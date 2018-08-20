<?php

use common\models\Marka;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-price-index">
    <div class="box box-info">
        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                                $text = "";
                                foreach ($model->companyProducts as $product){
                                    $text .= " <p><b>$product->name: </b> <span class='pull-right'>$product->price AMD</span></p>";
                                }
                                echo "<div id=\"myModal$model->id\" class=\"modal fade\" role=\"dialog\">
                                    <div class=\"modal-dialog\">
                                        <!-- Modal content-->
                                        <div class=\"modal-content\">
                                            <div class=\"modal-header\">
                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                                <h4 class=\"modal-title\">Additional products</h4>
                                            </div>
                                            <div class=\"modal-body\">
                                                $text
                                                <hr>
                                                <p><b>Total price: </b> <span class='pull-right'> $model->service_price AMD</span></p>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>";

                            return Html::button($model->id, ['data-toggle' => 'modal', 'data-target' => '#myModal'.$model->id]);
                        }
                    ],
                    'created',
                    [
                        'attribute' => 'item_user_id',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            $user = \common\models\User::findOne($model->item_user_id);

                            if($user->display_type == 1){
                                $user_name = $user->first_name .' '. $user->last_name[0];
                            }elseif ($user->display_type == 2){
                                $user_name = $user->first_name .' '. $user->last_name;
                            }elseif ($user->display_type == 3){
                                $user_name = $user->display_name;
                            }
                            return $user_name;
                        }
                    ],
                    [
                        'attribute' => 'user_id',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            $user = \common\models\User::findOne($model->user_id);

                            if($user->display_type == 1){
                                $user_name = $user->first_name .' '. $user->last_name[0];
                            }elseif ($user->display_type == 2){
                                $user_name = $user->first_name .' '. $user->last_name;
                            }elseif ($user->display_type == 3){
                                $user_name = $user->display_name;
                            }
                            return $user_name;
                        }
                    ],
                    [
                        'attribute' => 'item_id',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            $item = \common\models\Item::findOne($model->item_id);
                            $name = Marka::findOne($item->model->mark_id)->mark ."-". $item->model->model;
                            return $name;
                        }
                    ],
                    'from',
                    'to',
                    'rental_price',
                    'service_price',
                    [
                        'attribute' => 'Total Price',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return $model->rental_price + $model->service_price;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){

                            $date = new DateTime('now');

                            if($model->status == 1){
                                $status = 'Accepted';
                            }elseif($model->status == 2){
                                $status = 'Rejected';
                            }elseif($model->status == 3){
                                $status = 'Canceled';
                            }elseif($model->from < $date->format('Y-m-d')){
                                $status = 'Expired';
                            }elseif($model->status == 0){
                                $status = 'Pending';
                            }

                            return $status;
                        }
                    ],


                    // ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>