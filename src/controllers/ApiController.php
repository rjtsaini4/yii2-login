<?php

namespace TBI\Login\controllers;

use TBI\Login\models\Employee;
use TBI\Login\models\RegisterUser;
use TBI\Login\models\Country;
use TBI\Login\models\City;
use TBI\Login\models\State;
use TBI\Login\models\Role;
use common\models\LoginForm;
use common\models\User;

class ApiController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        echo 'this is test';
    }

    /*
     * Api Add Full User Info
     */

    public function actionCreate() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = new RegisterUser();
        $employee->scenario = 'user_signup';
        $employee->attributes = \Yii::$app->request->post();
        if (!empty($_POST['countryname'])):
            $country = Country::find()->where(['countryname' => $_POST['countryname']])->one();
            if (!empty($country)):
                $employee->country = $country->id;
                if (!empty($_POST['statename'])):
                    $state = State::find()->where(['statename' => $_POST['statename'], 'country_id' => $country->id])->one();
                    if (!empty($state)):
                        $employee->state = $state->id;
                        if (!empty($_POST['cityname'])):
                            $city = City::find()->where(['cityname' => $_POST['cityname'], 'country_id' => $country->id, 'state_id' => $employee->state])->one();
                            if (!empty($city)):
                                $employee->city = $city->id;
                            else:
                                return array('status' => false, 'error' => 'No such City exists');
                            endif;
                        endif;
                    else:
                        return array('status' => false, 'error' => 'No such State exists');
                    endif;
                endif;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        $employee1 = RegisterUser::find()->where(['email' => $employee->email])->one();
        if (!empty($employee1)):
            return array('status' => true, 'data' => 'data exists already.');
        endif;
        if ($employee->validate()) {
            $role = Role::findOne($employee->role);
            if (empty($role)):
                return array('status' => false, 'error' => 'now such role exists');
            endif;
            $employee->setPassword($employee->password);
            $employee->status = 1;
            $employee->created = time();
            $employee->updated = time();
            $employee->save(false);
            return array('status' => true, 'data' => 'data saved successfully');
        } else {
            return array('status' => false, 'error' => $employee->getErrors());
        }
    }

    /*
     * Api User Listing
     */

    public function actionList() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->all();
        $count = RegisterUser::find()->count();
        if ($count > 0) {
            foreach ($employee as $user):
                if (!empty($user->country)):
                    $country = Country::findOne($user->country);
                    $countryname = $country->countryname;
                else:
                    $countryname = 'NA';
                endif;
                if (!empty($user->state)):
                    $state = State::findOne($user->state);
                    $statename = $state->statename;
                else:
                    $statename = 'NA';
                endif;
                if (!empty($user->city)):
                    $city = City::findOne($user->city);
                    $cityname = $city->cityname;
                else:
                    $cityname = 'NA';
                endif;
                if (!empty($user->role)):
                    $role = Role::findOne($user->role);
                    $rolename = $role->role;
                else:
                    $rolename = 'NA';
                endif;
                if (!empty($user->status)):
                    if ($user->status == 0):
                        $status = "Inactive";
                    else:
                        $status = "Active";
                    endif;
                else:
                    $status = 'NA';
                endif;
                if (!empty($user->dob)):
                    $dob = date('m/d/Y', $user->dob);
                else:
                    $dob = 'NA';
                endif;
                $dataxls[] = array('id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username, 'email' => $user->email,'DOB' => $dob, 'countryname' => $countryname, 'statename' => $statename, 'cityname' => $cityname, 'role' => $rolename, 'status' => $status);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Api Update Complete User data update by Id
     */

    public function actionUpdate($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->where(['id' => $id])->one();
        $user_pswd = $employee->password;
        $employee->password = '';
        //echo '<pre>';print_r($employee);die;
        $employee->scenario = 'user_update';
        $employee->attributes = \Yii::$app->request->post();
        if (!empty($_POST['countryname'])):
            $country = Country::find()->where(['countryname' => $_POST['countryname']])->one();
            if (!empty($country)):
                $employee->country = $country->id;
                if (!empty($_POST['statename'])):
                    $state = State::find()->where(['statename' => $_POST['statename'], 'country_id' => $country->id])->one();
                    if (!empty($state)):
                        $employee->state = $state->id;
                        if (!empty($_POST['cityname'])):
                            $city = City::find()->where(['cityname' => $_POST['cityname'], 'country_id' => $country->id, 'state_id' => $employee->state])->one();
                            if (!empty($city)):
                                $employee->city = $city->id;
                            else:
                                return array('status' => false, 'error' => 'No such City exists');
                            endif;
                        endif;
                    else:
                        return array('status' => false, 'error' => 'No such State exists');
                    endif;
                endif;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        if (!empty($_POST['statename'])):
            $state = State::find()->where(['statename' => $_POST['statename'], 'country_id' => $employee->country])->one();
            if (!empty($state)):
                $employee->state = $state->id;
            else:
                return array('status' => false, 'error' => 'No such State exists in this country.');
            endif;
        endif;
        if (!empty($_POST['cityname'])):
            $city = City::find()->where(['cityname' => $_POST['cityname'], 'country_id' => $employee->country, 'state_id' => $employee->state])->one();
            if (!empty($city)):
                $employee->city = $city->id;
            else:
                return array('status' => false, 'error' => 'No such City exists.');
            endif;
        endif;
        if ($employee->validate()) {
            $role = Role::findOne($employee->role);
            if (empty($role)):
                return array('status' => false, 'error' => 'now such role exists');
            endif;
            if ($employee->password == ''): //Password not updated Case
                $employee->password = $user_pswd;
            else: //Password updated Case
                $employee->setPassword($employee->password);
            endif;
            $employee->status = 1;
            $employee->updated = time();
            $employee->save(false);
            return array('status' => true, 'data' => 'data updated successfully');
        } else {
            return array('status' => false, 'error' => $employee->getErrors());
        }
    }

    /*
     * Api Delete User
     */

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

    /*
     * Api add country
     */

    public function actionAddCountry() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $country = new Country();
        $country->scenario = 'create';
        $country->attributes = \Yii::$app->request->post();
        if ($country->validate()) {
            $country->created = time();
            $country->updated = time();
            $country->save(false);
            return array('status' => true, 'data' => 'Country added successfully');
        } else {
            return array('status' => false, 'error' => $country->getErrors());
        }
    }

    /*
     * Api Country update by id
     */

    public function actionUpdateCountry($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $country = Country::findOne($id);
        $country->scenario = 'update';
        $country->attributes = \Yii::$app->request->post();
        if ($country->validate()) {
            $country->updated = time();
            $country->save(false);
            return array('status' => true, 'data' => 'Country Updated successfully');
        } else {
            return array('status' => false, 'error' => $country->getErrors());
        }
    }

    /*
     * Api Country Listing
     */

    public function actionCountryList() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $country = Country::find()->all();
        $count = Country::find()->count();
        if ($count > 0) {
            return array('status' => true, 'data' => $country);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Api delete Country by id
     */

    public function actionDeleteCountry($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $country = Country::find()->where(['id' => $id])->one();
        if (!empty($country)) {
            $country->delete();
            return array('status' => true, 'data' => 'Country deleted successfully');
        } else {
            return array('status' => false, 'error' => 'No such Country exists');
        }
    }

    /*
     * Api Add role
     */

    public function actionAddRole() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $role = new Role();
        $role->scenario = 'create';
        $role->attributes = \Yii::$app->request->post();
        if ($role->validate()) {
            $role->created = time();
            $role->updated = time();
            $role->save(false);
            return array('status' => true, 'data' => 'Role added successfully');
        } else {
            return array('status' => false, 'error' => $role->getErrors());
        }
    }

    /*
     * Api Update Role by id
     */

    public function actionUpdateRole($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $role = Role::findOne($id);
        $role->scenario = 'update';
        $role->attributes = \Yii::$app->request->post();
        if ($role->validate()) {
            $role->updated = time();
            $role->save(false);
            return array('status' => true, 'data' => 'Role Updated successfully');
        } else {
            return array('status' => false, 'error' => $role->getErrors());
        }
    }

    /*
     * Api Role listing
     */

    public function actionRoleList() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $role = Role::find()->all();
        $count = Role::find()->count();
        if ($count > 0) {
            return array('status' => true, 'data' => $role);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Api delete Role by id
     */

    public function actionDeleteRole($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $role = Role::find()->where(['id' => $id])->one();
        if (!empty($role)) {
            $role->delete();
            return array('status' => true, 'data' => 'Role deleted successfully');
        } else {
            return array('status' => false, 'error' => 'No such Role exists');
        }
    }

    /*
     * Api add state
     */

    public function actionAddState() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $state = new State();
        $state->scenario = 'apicreate';
        $state->attributes = \Yii::$app->request->post();
        if (!empty($state->countryname)):
            $country = Country::find()->where(['countryname' => $state->countryname])->one();
            if (!empty($country)):
                $state->country_id = $country->id;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        if ($state->validate()) {
            $state->created = time();
            $state->updated = time();
            $state->save(false);
            return array('status' => true, 'data' => 'State added successfully');
        } else {
            return array('status' => false, 'error' => $state->getErrors());
        }
    }

    /*
     * Api update State by id
     */

    public function actionUpdateState($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $state = State::findOne($id);
        $state->scenario = 'apiupdate';
        $state->attributes = \Yii::$app->request->post();
        if (!empty($state->countryname)):
            $country = Country::find()->where(['countryname' => $state->countryname])->one();
            if (!empty($country)):
                $state->country_id = $country->id;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        if ($state->validate()) {
            $state->updated = time();
            $state->save(false);
            return array('status' => true, 'data' => 'State Updated successfully');
        } else {
            return array('status' => false, 'error' => $state->getErrors());
        }
    }

    /*
     * Api State List
     */

    public function actionStateList() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $states = State::find()->all();
        $count = State::find()->count();
        if ($count > 0) {
            $role = [];
            foreach ($states as $state):
                $country = Country::findOne($state->country_id);
                $dataxls[] = array('id' => $state->id, 'countryname' => $country->countryname, 'statename' => $state->statename);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Api delete State by id
     */

    public function actionDeleteState($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $role = State::find()->where(['id' => $id])->one();
        if (!empty($role)) {
            $role->delete();
            return array('status' => true, 'data' => 'State deleted successfully');
        } else {
            return array('status' => false, 'error' => 'No such State exists');
        }
    }

    /*
     * Api Add City
     */

    public function actionAddCity() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $city = new City();
        $city->attributes = \Yii::$app->request->post();
        if (!empty($_POST['countryname'])):
            $country = Country::find()->where(['countryname' => $_POST['countryname']])->one();
            if (!empty($country)):
                $city->country_id = $country->id;
                if (!empty($_POST['statename'])):
                    $state = State::find()->where(['statename' => $_POST['statename'], 'country_id' => $country->id])->one();
                    if (!empty($state)):
                        $city->state_id = $state->id;
                    else:
                        return array('status' => false, 'error' => 'No such State exists');
                    endif;
                endif;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        if ($city->validate()) {
            $city->created = time();
            $city->updated = time();
            $city->save(false);
            return array('status' => true, 'data' => 'City added successfully');
        } else {
            return array('status' => false, 'error' => $city->getErrors());
        }
    }

    /*
     * Api Update City
     */

    public function actionUpdateCity($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $city = City::findOne($id);
        $city->attributes = \Yii::$app->request->post();
        if (!empty($_POST['countryname'])):
            $country = Country::find()->where(['countryname' => $_POST['countryname']])->one();
            if (!empty($country)):
                $city->country_id = $country->id;
                if (!empty($_POST['statename'])):
                    $state = State::find()->where(['statename' => $_POST['statename'], 'country_id' => $country->id])->one();
                    if (!empty($state)):
                        $city->state_id = $state->id;
                    else:
                        return array('status' => false, 'error' => 'No such State exists');
                    endif;
                endif;
            else:
                return array('status' => false, 'error' => 'No such State exists in this country.');
            endif;
        endif;
        if (!empty($_POST['statename'])):
            $state = State::find()->where(['statename' => $_POST['statename'], 'country_id' => $city->country_id])->one();
            if (!empty($state)):
                $city->state_id = $state->id;
            else:
                return array('status' => false, 'error' => 'No such State exists in this country.');
            endif;
        endif;
        if ($city->validate()) {
            $city->updated = time();
            $city->save(false);
            return array('status' => true, 'data' => 'City Updated successfully');
        } else {
            return array('status' => false, 'error' => $city->getErrors());
        }
    }

    /*
     * Api all city list
     */

    public function actionCityList() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $cities = City::find()->all();
        $count = City::find()->count();
        if ($count > 0) {
            $role = [];
            foreach ($cities as $city):
                $country = Country::findOne($city->country_id);
                $state = State::findOne($city->state_id);
                $dataxls[] = array('id' => $city->id, 'countryname' => $country->countryname, 'statename' => $state->statename, 'cityname' => $city->cityname);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Api delete city by id
     */

    public function actionDeleteCity($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $role = City::find()->where(['id' => $id])->one();
        if (!empty($role)) {
            $role->delete();
            return array('status' => true, 'data' => 'City deleted successfully');
        } else {
            return array('status' => false, 'error' => 'No such City exists');
        }
    }

    /*
     * Api User info By userid
     */

    public function actionUserInfo($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $user = RegisterUser::findOne($id);
        if (!empty($user)) {
            // foreach ($employee as $user):
            if (!empty($user->country)):
                    $country = Country::findOne($user->country);
                    $countryname = $country->countryname;
                else:
                    $countryname = 'NA';
                endif;
                if (!empty($user->state)):
                    $state = State::findOne($user->state);
                    $statename = $state->statename;
                else:
                    $statename = 'NA';
                endif;
                if (!empty($user->city)):
                    $city = City::findOne($user->city);
                    $cityname = $city->cityname;
                else:
                    $cityname = 'NA';
                endif;
                if (!empty($user->role)):
                    $role = Role::findOne($user->role);
                    $rolename = $role->role;
                else:
                    $rolename = 'NA';
                endif;
                if (!empty($user->status)):
                    if ($user->status == 0):
                        $status = "Inactive";
                    else:
                        $status = "Active";
                    endif;
                else:
                    $status = 'NA';
                endif;
                if (!empty($user->dob)):
                    $dob = date('m/d/Y', $user->dob);
                else:
                    $dob = 'NA';
                endif;
                $dataxls[] = array('id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username, 'email' => $user->email,'DOB' => $dob, 'countryname' => $countryname, 'statename' => $statename, 'cityname' => $cityname, 'role' => $rolename, 'status' => $status);
            //endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Such User Found');
        }
    }

    /*
     * User info By role id
     */

    public function actionUserInfobyrole($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->where(['role' => $id])->all();
        if (!empty($employee)) {
            foreach ($employee as $user):
                if (!empty($user->country)):
                    $country = Country::findOne($user->country);
                    $countryname = $country->countryname;
                else:
                    $countryname = 'NA';
                endif;
                if (!empty($user->state)):
                    $state = State::findOne($user->state);
                    $statename = $state->statename;
                else:
                    $statename = 'NA';
                endif;
                if (!empty($user->city)):
                    $city = City::findOne($user->city);
                    $cityname = $city->cityname;
                else:
                    $cityname = 'NA';
                endif;
                if (!empty($user->role)):
                    $role = Role::findOne($user->role);
                    $rolename = $role->role;
                else:
                    $rolename = 'NA';
                endif;
                if (!empty($user->status)):
                    if ($user->status == 0):
                        $status = "Inactive";
                    else:
                        $status = "Active";
                    endif;
                else:
                    $status = 'NA';
                endif;
                if (!empty($user->dob)):
                    $dob = date('m/d/Y', $user->dob);
                else:
                    $dob = 'NA';
                endif;
                $dataxls[] = array('id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username, 'email' => $user->email,'DOB' => $dob, 'countryname' => $countryname, 'statename' => $statename, 'cityname' => $cityname, 'role' => $rolename, 'status' => $status);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Such User Found');
        }
    }

    /*
     * Api User Info by Status
     */

    public function actionUserInfobystatus($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = RegisterUser::find()->where(['status' => $id])->all();
        if (!empty($employee)) {
            foreach ($employee as $user):
                if (!empty($user->country)):
                    $country = Country::findOne($user->country);
                    $countryname = $country->countryname;
                else:
                    $countryname = 'NA';
                endif;
                if (!empty($user->state)):
                    $state = State::findOne($user->state);
                    $statename = $state->statename;
                else:
                    $statename = 'NA';
                endif;
                if (!empty($user->city)):
                    $city = City::findOne($user->city);
                    $cityname = $city->cityname;
                else:
                    $cityname = 'NA';
                endif;
                if (!empty($user->role)):
                    $role = Role::findOne($user->role);
                    $rolename = $role->role;
                else:
                    $rolename = 'NA';
                endif;
                if (!empty($user->status)):
                    if ($user->status == 0):
                        $status = "Inactive";
                    else:
                        $status = "Active";
                    endif;
                else:
                    $status = 'NA';
                endif;
                if (!empty($user->dob)):
                    $dob = date('m/d/Y', $user->dob);
                else:
                    $dob = 'NA';
                endif;
                $dataxls[] = array('id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username, 'email' => $user->email,'DOB' => $dob, 'countryname' => $countryname, 'statename' => $statename, 'cityname' => $cityname, 'role' => $rolename, 'status' => $status);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Such User Found');
        }
    }

    /*
     * Api State list by Country id
     */

    public function actionStateListbycountry($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $states = State::find()->where(['country_id' => $id])->all();
        $count = State::find()->where(['country_id' => $id])->count();
        if ($count > 0) {
            $role = [];
            foreach ($states as $state):
                $country = Country::findOne($state->country_id);
                $dataxls[] = array('id' => $state->id, 'countryname' => $country->countryname, 'statename' => $state->statename);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Api City list by Country id
     */

    public function actionCityListbycountry($id) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $cities = City::find()->where(['country_id' => $id])->all();
        $count = City::find()->where(['country_id' => $id])->count();
        if ($count > 0) {
            $role = [];
            foreach ($cities as $city):
                $country = Country::findOne($city->country_id);
                $state = State::findOne($city->state_id);
                $dataxls[] = array('id' => $city->id, 'countryname' => $country->countryname, 'statename' => $state->statename, 'cityname' => $city->cityname);
            endforeach;
            return array('status' => true, 'data' => $dataxls);
        } else {
            return array('status' => false, 'data' => 'No Data Found');
        }
    }

    /*
     * Password reset Api using Email
     */

    public function actionRequestPasswordReset($email) {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $model = new RegisterUser;
        $model->scenario = 'password_reset_token';
        $model->attributes = \Yii::$app->request->get();
        if ($model->validate()) {
            if ($model->sendEmail($email)) {
                return array('status' => true, 'data' => 'Password has been reset.Please Check your email.');
            } else {
                return array('status' => false, 'data' => 'Sorry, we are unable to reset password for the provided email address.');
            }
        } else {
            return array('status' => false, 'error' => $model->getErrors());
        }
    }

    /*
     * 
     * Register User Api
     * 
     */

    public function actionRegister() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $employee = new RegisterUser();
        $employee->scenario = 'api_create';
        $employee->attributes = \Yii::$app->request->post();
        $employee1 = RegisterUser::find()->where(['email' => $employee->email])->one();
        if (!empty($employee1)):
            return array('status' => true, 'data' => 'data exists already.');
        endif;
        if ($employee->validate()) {
            $employee->setPassword($employee->password);
            $employee->status = 1;
            $employee->created = time();
            $employee->updated = time();
            $employee->save(false);
            return array('status' => true, 'data' => 'data saved successfully');
        } else {
            return array('status' => false, 'error' => $employee->getErrors());
        }
    }

    /*
     * Login Api
     * 
     */

    public function actionLogin() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        if (!(\Yii::$app->user->isGuest)) {
            return array('status' => true, 'data' => 'already logged in.');
        }
        $model = new LoginForm();
        $model->attributes = \Yii::$app->request->post();
        if ($model->login()) {
            return array('status' => true, 'data' => 'Login Successfully.');
        } else {
            return array('status' => true, 'data' => $model->getErrors());
        }
    }

    /*
     * Logout Api
     * 
     */

    public function actionLogout() {
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        if (!(\Yii::$app->user->isGuest)) {
        if (\Yii::$app->user->logout()):
            return array('status' => true, 'data' => 'logout Successfully.');
        endif;
        }
        else{
            return array('status' => true, 'data' => 'Please login first.');
        }
    }

}
