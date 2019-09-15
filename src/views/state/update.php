<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\login\models\State */

$this->title = 'Edit State';
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="state-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
