<?php

use vendor\almasaeed2010\adminlte\pages;
use yii\helpers\Html;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
<!--            <div class="pull-left image">
<?//= Html::img('@web/upload1/' . Yii::$app->user->identity->image, ['class' => "img-circle"]); ?>
            </div>-->
            <div class="pull-left info">
                <p><?php //echo Yii::$app->user->identity->username; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        [
                            'label' => 'Users',
                            'icon' => 'users',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Add Users', 'icon' => 'fas fa-plus', 'url' => ['/login/register/create'],],
                                ['label' => 'user-listing', 'icon' => 'fa fa-users', 'url' => ['/login/register/index'],],
                            ],
                        ],
                        [
                            'label' => 'Roles',
                            'icon' => 'users',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Add role', 'icon' => 'fas fa-plus', 'url' => ['/login/role/create'],],
                                ['label' => 'View Roles', 'icon' => 'fa fa-users', 'url' => ['/login/role/index'],],
                            ],
                        ],
                        [
                            'label' => 'Address',
                            'icon' => 'fas fa-address-card',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Country', 
                                    'icon' => 'fa fa-flag', 
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Add Country', 'icon' => 'fas fa-plus', 'url' => ['/login/country/create'],],
                                        ['label' => 'Country List', 'icon' => 'fas fa-list', 'url' => ['/login/country/index'],],
                                        ],
                                ],
                                [
                                    'label' => 'State', 
                                    'icon' => 'fa fa-flag', 
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Add State', 'icon' => 'fas fa-building', 'url' => ['/login/state/create'],],
                                        ['label' => 'States List', 'icon' => 'fas fa-list', 'url' => ['/login/state/index'],],
                                        ],
                                ],
                                [
                                    'label' => 'City', 
                                    'icon' => 'fas fa-building', 
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Add City', 'icon' => 'fas fa-plus', 'url' => ['/login/city/create'],],
                                        ['label' => 'Cities List', 'icon' => 'fas fa-list', 'url' => ['/login/city/index'],],
                                        ],
                                ],
                            ],
                        ],
                    ],
                ]
        )
        ?>

    </section>

</aside>