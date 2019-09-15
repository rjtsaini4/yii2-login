<?php

namespace TBI\Login;

use Yii;
use TBI\Login\generators\model\Generator;
use yii\base\InvalidConfigException;
use ReflectionClass;

/**
 * api module definition class
 */
class Login extends \yii\base\Module {

    public $table = 'register_user';
    public $table1 = 'role';
    public $country = 'country';
    public $state = 'state';
    public $city = 'city';
    public $templates = [];
    public $template = 'default';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'TBI\Login\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        if (!file_exists('profile_pic')) {
            if (!mkdir('profile_pic', 0777, true)) {
                die('Failed to create folders...');
            }
        }
        if (!isset($this->templates['default'])) {
            $this->templates['default'] = $this->defaultTemplate();
        }
        foreach ($this->templates as $i => $template) {
            $this->templates[$i] = Yii::getAlias($template);
        }
        $this->checkTable();
        $this->createmodel();
        // custom initialization code goes here
    }

    protected function checkTable() {
        if (isset(Yii::$app->db->schema->db->tablePrefix))
            $this->table = Yii::$app->db->schema->db->tablePrefix . $this->table;

        if (Yii::$app->db->schema->getTableSchema($this->table, true) === null) {
            Yii::$app->db->createCommand()
                    ->createTable(
                            $this->table, array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                        'firstname' => 'varchar(255) DEFAULT NULL',
                        'lastname' => 'varchar(255) DEFAULT NULL',
                        'username' => 'varchar(255) DEFAULT NULL',
                        'email' => 'varchar(255) DEFAULT NULL',
                        'password' => 'varchar(255) DEFAULT NULL',
                        'password_reset_token' => 'varchar(255) DEFAULT NULL',
                        'profile_pic' => 'varchar(255) DEFAULT NULL',
                        'status' => 'int(11) DEFAULT NULL',
                        'role' => 'int(11) DEFAULT NULL',
                        'country' => 'int(11) DEFAULT NULL',
                        'state' => 'int(11) DEFAULT NULL',
                        'city' => 'int(11) DEFAULT NULL',
                        'gender' => 'int(11) DEFAULT NULL',
                        'dob' => 'int(11) DEFAULT NULL',
                        'address' => 'text DEFAULT NULL',
                        'pincode' => 'int(11) DEFAULT NULL',
                        'created' => 'int(11) unsigned DEFAULT NULL',
                        'updated' => 'int(11) unsigned DEFAULT NULL',
                            ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
                    )
                    ->execute();
        }
        if (Yii::$app->db->schema->getTableSchema($this->table1, true) === null) {
            Yii::$app->db->createCommand()
                    ->createTable(
                            $this->table1, array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                        'role' => 'varchar(255) DEFAULT NULL',
                        'created' => 'int(11) unsigned DEFAULT NULL',
                        'updated' => 'int(11) unsigned DEFAULT NULL',
                            ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
                    )
                    ->execute();
        }
        if (Yii::$app->db->schema->getTableSchema($this->country, true) === null) {
            Yii::$app->db->createCommand()
                    ->createTable(
                            $this->country, array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                        'countryname' => 'varchar(255) DEFAULT NULL',
                        'created' => 'int(11) unsigned DEFAULT NULL',
                        'updated' => 'int(11) unsigned DEFAULT NULL',
                            ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
                    )
                    ->execute();
        }
        if (Yii::$app->db->schema->getTableSchema($this->state, true) === null) {
            Yii::$app->db->createCommand()
                    ->createTable(
                            $this->state, array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                        'country_id' => 'int(11) unsigned DEFAULT NULL',
                        'statename' => 'varchar(255) DEFAULT NULL',
                        'created' => 'int(11) unsigned DEFAULT NULL',
                        'updated' => 'int(11) unsigned DEFAULT NULL',
                            ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
                    )
                    ->execute();
        }
        if (Yii::$app->db->schema->getTableSchema($this->city, true) === null) {
            Yii::$app->db->createCommand()
                    ->createTable(
                            $this->city, array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
                        'country_id' => 'int(11) unsigned DEFAULT NULL',
                        'state_id' => 'int(11) unsigned DEFAULT NULL',
                        'cityname' => 'varchar(255) DEFAULT NULL',
                        'created' => 'int(11) unsigned DEFAULT NULL',
                        'updated' => 'int(11) unsigned DEFAULT NULL',
                            ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
                    )
                    ->execute();
        }
    }

    protected function createmodel() {

        // Generating Register Model
        if (!(class_exists('TBI\Login\models\RegisterUser', true))):
            $gen = new Generator;
            $gen->tableName = $this->table;
            $gen->generateQuery = true;
            $gen->ns = 'TBI\Login\models';
            $test = $gen->generate();
            $model = $this->save($test);
        endif;
//        if (!(class_exists('common\models\RegisterUser', true))):
//            $gen = new Generator;
//            $gen->tableName = $this->table;
//            $gen->generateQuery = true;
//            $gen->ns = 'common\models';
//            $test = $gen->generate();
//            $model = $this->save($test);
//        endif;
        //Generating Role Model
        if (!(class_exists('TBI\Login\models\Role', true))):
            $gen = new Generator;
            $gen->tableName = $this->table1;
            $gen->generateQuery = true;
            $gen->ns = 'TBI\Login\models';
            $test = $gen->generate();
            $model = $this->save($test);
        endif;
        //  Generating Country Model
        if (!(class_exists('TBI\Login\models\Country', true))):
            $gen = new Generator;
            $gen->tableName = $this->country;
            $gen->generateQuery = true;
            $gen->ns = 'TBI\Login\models';
            $test = $gen->generate();
            $model = $this->save($test);
        endif;
        // Generate State Model
        if (!(class_exists('TBI\Login\models\State', true))):
            $gen = new Generator;
            $gen->tableName = $this->state;
            $gen->generateQuery = true;
            $gen->ns = 'TBI\Login\models';
            $test = $gen->generate();
            $model = $this->save($test);
        endif;

        // Generating CIty Model
        if (!(class_exists('TBI\Login\models\City', true))):
            $gen = new Generator;
            $gen->tableName = $this->city;
            $gen->generateQuery = true;
            $gen->ns = 'TBI\Login\models';
            $test = $gen->generate();
            $model = $this->save($test);
        endif;
//
        if (!(class_exists('TBI\Login\models\RoleSearch', true))):
            $crud = new \TBI\Login\generators\crud\Generator;
            $crud->modelClass = 'TBI\Login\models\Role';
            $crud->searchModelClass = 'TBI\Login\models\RoleSearch';
            $crud->controllerClass = 'TBI\Login\controllers\RoleController';
            $crud->enablePjax = true;
            $test1 = $crud->generate();
            $model = $this->save($test1);
        endif;

        if (!(class_exists('TBI\Login\models\CountrySearch', true))):
            $crud = new \TBI\Login\generators\crud\Generator;
            $crud->modelClass = 'TBI\Login\models\Country';
            $crud->searchModelClass = 'TBI\Login\models\CountrySearch';
            $crud->controllerClass = 'TBI\Login\controllers\CountryController';
            $crud->enablePjax = true;
            $test1 = $crud->generate();
            $model = $this->save($test1);
        endif;

        if (!(class_exists('TBI\Login\models\StateSearch', true))):
            $crud = new \TBI\Login\generators\crud\Generator;
            $crud->modelClass = 'TBI\Login\models\State';
            $crud->searchModelClass = 'TBI\Login\models\StateSearch';
            $crud->controllerClass = 'TBI\Login\controllers\StateController';
            $crud->enablePjax = true;
            $test1 = $crud->generate();
            $model = $this->save($test1);
        endif;

        if (!(class_exists('TBI\Login\models\CitySearch', true))):
            $crud = new \TBI\Login\generators\crud\Generator;
            $crud->modelClass = 'TBI\Login\models\City';
            $crud->searchModelClass = 'TBI\Login\models\CitySearch';
            $crud->controllerClass = 'TBI\Login\controllers\CityController';
            $crud->enablePjax = true;
            $test1 = $crud->generate();
            $model = $this->save($test1);
        endif;
        //return true;
    }

    public function save($files) {
        $lines = ['Generating code using template "' . $this->getTemplatePath() . '"...'];
        $hasError = false;
        foreach ($files as $file) {
            $relativePath = $file->getRelativePath();
            $error = $file->save();
            if (is_string($error)) {
                $hasError = true;
                $lines[] = "generating $relativePath\n<span class=\"error\">$error</span>";
            } else {
                $lines[] = $file->operation === CodeFile::OP_CREATE ? " generated $relativePath" : " overwrote $relativePath";
            }
        }
        $lines[] = "done!\n";

        return !$hasError;
    }

    public function getRelativePath() {
        if (strpos($this->path, Yii::$app->basePath) === 0) {
            return substr($this->path, strlen(Yii::$app->basePath) + 1);
        } else {
            return $this->path;
        }
    }

    public function save1() {
        $this->operation = 'create';
        //$module = Yii::$app->controller->module;
        if ($this->operation === self::OP_CREATE) {
            $dir = dirname($this->path);
            if (!is_dir($dir)) {
                $mask = @umask(0);
                $result = @mkdir($dir, 511, true);
                @umask($mask);
                if (!$result) {
                    return "Unable to create the directory '$dir'.";
                }
            }
        }
        if (@file_put_contents($this->path, $this->content) === false) {
            return "Unable to write the file '{$this->path}'.";
        } else {
            $mask = @umask(0);
            @chmod($this->path, 438);
            @umask($mask);
        }

        return true;
    }

    public function getTemplatePath() {
        if (isset($this->templates[$this->template])) {
            return $this->templates[$this->template];
        } else {
            throw new InvalidConfigException("Unknown template: {$this->template}");
        }
    }

    public function defaultTemplate() {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()) . '/default';
    }

}
