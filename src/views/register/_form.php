<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\login\models\City */
/* @var $form yii\widgets\ActiveForm */

$countryarray = ArrayHelper::map(TBI\Login\models\Country::find()->orderBy('countryname', 'DESC')->all(), 'id', 'countryname');
$rolearray = ArrayHelper::map(TBI\Login\models\Role::find()->orderBy('role', 'DESC')->all(), 'id', 'role');
?>
<div class="user-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-dash',
                'enableAjaxValidation' => true,
                'options' => ['enctype' => 'multipart/form-data']]);
    ?> 
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Information</h3>
                </div>
                <div class="box-body">
                    <?=
                    $form->field($model, 'email', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput()->label('Email Address');
                    ?>
                    <?=
                    $form->field($model, 'username', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                    ]);
                    ?>
                    <?=
                    $form->field($model, 'password', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-lock"></i></div>{input}</div>',
                    ])->passwordInput(['value' => ''])->label('Password');
                    ?>
                    <?=
                    $form->field($model, 'confirm_password', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-lock"></i></div>{input}</div>',
                    ])->passwordInput(['value' => ''])->label('Confirm Password');
                    ?>
                    <?= $form->field($model, 'status')->radioList(array(1 => 'Active', 0 => 'Inactive'))->label('Status'); ?>
                    <?=
                    $form->field($model, 'role')->dropDownList($rolearray, ['prompt' => 'Select Role']
                    )->label('Role')
                    ?>
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Address</h3>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'address')->textarea(['rows' => 5]); ?>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <?=
                            $form->field($model, 'country')->dropDownList(
                                    $countryarray, ['prompt' => 'Select Country']
                            )->label('Country');
                            ?>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <?php if ($model->isNewrecord): ?>
                                <?=
                                $form->field($model, 'state')->dropDownList(['' => 'Select State']
                                )->label('State');
                                ?>
                            <?php else: ?>
                                <?php $states = ArrayHelper::map(TBI\Login\models\State::find()->where(['id' => $model->state])->orderBy('statename', 'DESC')->all(), 'id', 'statename'); ?>
                                <?=
                                $form->field($model, 'state')->dropDownList($states, ['' => 'Select State']
                                )->label('State');
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <?php if ($model->isNewrecord): ?>
                                <?=
                                $form->field($model, 'city')->dropDownList(['' => 'Select City']
                                )->label('City');
                                ?>
                            <?php else: ?>
                                <?php $states = ArrayHelper::map(TBI\Login\models\city::find()->where(['id' => $model->city])->orderBy('cityname', 'DESC')->all(), 'id', 'cityname'); ?>
                                <?=
                                $form->field($model, 'city')->dropDownList($states, ['' => 'Select City']
                                )->label('City');
                                ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <?=
                            $form->field($model, 'pincode', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-address-book-o"></i></div>{input}</div>',
                            ])->label('Pincode');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Information</h3>
                </div>
                <div class="box-body">
                    <?=
                    $form->field($model, 'firstname', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                    ])->label('First Name');
                    ?>
                    <?=
                    $form->field($model, 'lastname', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                    ]);
                    ?>
                    <?= $form->field($model, 'gender')->radioList(array(1 => 'Male', 0 => 'Female'))->label('Gender'); ?>
                    <?php
                        if ($model->dob) {
                            $startdate = $model->dob;
                            $model->dob = date('m/d/Y', $startdate);
                        }
                        ?>
                    <?=
                    $form->field($model, 'dob', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                    ]);
                    ?>
                    <?php
                    if ((!empty($model->profile_pic))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    ?>
                    <label class="profile_label control-label">Profile Image</label>
                    <?php if (($model->isNewRecord) || (empty($model->profile_pic))): ?>
                        <div class="upload">
                            <?= $form->field($model, 'profile_pic')->fileInput(['accept' => 'image/*', 'id' => 'browse', 'style' => 'display:none'])->label(false); ?>
                            <p>Drag an image here.</p>
                        </div>
                        <div class="cropper_widget">
                            <div style="height: 150px; width: 150px;display:none" class="new_photo_area">

                            </div>
                            <div class="cropper_buttons preview_pane create_preview" style="display:none"> 
                                <img data-no-photo="" style="height: auto; width: auto" alt="" src="" class="thumbnail center-block">        
                            </div>
                        </div>
                        <div class="cropper_buttons crp_btn create_crop" style="display:none;">
                            <input type="hidden" id="x" name="x" />
                            <input type="hidden" id="y" name="y" />
                            <input type="hidden" id="w" name="w" />
                            <input type="hidden" id="h" name="h" />
                            <input type="hidden" id="extension" name="extension" />
                            <button aria-label="Crop photo" title="Save Image" class="btn btn-success crop_photo" type="button">
                                <span aria-hidden="true" class="glyphicon glyphicon-saved"></span>             </button>
                            <button aria-label="Delete photo" title="Delete image" class="btn btn-danger delete_photo" type="button">
                                <span aria-hidden="true" class="glyphicon glyphicon-trash"></span>             </button>
                        </div>
                    <?php else: ?>
                        <div class="upload" style="display:none">
                            <?= $form->field($model, 'profile_pic')->fileInput(['accept' => 'image/*', 'id' => 'browse', 'style' => 'display:none'])->label(false); ?>
                            <p>Drag an image here.</p>
                        </div>
                        <div class="cropper_widget">
                            <div style="height: 150px; width: 150px;display:none" class="new_photo_area">

                            </div>
                            <div class="cropper_buttons preview_pane">
                                <img data-no-photo="" style="height: auto; width: auto" alt="" src="../../profile_pic/<?php echo $model->profile_pic ?>" class="thumbnail center-block">        
                            </div>
                        </div>
                        <div class="update_buttons">
                            <button aria-label="Delete photo" title="Delete image" class="btn btn-danger delete_photo1" type="button">
                                <span aria-hidden="true" class="glyphicon glyphicon-trash"></span>             
                            </button>
                        </div>
                        <div class="cropper_buttons crp_btn" style="display:none;">
                            <input type="hidden" id="x" name="x" />
                            <input type="hidden" id="y" name="y" />
                            <input type="hidden" id="w" name="w" />
                            <input type="hidden" id="h" name="h" />
                            <input type="hidden" id="extension" name="extension" />
                            <button aria-label="Crop photo" title="Save Image" class="btn btn-success crop_photo" type="button">
                                <span aria-hidden="true" class="glyphicon glyphicon-saved"></span>             </button>
                            <button aria-label="Delete photo" title="Delete image" class="btn btn-danger delete_photo" type="button">
                                <span aria-hidden="true" class="glyphicon glyphicon-trash"></span>             </button>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" id="profile_pic" name="profile_pic" value="<?= $model->profile_pic; ?>"/> 
                    <!--                    <div class="form-group">
                                            <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                                            <input id='imgupdate' type='hidden' name="imgupdate" value='0'>
                                            <img id="removeimage"style="margin-right:20px;width:100px;"src="../../profile_pic/<?php echo $model->profile_pic ?>"><button id="remove">Remove</button>
                                        </div>-->
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <span class="cancel_btn">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        </span>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<style>
    .upload{
        width: 150px;
        height: 150px;
        border: 2px dashed #eeeeee;
        margin-top:50px;
    }
    .upload p{
        width: 100%;
        height: 100%;
        text-align: center;
        line-height: 100px;
        font-family: Arial;
    }
    .upload input{
        position: absolute;
        margin: 0;
        padding: 0;
        width: 150px;
        height: 150px;
        outline: none;
        opacity: 0;
    }
    .new_photo_area {
        display: inline-block;
        float: left;
        margin: 0 20px !important;
        border: 2px dashed #eeeeee;
        box-sizing: content-box;
        margin: 20px 0;
        text-align: center;
        vertical-align: middle;
    }
    .profile_label {
        float: left;
        width: 100%;
    }
    .cropper_buttons.crp_btn,.update_buttons {
        float: left;
        margin-left: 16px !important;
        margin-top: 15px !important;
        width: 100%;
    }
    .cropper_buttons.preview_pane {
        float: left;
        width: 22% !important;
    }
    .thumbnail {
        height: 150px !important;
        width: 150px !important;
    }
</style>
