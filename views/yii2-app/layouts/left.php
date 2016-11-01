<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/default-50x50.gif" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Placeholder</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Management Menu', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Dashboard', 
                        'icon' => 'fa fa-dashboard', 
                        'url' => ['/dashboard'],

                    ],
                    [
                        'label' => 'Client Management', 
                        'icon' => 'fa fa-users', 
                        'url' => ['/equipment'],

                        'items' => [
                                        ['label' => 'Clients', 'icon' => 'fa fa-dashboard', 'url' => ['/customers'],],
                                        ['label' => 'Areas', 'icon' => 'fa fa-dashboard', 'url' => ['/company-locations'],],
                                        
                                   ],
                    ],
                    
                    [ 
                      'label' => 'Equipments & Products', 
                      'icon' => 'fa fa-wrench', 
                      'items' => [
                            ['label' => 'equipments', 'icon' => '', 'url' => ['/equipment'],],
                            ['label' => 'products', 'icon' => '', 'url' => ['/products'],],
                           
                        ],

                    ],
                    [
                        'label' => 'Job Management',
                        'icon' => 'fa fa-arrows',
                        'url' => '/dashboards/inspection-reports',
                        'items' => [
                            ['label' => 'Estimates', 'icon' => 'fa fa-dashboard', 'url' => ['/estimates'],],
                            ['label' => 'Job Orders', 'icon' => 'fa fa-calculator', 'url' => ['/estimates/job-order-index'],],
                            ['label' => 'Schedules', 'icon' => 'fa fa-calendar-o', 'url' => ['/estimates/schedules'],],
                            ['label' => 'Job Assignment', 'icon' => 'fa fa-calendar-o', 'url' => ['/estimates/assign-index'],],
                            
                        ],
                    ],
                     [
                        'label' => 'Deployment & Inspection', 
                        'icon' => '', 
                        'url' => ['/bsr-header'],

                    ],
                   // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                   /* [
                        'label' => 'Tehnician Reports',
                        'icon' => 'fa fa-list-alt',
                        'url' => '/dashboards/inspection-reports',
                        'items' => [
                            ['label' => 'Log BSR', 'icon' => 'fa fa-dashboard', 'url' => ['#'],],
                            ['label' => 'Log PMI', 'icon' => 'fa fa-dashboard', 'url' => ['#'],],
                            ['label' => 'Reports', 'icon' => 'fa fa-bar-chart', 'url' => ['#'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/

                    
                ],
            ]
        ) ?>

    </section>

</aside>
