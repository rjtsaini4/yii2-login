<?php

namespace TBI\Login\controllers;

use Yii;
use TBI\Login\models\State;
use TBI\Login\models\StateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * StateController implements the CRUD actions for State model.
 */
class StateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all State models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new StateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single State model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'main';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new State model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new State();
        $model->scenario = 'create';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        if ($model->load(Yii::$app->request->post())) {
            $model->created = time();
            $model->updated = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('created', 'State has been added Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing State model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
                Yii::$app->session->setFlash('updated', 'State has been Updated Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing State model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->layout = 'main';
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the State model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return State the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = State::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
