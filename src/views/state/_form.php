<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\login\models\State */
/* @var $form yii\widgets\ActiveForm */
$countryarray = ArrayHelper::map(TBI\Login\models\Country::find()->orderBy('countryname', 'DESC')->all(), 'id', 'countryname');
?>

<div class="state-form">
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <?php if ($model->isNewRecord): ?>
                        <h3 class="box-title">Add State</h3>
                    <?php else: ?>
                        <h3 class="box-title">Edit State</h3>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

                    <?=
                    $form->field($model, 'country_id')->dropDownList(
                            $countryarray, ['prompt' => 'Select Country']
                    )->label('Country');
                    ?>
                    <?= $form->field($model, 'statename')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add State' : 'Update State', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
