<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 3/2/2017
 * Time: 5:34 PM
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>

<div class="row fix-search toTheTop fix-search-catalog">
    <h4 class="filter_title">Additional search</h4>
    <!--this classes 'fix-search, fix-search-catalog'-->
    <div class="input-daterange search-date left-search-date">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php $form = ActiveForm::begin([
                'validateOnBlur'=>false,
                'action' => '/catalog/search', 'method' => 'post',
                'options' => [
                    'class' => 'form-inline row'
                ]]); ?>

                <!--this ;padding_left-right' className-->
                <div class="form-group  padding_left_right">
                    <!--this ;padding_left-right' className-->
                    <?= $form->field($rent_date, 'categories')->dropDownList(
                        ArrayHelper::map($categories, 'alias', 'title'),
                        [
                            'prompt' => 'Categories',
                            'class' => 'js-states form-control col-md-12 ',
                            'value' => Yii::$app->request->get('category'),
                        ])->label(false);
                    ?>

                    <?= $form->field($rent_date, 'from_location')->dropDownList(
                        [
                            '3' => 'Yerevan'
                        ],
                        [
                            'prompt' => 'From Location',
                            'class' => 'js-states form-control col-md-12 ',
                            'value' => Yii::$app->request->get('location_from'),
                        ])->label(false);
                    ?>

                    <?= $form->field($rent_date, 'to_location')->dropDownList(
                        [
                            '3' => 'Yerevan'
                        ],
                        [
                            'prompt' => 'To Location',
                            'class' => 'js-states form-control col-md-12 ',
                            'value' => Yii::$app->request->get('location_to'),
                        ])->label(false);
                    ?>


                    <?= $form->field($rent_date, 'from', [
                        'template' => '             <div class="input-icon">
                                                           <i class="fa fa-calendar"></i>
                                                           {input}
                                                       </div>',
                    ])->textInput([
                        'class' => 'form-control',
                        'id' => 'start',
                        'placeholder' => 'From',
	                    'readonly' => 'true',
                        'autocomplete' => 'off',
                        'value' => str_replace('-', '/', Yii::$app->request->get('from')),
                    ])->label(false);?>

                    <?= $form->field($rent_date, 'to', [
                        'template' => '
                            <div class="input-icon">
                                <i class="fa fa-calendar"></i>
                                {input}
                            </div>',
                    ])->textInput([
                        'class' => 'form-control end',
                        'id' => 'end',
                        'placeholder' => 'To',
	                    'readonly' => 'true',
	                    'autocomplete' => 'off',
                        'value' => str_replace('-', '/', Yii::$app->request->get('to')),
                    ])->label(false);?>

                    <!--this form-group-->
                    <div class="catalog-choose-time-container">
                        <div>
                            <div class="form-group  col-md-3 col-sm-3 choose-time time-box">
                                <?= $form->field($rent_date, 'from_h')->dropDownList(
                                    [
                                        '00' => '00',
                                        '01' => '01',
                                        '02' => '02',
                                        '03' => '03',
                                        '04' => '04',
                                        '05' => '05',
                                        '06' => '06',
                                        '07' => '07',
                                        '08' => '08',
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
                                        'value' => Yii::$app->request->get('from_h'),
                                    ])->label(false);
                                ?>

                            </div>
                            <div class="form-group  col-md-3 col-sm-3 choose-time  time-box2">
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
                        </div>
                    </div>

                    <!--this form-group-->
                    <div class="catalog-choose-time-container">
                        <div>
                            <div class="form-group  col-md-3 col-sm-3 choose-time time-box">
                                <?= $form->field($rent_date, 'to_h')->dropDownList(
                                    [
                                        '00' => '00',
                                        '01' => '01',
                                        '02' => '02',
                                        '03' => '03',
                                        '04' => '04',
                                        '05' => '05',
                                        '06' => '06',
                                        '07' => '07',
                                        '08' => '08',
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
                                        'value' => Yii::$app->request->get('to_h'),
                                    ])->label(false);
                                ?>

                            </div>
                            <div class="form-group  col-md-3 col-sm-3 choose-time  time-box2">
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

                    <hr>
                    <?= $form->field($rent_date, 'price')->dropDownList(
                        [
                            'low' => 'Low to High',
                            'high' => 'High to Low',
                        ],
                        [
                            'prompt' => 'Price',
                            'class' => 'js-states form-control col-md-12',
                            'value' => Yii::$app->request->get('price'),
                        ])->label(false);
                    ?>

                    <?= $form->field($rent_date, 'user')->dropDownList(
                        $users,
                        [
                            'prompt' => 'Users',
                            'class' => 'js-states form-control col-md-12',
                            'value' => Yii::$app->request->get('user'),
                        ])->label(false);
                    ?>

                    <?= $form->field($rent_date, 'class')->dropDownList(
                        $class,
                        [
                            'prompt' => 'Class',
                            'class' => 'js-states form-control col-md-12',
                            'value' => Yii::$app->request->get('class'),
                        ])->label(false);
                    ?>
                    <?= $form->field($rent_date, 'marka')->dropDownList(
                        $marka,
                        [
                            'prompt' => 'Marka',
                            'id' => 'item-mark_id',
                            'class' => 'js-states form-control col-md-12',
                            'value' => Yii::$app->request->get('marka'),
                        ])->label(false);
                    ?>
                    <?= $form->field($rent_date, 'model')->dropDownList(
                        $model,
                        [
                            'prompt' => 'Model',
                            'id' => 'item-model_id',
                            'class' => 'js-states form-control col-md-12',
                            'value' => Yii::$app->request->get('model'),
                        ])->label(false);
                    ?>
                </div>

                <div class="search">
                    <div class="form-group text-center col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button style="width: 100%" type="submit" class="btn btn btn-blue"><i
                                    class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-9"></div>
</div>