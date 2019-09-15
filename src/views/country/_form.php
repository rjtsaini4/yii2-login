<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <?php if ($model->isNewRecord): ?>
                        <h3 class="box-title">Add Country</h3>
                    <?php else: ?>
                        <h3 class="box-title">Edit Country</h3>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

                    <?= $form->field($model, 'countryname')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add Country' : 'Update Country', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
