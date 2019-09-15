<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\RegisterUser */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Register Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>