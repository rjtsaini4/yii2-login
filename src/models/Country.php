<?php

namespace TBI\Login\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $countryname
 * @property integer $created
 * @property integer $updated
 */
class Country extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['countryname'], 'required'],
            [['countryname'], 'valdateCountry','on'=>'create'],
            [['countryname'], 'valdateupdateCountry','on'=>'update'],
            [['created', 'updated'], 'integer'],
            [['countryname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'countryname' => 'Countryname',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function valdateCountry($attribute, $params, $validator) {
        $country = trim($this->$attribute, ' ');
        $check = Country::find()->where(['countryname' => $country])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'Country already Exists.');
        }
    }
    public function valdateupdateCountry($attribute, $params, $validator) {
        $id = $_GET['id'];
        $country = trim($this->$attribute, ' ');
        $check = Country::find()->where(['countryname' => $country])->andWhere(['!=','id',$id])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'Country already Exists.');
        }
    }

}
