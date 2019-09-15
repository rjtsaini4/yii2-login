#Register module for Yii 2.0 Framework advanced template

## Installation

Before installing this Module ,please install admin lte through composer

Either run:

```bash
composer require dmstr/yii2-adminlte-asset "2.*"
```

or add

```bash
"dmstr/yii2-adminlte-asset": "2.*",
```

to the require section of your `composer.json` file.


The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run:

```bash
composer require tbi/yii2-login
```

or add

```bash
"tbi/yii2-login": "*"
```

to the require section of your `composer.json` file.

Usage
-----

1.add link to RegisterModule in your config

```php
return [
    'modules' => [
        'login' => [
            'class' => 'TBI\Login\Login',
        ],
    ],
]; 
```
```php

To Generate Table in database

<website url  or localhost path to directory>/login/register/generate-table

To add user
<website url  or localhost path to directory>/login/register/create

Update User
<website url  or localhost path to directory>/login/register/update?id=<:id>

User listing
<website url  or localhost path to directory>/login/register/index

Country Listing
<website url  or localhost path to directory>/login/country/index

State Listing
<website url  or localhost path to directory>/login/state/index

City Listing
<website url  or localhost path to directory>/login/city/index

Role Listing
<website url  or localhost path to directory>/login/role/index
```

```php

API Lists


User Information API's

    <website url  or localhost path to directory>/login/api/register(firstname,lastname,email,password)

    <website url  or localhost path to directory>/login/api/user-infobystatus?id=<:id>

    <website url  or localhost path to directory>/login/api/user-infobyrole?id=<:id>

    <website url  or localhost path to directory>/login/api/user-info?id=<:id>

    <website url  or localhost path to directory>/login/api/list

    <website url  or localhost path to directory>/login/api/delete?id=<:id>
    
    
Role API's 
   
    
    <website url  or localhost path to directory>/login/api/add-role(role)

   <website url  or localhost path to directory>/login/api/update-role?id=<:id>
    
    <website url  or localhost path to directory>/login/api/role-list
    
    <website url  or localhost path to directory>/login/api/delete-role?id=<:id>

Country API's  

    <website url  or localhost path to directory>/login/api/add-country(countryname)

    <website url  or localhost path to directory>/login/api/update-country?id=<:id>
 
    <website url  or localhost path to directory>/login/api/country-list

    <website url  or localhost path to directory>/login/api/delete-country?id=<:id>

State API's

    <website url  or localhost path to directory>/login/api/add-state(countryname,statename)

    <website url  or localhost path to directory>/login/api/update-state?id=<:id>
 
    <website url  or localhost path to directory>/login/api/state-list

    <website url  or localhost path to directory>/login/api/delete-state?id=<:id>

    <website url  or localhost path to directory>/login/api/state-listbycountry?id=<:id>

City API's
    
    <website url  or localhost path to directory>/login/api/add-city(countryname,statename,cityname)

    <website url  or localhost path to directory>/login/api/update-city?id=<:id>
 
    <website url  or localhost path to directory>/login/api/city-list

    <website url  or localhost path to directory>/login/api/delete-city?id=<:id>

    <website url  or localhost path to directory>/login/api/city-listbycountry?id=<:id>
```
```php

Login API's

    for login API ,user need to change table name to 'register_user'.
    
    and Replace the user Model
    
   <?php
    namespace common\models;

    use Yii;
    use yii\base\NotSupportedException;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    use yii\web\IdentityInterface;

    /**
     * User model
     *
     * @property integer $id
     * @property string $username
     * @property string $password
     * @property string $password_reset_token
     * @property string $email
     * @property string $auth_key
     * @property integer $status
     * @property integer $created_at
     * @property integer $updated_at
     * @property string $password write-only password
     */
    class User extends ActiveRecord implements IdentityInterface
    {
        const STATUS_DELETED = 0;
        const STATUS_ACTIVE = 1;


        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%register_user}}';
        }

        /**
         * {@inheritdoc}
         */
        public function behaviors()
        {
            return [
                TimestampBehavior::className(),
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                ['status', 'default', 'value' => self::STATUS_ACTIVE],
                ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public static function findIdentity($id)
        {
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }

        /**
         * {@inheritdoc}
         */
        public static function findIdentityByAccessToken($token, $type = null)
        {
            throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

        /**
         * Finds user by username
         *
         * @param string $username
         * @return static|null
         */
        public static function findByUsername($username)
        {
            return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        }
        public static function findByEmail($email)
        {
            return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
        }

        /**
         * Finds user by password reset token
         *
         * @param string $token password reset token
         * @return static|null
         */
        public static function findByPasswordResetToken($token)
        {
            if (!static::isPasswordResetTokenValid($token)) {
                return null;
            }

            return static::findOne([
                'password_reset_token' => $token,
                'status' => self::STATUS_ACTIVE,
            ]);
        }

        /**
         * Finds out if password reset token is valid
         *
         * @param string $token password reset token
         * @return bool
         */
        public static function isPasswordResetTokenValid($token)
        {
            if (empty($token)) {
                return false;
            }

            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.passwordResetTokenExpire'];
            return $timestamp + $expire >= time();
        }

        /**
         * {@inheritdoc}
         */
        public function getId()
        {
            return $this->getPrimaryKey();
        }

        /**
         * {@inheritdoc}
         */
        public function getAuthKey()
        {
            //return $this->auth_key;
        }

        /**
         * {@inheritdoc}
         */
        public function validateAuthKey($authKey)
        {
            //return $this->getAuthKey() === $authKey;
        }

        /**
         * Validates password
         *
         * @param string $password password to validate
         * @return bool if password provided is valid for current user
         */
        public function validatePassword($password)
        {
            return Yii::$app->security->validatePassword($password, $this->password);
        }

        /**
         * Generates password hash from password and sets it to the model
         *
         * @param string $password
         */
        public function setPassword($password)
        {
            $this->password = Yii::$app->security->generatePasswordHash($password);
        }

        /**
         * Generates "remember me" authentication key
         */
        public function generateAuthKey()
        {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        /**
         * Generates new password reset token
         */
        public function generatePasswordResetToken()
        {
            $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        }

        /**
         * Removes password reset token
         */
        public function removePasswordResetToken()
        {
            $this->password_reset_token = null;
        }
    }

    API Link
    <website url  or localhost path to directory>/login/api/login

```
```php
Password Reset API's

    <website url  or localhost path to directory>/login/api/request-password-reset?email=<:email>

```
