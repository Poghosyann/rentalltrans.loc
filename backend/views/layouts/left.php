<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    #sliders
                    [
                        'label' => 'Sliders',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/sliders'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/sliders/create'],],
                        ],
                    ],
                    #pages
                    [
                        'label' => 'Pages',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/pages'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/pages/create'],],
                        ],
                    ],
                    #categories
                    [
                        'label' => 'Categories',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/categories'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/categories/create'],],
                        ],
                    ],
                    #class-item
                    [
                        'label' => 'Class',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/class-item'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/class-item/create'],],
                        ],
                    ],
                    #Additional products
                    [
                        'label' => 'Additional products',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/company-products'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/company-products/create'],],
                        ],
                    ],

                    #Filters
                    [
                        'label' => 'Filters',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/filters'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/filters/create'],],
                        ],
                    ],

                    #Marka
                    [
                        'label' => 'Marka',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/marka'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/marka/create'],],
                        ],
                    ],

                    #Model
                    [
                        'label' => 'Model',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/model'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/model/create'],],
                        ],
                    ],

                    #Transmission Vehicles
                    [
                        'label' => 'Transmission Vehicles',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/transmission-vehicles'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/transmission-vehicles/create'],],
                        ],
                    ],

                    #Type Body
                    [
                        'label' => 'Type Body',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'List', 'icon' => 'fa fa-file-code-o', 'url' => ['/type-body'],],
                            ['label' => 'Create', 'icon' => 'fa fa-dashboard', 'url' => ['/type-body/create'],],
                        ],
                    ],
                    #Items
                    ['label' => 'Items','icon' => 'fa fa-share','url' => ['/items'],],

                    #User Management
                    ['label' => 'User Management','icon' => 'fa fa-share','url' => ['/users'],],

                    #User Management
                    ['label' => 'Order','icon' => 'fa fa-share','url' => ['/order'],],

                    #Settings
                    ['label' => 'Settings','icon' => 'fa fa-share','url' => ['/settings'],],
                ],
            ]
        ) ?>

    </section>

</aside>
