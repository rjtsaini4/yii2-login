<?php

namespace TBI\Login\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property integer $state_id
 * @property string $cityname
 * @property integer $created
 * @property integer $updated
 */
class City extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['country_id','state_id','cityname'],'required'],
            [['country_id','state_id', 'created', 'updated'], 'integer'],
            [['cityname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_id' => 'State Name',
            'country_id' => 'Country Name',
            'cityname' => 'Cityname',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

}
