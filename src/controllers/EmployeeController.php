<?php

namespace TBI\Login\controllers;

use TBI\Login\models\Employee;
use TBI\Login\models\RegisterUser;

class EmployeeController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        echo 'this is test';
        die;
        return $this->render('index');
    }

    public function actionCreate() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = new RegisterUser();
        $employee->scenario = 'user_signup';
        $employee->attributes = \Yii::$app->request->post();
        //  echo '<pre>';print_r($employee->token);die;
        $employee1 = Employee::find()->where(['name' => $employee->email])->one();
        if (!empty($employee1)):
            return array('status' => true, 'data' => 'data exists already.');
        endif;
        if ($employee->validate()) {
            $employee->setPassword($employee->password);
            $employee->created = time();
            $employee->updated = time();
            $employee->save(false);
            return array('status' => true, 'data' => 'data saved successfully');
        } else {
            return array('status' => false, 'error' => $employee->getErrors());
        }
    }

    public function actionList() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->all();
        $count = RegisterUser::find()->count();
        if ($count > 0) {
            return array('status' => true, 'data' => $employee);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    public function actionUpdate($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->where(['id' => $id])->one();
        $user_pswd = $employee->password;
        //echo '<pre>';print_r($employee);die;
        $employee->scenario = 'user_update';
        $employee->attributes = \Yii::$app->request->post();
        // echo '<pre>';print_r(\Yii::$app->request->post());die;
        if ($employee->validate()) {
            if ($employee->password == ''): //Password not updated Case
                $employee->password = $user_pswd;
            else: //Password updated Case
                $employee->setPassword($employee->password);
            endif;
            $employee->updated = time();
            $employee->save();
            return array('status' => true, 'data' => 'data updated successfully');
        } else {
            return array('status' => false, 'error' => $employee->getErrors());
        }
    }

    public function actionDelete($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->where(['id' => $id])->one();
        if ($employee->validate()) {
            $employee->delete();
            return array('status' => true, 'data' => 'data deleted successfully');
        } else {
            return array('status' => false, 'error' => $employee->getErrors());
        }
    }

}
