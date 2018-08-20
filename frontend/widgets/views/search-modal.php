<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

?>
<div id="searchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body container">
                <?php $form = ActiveForm::begin([
                    'validateOnBlur'=>false,
                    'action' => '/catalog/search', 'method' => 'post',
                    'options' => [
                        'class' => 'clearfix'
                    ]]); ?>
                <?= $form->field($rent_date, 'categories')->dropDownList(
                    ArrayHelper::map($categories, 'alias', 'title'),
                    [
                        'prompt' => 'Categories',
                        'class' => 'js-states form-control col-md-12 ',
                        'value' => Yii::$app->request->get('category'),
                    ])->label();
                ?>

                <?= $form->field($rent_date, 'from_location')->dropDownList(
                    [
                        '3' => 'Yerevan'
                    ],
                    [
                        'prompt' => 'From Location',
                        'class' => 'js-states form-control col-md-12 ',
                        'value' => Yii::$app->request->get('location_from'),
                    ])->label();
                ?>

                <?= $form->field($rent_date, 'to_location')->dropDownList(
                    [
                        '3' => 'Yerevan'
                    ],
                    [
                        'prompt' => 'To Location',
                        'class' => 'js-states form-control col-md-12 ',
                        'value' => Yii::$app->request->get('location_to'),
                    ])->label();
                ?>

                    <div class="datepicker">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?= $form->field($rent_date, 'from', [
                                    'template' => '<label class="small-lb">From</label>
                                               <div class="input-icon">
                                                   <i class="fa fa-calendar"></i>
                                                   {input}
                                               </div>',
                                ])->textInput([ 'class' => 'form-control m-start', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'start', 'style' => 'width:100%', 'value' =>  str_replace('-', '/', Yii::$app->request->get('from')),])->label(false);?>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <?= $form->field($rent_date, 'to', [
                                    'template' => '<label class="small-lb">To</label>
                                               <div class="input-icon">
                                                   <i class="fa fa-calendar"></i>
                                                   {input}
                                               </div>',
                                ])->textInput([ 'class' => 'form-control end', 'autocomplete' => 'off', 'readonly' => 'true', 'id' => 'end', 'style' => 'width:100%',  'value' => str_replace('-', '/', Yii::$app->request->get('to'))])->label(false);?>
                            </div>

                            <!--this form-group-->
                            <div class="col-xs-12">
                                <div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 choose-time choose-time-modal">
                                        <label class="">Time From</label>
                                        <?= $form->field($rent_date, 'from_h')->dropDownList(
                                            [
                                                '00' => '00',
                                                '01' => '01',
                                                '02' => '02',
                                                '03' => '03',
                                                '04' => '04',
                                                '05' => '05',
                                                '06' => '06',
                                                '07' => '08',
                                                '09' => '09',
                                                '10' => '10',
                                                '11' => '11',
                                                '12' => '12',
                                                '13' => '13',
                                                '14' => '14',
                                                '15' => '15',
                                                '16' => '16',
                                                '17' => '17',
                                                '18' => '18',
                                                '19' => '19',
                                                '20' => '20',
                                                '21' => '21',
                                                '22' => '22',
                                                '23' => '23',
                                            ],
                                            [
                                                'class' => 'js-states form-control col-md-12',
                                                'value' => Yii::$app->request->get('from_h') ? Yii::$app->request->get('from_h') : 10 ,
                                            ])->label(false);
                                        ?>

                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 choose-time choose-time-modal">
                                        <?= $form->field($rent_date, 'from_i')->dropDownList(
                                            [
                                                '00' => ': 00',
                                                '10' => ': 10',
                                                '20' => ': 20',
                                                '30' => ': 30',
                                                '40' => ': 40',
                                                '50' => ': 50',

                                            ],
                                            [
                                                'class' => 'js-states form-control col-md-12',
                                                'value' => Yii::$app->request->get('from_i'),
                                            ])->label(false);
                                        ?>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 choose-time choose-time-modal">

                                        <label class="">Time to</label>
                                        <?= $form->field($rent_date, 'to_h')->dropDownList(
                                            [
                                                '00' => '00',
                                                '01' => '01',
                                                '02' => '02',
                                                '03' => '03',
                                                '04' => '04',
                                                '05' => '05',
                                                '06' => '06',
                                                '07' => '08',
                                                '09' => '09',
                                                '10' => '10',
                                                '11' => '11',
                                                '12' => '12',
                                                '13' => '13',
                                                '14' => '14',
                                                '15' => '15',
                                                '16' => '16',
                                                '17' => '17',
                                                '18' => '18',
                                                '19' => '19',
                                                '20' => '20',
                                                '21' => '21',
                                                '22' => '22',
                                                '23' => '23',
                                            ],
                                            [
                                                'class' => 'js-states form-control col-md-12',
                                                'value' => Yii::$app->request->get('from_h') ? Yii::$app->request->get('from_h') : 10 ,
                                            ])->label(false);
                                        ?>

                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 choose-time choose-time-modal">
                                        <?= $form->field($rent_date, 'to_i')->dropDownList(
                                            [
                                                '00' => ': 00',
                                                '10' => ': 10',
                                                '20' => ': 20',
                                                '30' => ': 30',
                                                '40' => ': 40',
                                                '50' => ': 50',

                                            ],
                                            [
                                                'class' => 'js-states form-control col-md-12',
                                                'value' => Yii::$app->request->get('to_i'),
                                            ])->label(false);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!--this form-group-->
                        </div>
                    </div>

                    <button type="submit" class="btn btn-red"><i class="fa fa-search"></i> Search</button>
                <?php ActiveForm::end(); ?>
                <br><br>
                <div style="clear: both"></div>
            </div>
        </div>
    </div>
</div>
