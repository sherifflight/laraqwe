<!-- BEGIN SIDEBAR -->
<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
    <div class="sidebar-overlay-slide from-top" id="appMenu"></div>
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <div class="sidebar-header-controls">
            <button data-toggle-pin="sidebar" class="btn btn-link visible-lg-inline m-l-75" type="button" style=""><i class="fa fs-12"></i></button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items p-t-20 p-b-30">
            @php
                /** @var \App\Models\User $user */
                $user = auth('dashboard')->user();
            @endphp

            @if(canview('users', $user))
                @include('dashboard.layouts.partials.sidebar-item', [
                    'name' => 'Список пользователей ',
                    'routeRoot' => 'dashboard.users',
                    'featherIcon' => 'user',
                    'links' => [
                        [
                            'name' => 'Список',
                            'route' => 'dashboard.users.index',
                            'featherIcon' => 'list'
                        ],
                        [
                            'name' => 'Создать',
                            'route' => 'dashboard.users.create',
                            'featherIcon' => 'user-plus'
                        ]
                    ]
                ])
            @endif

            @if(canview('pages', $user))
                @include('dashboard.layouts.partials.sidebar-item', [
                    'name' => 'Список страниц ',
                    'routeRoot' => 'dashboard.pages',
                    'featherIcon' => 'user',
                    'links' => [
                        [
                            'name' => 'Список',
                            'route' => 'dashboard.pages.index',
                            'featherIcon' => 'list'
                        ],
                    ]
                ])
            @endif
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
<!-- END SIDEBAR -->
