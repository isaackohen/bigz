<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="theme-dark">
<head>
    <meta charset="utf-8" />
    <title>Datagamble - Admin Panel</title>
    <link rel="icon" type="image/png" href="../../img/logo/ico.png"/>
    <link href="//cloud.typenetwork.com/projects/5700/fontface.css/" rel="stylesheet" type="text/css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('/img/logo/ico.png') }}">

    <link href="{{ mix('css/admin/app.css') }}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{ mix('js/admin/app.js') }}"></script>
        <link href="https://coderthemes.com/shreyu/preview/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" /> 
    <link href="https://coderthemes.com/shreyu/preview/assets/css/app-dark.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
        window.Laravel = {
            userId: "{{ auth()->user()->_id }}"
        };
    </script>
</head>
<body>
<div id="wrapper">
    <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
        <div class="container-fluid">
            <a href="/admin" class="navbar-brand mr-0 mr-md-2 logo">
                <span class="logo-lg">
                    <img src="{{ asset('/img/logo/logo_bits_small.png') }}" alt="" height="20" />
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('/img/logo/logo_bits_small.png') }}" alt="" height="15">
                </span>
            </a>
            <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
                <li class="">
                    <button class="button-menu-mobile open-left disable-btn">
                        <i data-feather="menu" class="menu-icon"></i>
                        <i data-feather="x" class="close-icon"></i>
                    </button>
                </li>
            </ul>
            <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0" onclick="$.toggleRightBar()">
                <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left" title="Settings">
                    <a href="javascript:void(0);" class="nav-link">
                        <i data-feather="settings"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="left-side-menu">

        <div class="sidebar-content">
            <div id="sidebar-menu" class="slimscroll-menu">
                
                <ul class="metismenu" id="menu-bar">
                                       <ul class="navbar-nav d-flex list-unstyled topnav-menu float-left m-1 pl-2" onclick="$.toggleRightBar()">

            </ul> 
                    <li>
                        <a href="/admin">
                            <i data-feather="activity"></i>
                            <span> Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/modules">
                            <i data-feather="git-merge"></i>
                            <span> Modules</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/slotslist">
                            <i data-feather="cpu"></i>
                            <span> Slots</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/wallet" target="_blank">
                            <i data-feather="clock"></i>
                            <span class="badge badge-primary float-right">
                                {{ \App\Withdraw::where('status', 0)->count() }}
                            </span>
                            <span> Payments</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/promo">
                            <i data-feather="percent"></i>
                            <span> Promocodes</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users">
                            <i data-feather="users"></i>
                            <span> Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/notifications">
                            <i data-feather="bell"></i>
                            <span> Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/currency">
                            <i data-feather="disc"></i>
                            <span> Currencies</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/activity">
                            <i data-feather="alert-triangle"></i>
                            <span> Activity</span>
                        </a>
                    </li>
                    <li class="menu-title">Server</li>

                    <li>
                        <a href="/admin/settings">
                            <i data-feather="settings"></i>
                            <span> Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="window.open('/admin/logs', '_blank');">
                            <i data-feather="align-left"></i>
                            <span> Logs</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i data-feather="hash"></i>
                            <span class="badge badge-primary float-right">
                                {{ json_decode(file_get_contents(base_path('package.json')))->version }}
                            </span>
                            <span> Version</span>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="clearfix"></div>                
        </div>
        
    </div>
    <div class="content-page">
        <div class="content">
            <script src="{{ mix('js/admin/app.js') }}"></script>
            <div class="container-fluid pageContent">
                {!! $page !!}
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {{ date('Y') }} &copy; 
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="right-bar">
    <div class="rightbar-title">
        <h5 class="m-0">Games</h5>
    </div>
    <div class="slimscroll-menu">
        <div class="p-3">
            @foreach(\App\Games\Kernel\Game::list() as $game)
                @if($game->metadata()->isPlaceholder()) @continue @endif
                <div class="custom-control custom-checkbox mb-2" onclick="$.request('/admin/toggle', { name: '{{ $game->metadata()->id() }}' }); $(this).find('input').attr('checked', !$(this).find('input').attr('checked'))">
                    <input @if(!$game->isDisabled()) checked="checked" @endif type="checkbox" class="custom-control-input">
                    <label class="custom-control-label">{{ $game->metadata()->name() }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/coinponent/coinponent@1.2.6/dist/coinponent.js"></script>
<div class="rightbar-overlay" onclick="$.toggleRightBar()"></div>
</body>
</html>
