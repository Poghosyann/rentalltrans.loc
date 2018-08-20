<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\orderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <div class="box box-info">
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= \fedemotta\datatables\DataTables::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
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
                            return Html::a($user_name, '/user/'.$user->username.'/rental-items', array('target' => '_blank'));
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
                            return Html::a($user_name, '/user/'.$user->username.'/rental-items', array('target' => '_blank'));
                        }
                    ],
                    [
                        'attribute' => 'item_id',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            $item = \common\models\Item::findOne($model->item_id);

                            return Html::a($item->title, '/item/'.$item->alias, array('target' => '_blank'));
                        }
                    ],
                    'type',
                    'from',
                    'to',
                     'rental_price',
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
