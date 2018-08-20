<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 3/2/2017
 * Time: 5:34 PM
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="form-container">

    <!--this glypgicon-->
    <i class="glyphicon glyphicon-time glyphicon-choose-time"></i>
    <i class="glyphicon glyphicon-time glyphicon-choose-time glyphicon-choose-time2"></i>
    <!--this glypgicon-->
    <div class="row">
        <div class="input-daterange search-date">
            <!--this class 'custom '-->
            <div class="form-group custom-form">
                <!--this class 'custom '-->
                <?php $form = ActiveForm::begin([
                    'validateOnBlur'=>false,
                    'action' => '/catalog/search', 'method' => 'post',
                    'options' => [
                        'class' => 'form-inline row hidden-xs hidden-sm'
                    ]]); ?>

                    <input type="hidden" name="_csrf-frontend"
                           value="tbFWoU0ydn7ngQwROG3kP09TzkTMBB3n2lv6lmp8Yp3N1wXsCVsGGaTjb0VXHqlwLWOAC_RrJdOqIqnzPj9P_A==">
                    <div class="form-group  col-md-12 col-sm-12">
                        <?= $form->field($rent_date, 'categories')->dropDownList(
                            ArrayHelper::map($categories, 'alias', 'title'),
                            [
                                'prompt' => 'Categories',
                                'class' => 'js-states form-control col-md-12',
                            ])->label(false);
                        ?>
                        <?= $form->field($rent_date, 'from_location')->dropDownList(
                            [
                                '3' => 'Yerevan'
                            ],
                            [
                                'prompt' => 'From Location',
                                'class' => 'js-states form-control col-md-12',
                            ])->label(false);
                        ?>
                        <?= $form->field($rent_date, 'to_location')->dropDownList(
                            [
                                '3' => 'Yerevan'
                            ],
                            [
                                'prompt' => 'To Location',
                                'class' => 'js-states form-control col-md-12',
                            ])->label(false);
                        ?>
                    </div>
                    <!--this class 'padding_right'-->
                    <div class="form-group  col-md-6 col-sm-6 padding_right">
                        <!--this class 'padding_right'-->
                        <?= $form->field($rent_date, 'from', [
                            'template' => '
                           <div class="input-icon">
                               <i class="fa fa-calendar"></i>
                               {input}
                           </div>',
                        ])->textInput([ 'class' => 'form-control', 'id' => 'start', 'placeholder' => 'Date From', 'autocomplete' => 'off', 'readonly' => 'true'])->label(false);?>
                    </div>
                    <!--this class 'padding_left'-->
                    <div class="form-group  col-md-6 col-sm-6 padding_left">
                        <!--this class 'padding_left'-->
                        <?= $form->field($rent_date, 'to', [
                            'template' => '              
                            <div class="input-icon">
                               <i class="fa fa-calendar"></i>
                               {input}
                           </div>',
                        ])->textInput([ 'class' => 'form-control end', 'id' => 'end', 'placeholder' => 'Date To', 'autocomplete' => 'off', 'readonly' => 'true'])->label(false);?>
                    </div>

                    <!--this form-group-->
                    <div class="col-xs-12">
                        <div class="datepicker">
                            <div class="form-group  col-md-3 col-sm-3 choose-time">
                                <div class="form-group time-box field-rentdate-from_location">

                                    <select id="rentdate-from_h"
                                            class="js-states form-control col-md-12"
                                            name="RentDate[from_h]">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10" selected>10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3 col-sm-3 choose-time">
                                <div class="form-group time-box2 field-rentdate-to_location">

                                    <select id="rentdate-from-i"
                                            class="js-states form-control col-md-12"
                                            name="RentDate[from_i]">
                                        <option value="00"> : 00</option>
                                        <option value="10"> : 10</option>
                                        <option value="20"> : 20</option>
                                        <option value="30"> : 30</option>
                                        <option value="40"> : 40</option>
                                        <option value="50"> : 50</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group  col-md-3 col-sm-3 choose-time">
                                <div class="form-group time-box field-rentdate-from_location">
                                    <select id="rentdate-to_h"
                                            class="time-box js-states form-control col-md-12"
                                            name="RentDate[to_h]">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10" selected>10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3 col-sm-3 choose-time">
                                <div class="form-group  time-box2 field-rentdate-to_location">

                                    <select id="rentdate-to_i"
                                            class="js-states form-control col-md-12"
                                            name="RentDate[to_i]">
                                        <option value="00"> : 00</option>
                                        <option value="10"> : 10</option>
                                        <option value="20"> : 20</option>
                                        <option value="30"> : 30</option>
                                        <option value="40"> : 40</option>
                                        <option value="50"> : 50</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--this form-group-->

                    <div class="row search">
                        <div class="form-group col-lg- col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-blue"><i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </div>


                <?php ActiveForm::end(); ?>
            </div>
            <div class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-9"></div>
        </div>
        <a class="container_2jlos-o_O-mediumAndAbove_dzkbme hidden-md hidden-lg" data-toggle="modal"
           data-target="#searchModal">
            <div>
                <div class="container_157txhx">
                    <div class="inputContainer_2ci0p">
                            <span class="fakeInput_wlvusc">
                                <span data-reactid="109">Search</span>
                            </span>
                    </div>
                    <button class="button_1hueyqh">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </a>
    </div>
</div>

