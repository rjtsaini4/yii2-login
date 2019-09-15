<?php

namespace TBI\Login\controllers;
use yii\web\Controller;
use TBI\Login\models\RegisterUser;

/**
 * Default controller for the `api` module
 */
class ModuleController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCreateTable(){
        return 'table created';
    }
}
