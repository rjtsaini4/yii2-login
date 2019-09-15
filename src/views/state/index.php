<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'States';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-index">

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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-md-6 grid_user grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">States</h3>
                <?= Html::a('Add State<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-default pull-right']) ?>
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
                        'label' => 'Country Name',
                        'attribute' => 'country_id',
                        'filter' => ArrayHelper::map(TBI\Login\models\Country::find()->asArray()->all(), 'id', 'countryname'),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '200'],
                        'value' => function ($model) {
                            $country =  TBI\Login\models\Country::findOne($model->country_id);
                            return $country->countryname;
                        },
                    ],
                    'statename',
                    [
                        'label' => 'Updated',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '150'],
                        'value' => function ($model) {
                            return date("F j, Y, g:i a", $model->updated);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>