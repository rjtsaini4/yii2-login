<?php

namespace TBI\Login\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $role
 * @property integer $created
 * @property integer $updated
 */
class Role extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['role'],'required'],
            [['role'], 'valdateRole','on'=>'create'],
            [['role'], 'valdateupdateRole','on'=>'update'],
            [['created', 'updated'], 'integer'],
            [['role'],'unique'],
            [['role'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
    public function valdateRole($attribute, $params, $validator) {
        $role = trim($this->$attribute, ' ');
        $check = Role::find()->where(['role' => $role])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'Role already Exists.');
        }
    }
    public function valdateupdateRole($attribute, $params, $validator) {
        $id = $_GET['id'];
        $role = trim($this->$attribute, ' ');
        $check = Role::find()->where(['role' => $role])->andWhere(['!=','id',$id])->all();
        if (!empty($check)) {
            $this->addError($attribute, 'Role already Exists.');
        }
    }

}
