<?php

use common\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
    <div class="box box-info">
        <div class="box-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'User Image',
                        'format'=>'raw',
                        'value' => Html::img($model->image ? '/uploads/users/115-115/'.$model->image : '/images/default.jpg'),
                    ],
                    [
                        'attribute' => 'Full Name:',
                        'format'=>'raw',
                        'value'=> $model->first_name . ' ' . $model->last_name
                    ],
                    'username',
                    'email',
                    'address_line_1',
                    'address_line_2',
                    'email',
                    'cell_phone',
                    'other_phone',
                ],
            ]) ?>

            <br>

            <p>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this user?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a($model->status == User::STATUS_ACTIVE ? 'Block' : 'Unblock', ['view', 'id' => $model->id, 'status' => $model->status == User::STATUS_ACTIVE ? User::STATUS_DELETED : User::STATUS_ACTIVE ], ['class' => 'btn btn-primary']) ?>
            </p>

            <h3> Email</h3>
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-inner'
                ]]); ?>

                <div class="form-group">
                    <?= $form->field($email, 'subject')->textInput(['autofocus' => true, 'placeholder' => 'Subject'])->label(false) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($email, 'message')->textarea(['placeholder' => 'Message', 'class' => 'form-control'])->label(false) ?>
                </div>
                <div class="form-actions text-right">
                    <?= Html::submitButton('Send Message', ['class' => 'btn btn-blue', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
