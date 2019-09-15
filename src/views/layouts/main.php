<?php

use yii\helpers\Html;
use vendor\almasaeed2010\adminlte\pages;
use TBI\Login\LoginAsset;
use yii\widgets\Breadcrumbs;

$assets = LoginAsset::register($this);
/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login' || Yii::$app->controller->action->id === 'password') {
    /**
     * Do not use this code in your template. Remove it. 
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {
//    dmstr\web\AdminLteAsset::register($this);
//    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/tbi/yii2-login/src\views\layouts');
//    echo $directoryAsset;die
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <?php $this->beginBody() ?>
            <div class="wrapper">

                <?=
                $this->render(
                        'header.php'
                )
                ?>

                <?=
                $this->render(
                        'left.php'
                )
                ?>

                <div class="content-wrapper" style="min-height:850px; padding:20px;">

                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => [
                            'label' => 'Home',
                           // 'url' => ['javascript:void(0)'],
                            'template' => "<i class='fa fa-tachometer'></i>&nbsp;<li>{link}</li>\n", // template for this link only
                        ],
                    ])
                    ?>
                    <?= $content ?>
                </div>

            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
