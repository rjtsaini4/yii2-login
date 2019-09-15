<?php

namespace TBI\Login\models;

use Yii;
use TBI\Login\models\Country;

/**
 * This is the model class for table "state".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $statename
 * @property integer $created
 * @property integer $updated
 */
class State extends \yii\db\ActiveRecord {

    // for api
    public $countryname;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'state';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['country_id', 'statename'], 'required'],
            [['country_id', 'created', 'updated'], 'integer'],
            [['statename'], 'validateState', 'on' => 'create'],
            [['statename'], 'validateupdateState', 'on' => 'update'],
            [['statename'], 'validateAPIState', 'on' => 'apicreate'],
            [['statename'], 'validateAPIupdateState', 'on' => 'apiupdate'],
            [['statename', 'countryname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'statename' => 'Statename',
            'countryname' => 'countryname',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function validateState($attribute, $params, $validator) {
        $state = trim($this->$attribute, ' ');
        $country = Yii::$app->request->post()['State']['country_id'];
        $check = State::find()->where(['statename' => $state, 'country_id' => $country])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'State already Exists for this country');
        }
    }

    public function validateupdateState($attribute, $params, $validator) {
        $id = $_GET['id'];
        $state = trim($this->$attribute, ' ');
        $country = Yii::$app->request->post()['State']['country_id'];
        $check = State::find()->where(['statename' => $state, 'country_id' => $country])->andWhere(['!=', 'id', $id])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'State already Exists for this country');
        }
    }
    
    public function validateAPIState($attribute, $params, $validator) {
        $state = trim($this->$attribute, ' ');
        if (!empty($this->countryname)):
            $country = Country::find()->where(['countryname' => $this->countryname])->one();
            if (!empty($country)):
                $this->country_id = $country->id;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        $check = State::find()->where(['statename' => $state, 'country_id' => $this->country_id])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'State already Exists for this country');
        }
    }

    public function validateAPIupdateState($attribute, $params, $validator) {
        $id = $_GET['id'];
        $state = trim($this->$attribute, ' ');
        if (!empty($this->countryname)):
            $country = Country::find()->where(['countryname' => $this->countryname])->one();
            if (!empty($country)):
                $country = $country->id;
            else:
                return array('status' => false, 'error' => 'No such country exists');
            endif;
        endif;
        $check = State::find()->where(['statename' => $state, 'country_id' => $country])->andWhere(['!=', 'id', $id])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'State already Exists for this country');
        }
    }
}
