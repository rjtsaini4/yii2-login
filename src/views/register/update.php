<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RegisterUser */

$this->title = 'Update Register User';
$this->params['breadcrumbs'][] = ['label' => 'Register Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="register-user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
