<?php

use kartik\file\FileInput;
use kotchuprik\sortable\grid\Column;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">
    <div class="box box-info">
        <div class="box-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?if($model->id == 6):?>
                <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                    ],
                    'pluginOptions' => [
                        'uploadUrl' => false,
                        'maxFileCount' => 1,
                        'uploadExtraData' => [
                            'id' => $model->id,
                        ],
                        'initialPreview' => (!$model->isNewRecord && $model->image) ? Html::img($model->image, array('width' => '300px')) : '',
                        'allowedFileExtensions' =>  ['jpg', 'png','gif'],
                        'showUpload' => false,
                        'showRemove' => true,
                        'dropZoneEnabled' => true
                    ]
                ]);?>
            <?endif;?>
            <?if($model->id == 2):?>
                <hr>
                <p>
                    <?= Html::a('Create Team', ['teams/create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'rowOptions' => function ($dataProvider, $key, $index, $grid) {
                        return ['data-sortable-id' => $dataProvider->id];
                    },

                    'columns' => [
                        ['class' => Column::className(),],
                        [
                            'attribute' => 'image',
                            'format'=>'raw',
                            'value'=>function ($model, $index, $widget){
                                return Html::img("/uploads/teams/120-120/".$model->image,['width' => '70px']);
                            }
                        ],
                        'full_name',
                        'type',
                        [
                            'class' => \yii\grid\ActionColumn::className(),
                            'buttons'=>[
                                'view'=>function ($url, $model) {
                                    $customurl=Yii::$app->getUrlManager()->createUrl(['teams/view','id'=>$model->id, 'page_id' => $model->page_id]);
                                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl);
                                },
                                'update'=>function ($url, $model) {
                                    $customurl=Yii::$app->getUrlManager()->createUrl(['teams/update','id'=>$model->id, 'page_id' => $model->page_id]);
                                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl);
                                },
                                'delete'=>function ($url, $model) {
                                    $customurl=Yii::$app->getUrlManager()->createUrl(['/teams/delete','id'=>$model->id, 'page_id' => $model->page_id]);
                                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl);
                                }
                            ],
                            'template'=>'{view}  {update} {delete}',
                        ],
                    ],
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => \yii\helpers\Url::toRoute(['/teams/sorting']),
                        ]
                    ],
                ]); ?>
                <hr>
            <?else:?>
                <?= $form->field($model, 'description')->label(false)->widget(CKEditor::className(),[
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                        'preset' => 'full',
                        'inline' => false,
                        'contentsCss' => '/../css/style2.css'
                    ]),
                ]);
                ?>
            <?endif;?>

            <?= $form->field($model, 'footer_menu')->checkbox() ?>

            <div class="box box-default box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">META-TAGS</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: none;">
                    <div class="alert alert-info ">
                        <p>250 Maximum number of characters, the rest of the text will be cut.</p>
                    </div>
                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
