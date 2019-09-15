<?php

namespace TBI\Login\controllers;

use Yii;
use TBI\Login\models\Country;
use TBI\Login\models\CountrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'main';
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Country model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->layout = 'main';
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'main';
        $model = new Country();
        $model->scenario = 'create';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        if ($model->load(Yii::$app->request->post())) {
            $model->created = time();
            $model->updated = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('created', 'Country has been added Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = 'main';
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        if ($model->load(Yii::$app->request->post())) {
            $model->updated = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('updated', 'Country has been Updated Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Country model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->layout = 'main';
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
