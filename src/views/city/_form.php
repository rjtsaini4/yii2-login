<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\login\models\City */
/* @var $form yii\widgets\ActiveForm */

$countryarray = ArrayHelper::map(TBI\Login\models\Country::find()->orderBy('countryname', 'DESC')->all(), 'id', 'countryname');
?>

<div class="city-form">
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php if ($model->isNewRecord): ?>
                        <h3 class="box-title">Add City</h3>
                    <?php else: ?>
                        <h3 class="box-title">Edit City</h3>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?=
                    $form->field($model, 'country_id')->dropDownList(
                            $countryarray, ['prompt' => 'Select Country']
                    )->label('Country');
                    ?>
                    <?php if ($model->isNewrecord): ?>
                        <?=
                        $form->field($model, 'state_id')->dropDownList(['' => 'Select State']
                        )->label('State');
                        ?>
                    <?php else: ?>
                        <?php $states = ArrayHelper::map(TBI\Login\models\State::find()->where(['id' => $model->state_id])->orderBy('statename', 'DESC')->all(), 'id', 'statename'); ?>
                        <?=
                        $form->field($model, 'state_id')->dropDownList($states, ['' => 'Select State']
                        )->label('State');
                        ?>
                    <?php endif; ?>
                    <?= $form->field($model, 'cityname')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add City' : 'Update City', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
