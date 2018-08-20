<?php

use common\models\CategoryHasFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\Filter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-form">
    <div class="box box-info">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="form-group col-md-6">
                    <?php echo $form->field(new CategoryHasFilter(), 'category_id')->checkboxList(
                        ArrayHelper::map(Category::find()->where(['status' => 1, 'add_item' => 1])->orderBy(['order' => SORT_ASC])->all(), 'id', 'title'), [
                        'item' =>
                            function ($index, $label, $name, $checked, $value) {
                                $v = CategoryHasFilter::findOne(['category_id' => $value, 'filter_id' => Yii::$app->request->get('id')]);

                                if ($value == $v['category_id']) {
                                    $checked = true;
                                }

                                return Html::checkbox($name, $checked, [
                                    'value' => $value,
                                    'label' => '<label for="category_' . $value . '">' . $label . '</label>',
                                    'labelOptions' => [
                                        'class' => 'ckbox ckbox-primary col-md-3',
                                    ],
                                    'id' => 'category_'.$value,
                                ]);
                            },
                        'separator'=>false,'template'=>'<div class="item">{input}{label}</div>',]);
                    ?>
                    <div style="clear: both"></div>
                </div>
                <div class="form-group col-md-6"></div>
            </div>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
