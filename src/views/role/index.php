<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <?php if (Yii::$app->session->getFlash('updated')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('updated'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::$app->session->getFlash('created')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('created'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::$app->session->getFlash('deleted')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('deleted'); ?>
        </div>
    <?php } ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="col-md-6 grid_user grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Roles</h3>
                <?= Html::a('Add Role<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-default pull-right']) ?>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'header' => 'S No.',
                        'headerOptions' => ['width' => '100'],
                    ],
                    [
                        'label' => 'Role',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '150'],
                        'value' => function ($model) {
                            return $model->role;
                        },
                    ],
                    [
                         'label' => 'Updated',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '150'],
                        'value' => function ($model) {
                            return date("F j, Y, g:i a",$model->updated); 
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
