<?php

namespace TBI\Login\controllers;

use Yii;
use TBI\Login\models\City;
use TBI\Login\models\State;
use TBI\Login\models\CitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller {

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
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'main';
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single City model.
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
     * Creates a new City model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'main';
        $model = new City();

        if ($model->load(Yii::$app->request->post())) {
            $model->created = time();
            $model->updated = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('created', 'City has been added Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = 'main';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('updated', 'City has been Updated Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing City model.
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
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetstates($id) {
        $html = '';
        $states = State::find()->where(['country_id' => $id])->all();
        $html .= '<option value="">Select State</option>';
        if (!empty($states)):
            foreach ($states as $state) {
                $html .= '<option value="' . $state->id . '">' . $state->statename . '</option>';
            }
        endif;
        return $html;
    }

}
