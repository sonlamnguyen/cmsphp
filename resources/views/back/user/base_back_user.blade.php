<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title data-base-url="{{ URL::to('/') }}/">@yield('title')</title>

        @include('back.common.header_ref')

        <script type="text/javascript">
            $(function(){
                $("#{{ $activeMenu or 'null-menu'}}").addClass('active');
                $(".wlink").click(function(){
                    $("#global-loading").show();
                });
            });
        </script>
    </head>
    <body layout="column" ng-app="App">

        <div ng-controller="Toolbar as vm">

            <div layout="row" flex>
                <md-sidenav class="md-sidenav-left md-whiteframe-z2" md-component-id="mainNavBar">
                    <md-toolbar class="md-theme-light">
                        <h1 class="md-toolbar-tools">Main Menu</h1>
                    </md-toolbar>
                    <md-content layout-padding>
                        <md-subheader class="md-no-sticky">User zone</md-subheader>
                        <md-list class="listdemoListControls">
                            <a href="{{ route('backUserArea') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backUserArea">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Vung</p>
                                </md-list-item>
                            </a>

                            <a href="{{ route('backUserDevice') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backUserDevice">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Loai thiet bi</p>
                                </md-list-item>
                            </a>
                            <a href="{{ route('backUserScene') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backUserScene">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Ngu canh</p>
                                </md-list-item>
                            </a>
                        </md-list>

                        <md-divider></md-divider>

                        <md-subheader class="md-no-sticky">Admin zone</md-subheader>

                        <md-list class="listdemoListControls">
                            <a href="{{ route('backManageIndex') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backManageIndex">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Profile</p>
                                </md-list-item>
                            </a>

                            <a href="{{ route('backManageUser') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backManageUser">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>User</p>
                                </md-list-item>
                            </a>

                            <a href="{{ route('backManageArea') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backManageArea">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Area</p>
                                </md-list-item>
                            </a>

                            <a href="{{ route('backManageDevice') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backManageDevice">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Device</p>
                                </md-list-item>
                            </a>
                            <a href="{{ route('backManageScene') }}" class="wlink">
                                <md-list-item ng-click="vm.onNavSideItemClick($event)" id="backManageScene">
                                    <img ng-src="{$ STATIC_URL $}images/icons/menu.svg" class="md-avatar"/>
                                    <p>Scene</p>
                                </md-list-item>
                            </a>
                        </md-list>
                    </md-content>
                </md-sidenav>
            </div>

            <md-toolbar md-scroll-shrink>
                <div class="md-toolbar-tools">
                    <md-button class="md-icon-button" aria-label="Settings" ng-click="vm.toggle()">
                        <md-icon md-svg-icon="{$ STATIC_URL $}images/icons/menu.svg"></md-icon>
                    </md-button>

                    <h2>
                        <span>@yield('title')</span>
                    </h2>

                    <span flex></span>
                    <a href="{{ route('backManageLogout') }}">
                        <md-button class="md-icon-button" aria-label="More">
                            <md-icon md-svg-icon="{$ STATIC_URL $}images/icons/logout.svg"></md-icon>
                        </md-button>
                    </a>
                </div>
            </md-toolbar>

            <div layout="row">            
                <div flex="15" hide-md hide-sm>&nbsp;</div>
                <div flex id="main-container">
                    <div id="global-loading">
                        <md-progress-circular md-mode="indeterminate"></md-progress-circular>
                    </div>
                    @section('content')
                        This is the content
                    @show
                </div>
                <div flex="15" hide-md hide-sm>&nbsp;</div>
            </div>

        </div>

        @include('back.common.footer_ref')
    </body>
</html>
