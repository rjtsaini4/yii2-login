<?php

namespace TBI\Login\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $name
 * @property integer $age
 * @property integer $created
 */
class Employee extends \yii\db\ActiveRecord {

    const SCENARIO_CREATE = 'create';

    public $token;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'age'], 'required'],
            [['name'], 'unique'],
            [['age'], 'integer'],
            [['name', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Age',
            'created' => 'Created',
            'token' => 'Token'
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['name', 'age', 'token'];
        return $scenarios;
    }

}
