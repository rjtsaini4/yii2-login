<?php

namespace TBI\Login\controllers;

use Yii;
use TBI\Login\models\RegisterUser;
use TBI\Login\models\City;
use TBI\Login\models\State;
use TBI\Login\models\RegisterUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * UserController implements the CRUD actions for RegisterUser model.
 */
class RegisterController extends Controller {

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
     * Lists all RegisterUser models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'main';
        $searchModel = new RegisterUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegisterUser model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $this->layout = 'main';
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RegisterUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'main';
        $model = new RegisterUser();
        $model->scenario = 'user_signup';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        if (Yii::$app->request->post()) {
            $model->load(\Yii::$app->request->post());
            $model->email = trim($model->email, ' ');
            $model->dob = strtotime($model->dob);
            if (!empty($_POST['profile_pic'])):
                $model->profile_pic = $_POST['profile_pic'];
            elseif (!empty($_POST['extension'])):
                $cnvimg1 = $_POST['extension'];
                if (strpos($cnvimg1, 'image/png') !== false) {
                    $cnvimg1 = str_replace('data:image/png;base64,', '', $cnvimg1);
                    $cnvimg1 = str_replace(' ', '+', $cnvimg1);
                    $data1 = base64_decode($cnvimg1);
                    $file1 = time() . '.png';
                }
                if (strpos($cnvimg1, 'image/jpeg') !== false) {
                    $cnvimg1 = str_replace('data:image/jpeg;base64,', '', $cnvimg1);
                    $cnvimg1 = str_replace(' ', '+', $cnvimg1);
                    $data1 = base64_decode($cnvimg1);
                    $file1 = time() . '.jpeg';
                }
                $location1 = getcwd() . '/profile_pic';
                $success = file_put_contents($location1 . '/' . $file1, $data1);
                $model->profile_pic = $file1;
            endif;
//            if ($profile_pic) {
//                $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
//                $model->profile_pic = time() . '_' . $profile_pic->name;
//                $profile_pic->saveAs('profile_pic/' . $model->profile_pic);
//            } else {
//                $model->profile_pic = '';
//            }
            $model->setPassword($model->password);
            $model->created = time();
            $model->updated = time();
            // echo '<pre>';print_r($model);die;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('created', 'User ' . ucfirst($model->firstname) . ' ' . ucfirst($model->lastname) . ' has been Created Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RegisterUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = 'main';
        $model = $this->findModel($id);
        $model->scenario = 'user_update';
        $oldprofilepic = $model->profile_pic;
        $user_pswd = $model->password;
        $model->password = '';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        if ($model->load(Yii::$app->request->post())) {
            $model->email = trim($model->email, ' ');
            $model->dob = strtotime($model->dob);
            $postedData = Yii::$app->request->post();
            if (!empty($_POST['profile_pic'])):
                $model->profile_pic = $_POST['profile_pic'];
            elseif (!empty($_POST['extension'])):
                $cnvimg1 = $_POST['extension'];
                if (strpos($cnvimg1, 'image/png') !== false) {
                    $cnvimg1 = str_replace('data:image/png;base64,', '', $cnvimg1);
                    $cnvimg1 = str_replace(' ', '+', $cnvimg1);
                    $data1 = base64_decode($cnvimg1);
                    $file1 = time() . '.png';
                }
                if (strpos($cnvimg1, 'image/jpeg') !== false) {
                    $cnvimg1 = str_replace('data:image/jpeg;base64,', '', $cnvimg1);
                    $cnvimg1 = str_replace(' ', '+', $cnvimg1);
                    $data1 = base64_decode($cnvimg1);
                    $file1 = time() . '.jpeg';
                }
                $location1 = getcwd() . '/profile_pic';
                $success = file_put_contents($location1 . '/' . $file1, $data1);
                $model->profile_pic = $file1;
            endif;
//            $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
//            if ($profile_pic) {
//                $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
//
//                $model->profile_pic = time() . '_' . $profile_pic->name;
//                $profile_pic->saveAs('profile_pic/' . $model->profile_pic);
//            } else {
//                if ($_POST['imgupdate'] == 1) {
//                    if (!empty($model->profile_pic)) {
//                        unlink('profile_pic/' . $model->profile_pic);
//                    }
//                    $model->profile_pic = '';
//                } else {
//                    $model->profile_pic = $oldprofilepic;
//                }
//            }
            if ($postedData['RegisterUser']['password'] == ''): //Password not updated Case
                $model->password = $user_pswd;
            else: //Password updated Case
                $model->setPassword($postedData['RegisterUser']['password']);
            endif;
            $model->updated = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('created', 'User ' . ucfirst($model->firstname) . ' ' . ucfirst($model->lastname) . ' has been updated Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RegisterUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->layout = 'main';
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RegisterUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RegisterUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $this->layout = 'main';
        if (($model = RegisterUser::findOne($id)) !== null) {
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

    public function actionGetcities($id) {
        $html = '';
        $states = City::find()->where(['state_id' => $id])->all();
        $html .= '<option value="">Select City</option>';
        if (!empty($states)):
            foreach ($states as $state) {
                $html .= '<option value="' . $state->id . '">' . $state->cityname . '</option>';
            }
        endif;
        return $html;
    }

    public function actionSaveImage() {
        $cnvimg1 = $_POST['src'];
        if (strpos($cnvimg1, 'image/png') !== false) {
            $cnvimg1 = str_replace('data:image/png;base64,', '', $cnvimg1);
            $cnvimg1 = str_replace(' ', '+', $cnvimg1);
            $data1 = base64_decode($cnvimg1);
            $file1 = time() . '.png';
        }
        if (strpos($cnvimg1, 'image/jpeg') !== false) {
            $cnvimg1 = str_replace('data:image/jpeg;base64,', '', $cnvimg1);
            $cnvimg1 = str_replace(' ', '+', $cnvimg1);
            $data1 = base64_decode($cnvimg1);
            $file1 = time() . '.jpeg';
        }
        $location1 = getcwd() . '/profile_pic';
        $success = file_put_contents($location1 . '/' . $file1, $data1);
        $targ_w = $targ_h = 150;
        $jpeg_quality = 90;
        $extension = strtolower(substr($file1, strpos($file1, '.') + 1));
        if ($extension == 'jpg' || $extension == 'jpeg') {
            $img_r = imagecreatefromjpeg('profile_pic/' . $file1);

            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

            header('Content-type: image/jpeg');
            imagejpeg($dst_r, 'profile_pic/' . time() . '.' . $extension);
            $filename = time() . '.' . $extension;
            return $filename;
            exit;
        } elseif ($extension == 'png') {
            $img_r = imagecreatefrompng('profile_pic/' . $file1);
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

            header('Content-type: image/png');
            imagejpeg($dst_r, 'profile_pic/' . time() . '.' . $extension);
            $filename = time() . '.' . $extension;
            return $filename;
            exit;
        }
    }

}
