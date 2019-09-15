<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Role */

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if ($model->status == 0):
    $status = 'Inactive';
else:
    $status = "Active";
endif;
if ($model->gender == 0):
    $gender = 'Female';
else:
    $gender = "Male";
endif;
$rolearray = TBI\Login\models\Role::findOne($model->role);
$role = $rolearray->role;
$rolearray = TBI\Login\models\Country::findOne($model->country);
$countryname = $rolearray->countryname;
$rolearray = TBI\Login\models\State::findOne($model->state);
$statename = $rolearray->statename;
$cityarray = TBI\Login\models\City::findOne($model->city);
$cityname = $cityarray->cityname;
$dob = date('m/d/Y', $model->dob);
?>
<div class="user-view">
    <div class="row">
        <div class="col-md-3 col-xs-12">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Information</h3>
                </div>
                <div class="box-body box-profile">
                    <img alt="User profile picture" src="../../profile_pic/<?php echo $model->profile_pic ?>" class="profile-user-img img-responsive img-circle">

                    <h3 class="profile-username text-center"><?= $model->firstname . ' ' . $model->lastname; ?></h3>


                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right"><?= $model->email; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>username</b> <a class="pull-right"><?= $model->username; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> <a class="pull-right"><?= $status; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Role</b> <a class="pull-right"><?= $role; ?></a>
                        </li>
                    </ul>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-3 col-xs-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Information</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Firstname</b> <a class="pull-right"><?= $model->firstname; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Lastname</b> <a class="pull-right"><?= $model->lastname; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Gender</b> <a class="pull-right"><?= $gender; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Date Of Birth</b> <a class="pull-right"><?= $dob; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Address</b> <a class="pull-right"><?= $model->address;?></a>
                        </li>
                        <li class="list-group-item">
                            <b>City</b> <a class="pull-right"><?= $cityname;?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Location</b> <a class="pull-right"><?= $statename; ?>,<?= $countryname; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Pin-Code</b> <a class="pull-right"><?= $model->pincode; ?></a>
                        </li>
                    </ul>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
