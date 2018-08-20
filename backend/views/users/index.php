<?php

use common\models\User;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' User Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box box-info">
        <div class="box-body">

            <?= DataTables::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'first_name',
                    'last_name',
                    'email',
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return $model->status == User::STATUS_ACTIVE ? 'Active' : 'Blocked';
                        }
                    ],
                    [
                        'attribute' => 'Items',
                        'format'=>'raw',
                        'value'=>function ($model, $index, $widget){
                            return count($model->items);
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
                ],
            ]); ?>
        </div>
    </div>
</div>
