<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title data-base-url="{{ URL::to('/') }}/">Login</title>

        @include('back.common.header_ref')

    </head>
    <body ng-app="App">
        <div layout="row">
            <div flex="15" hide-md hide-sm>&nbsp;</div>
            <div flex id="main-container">
    
                <div ng-controller="User as vm" layout="column">
                    <md-toolbar class="md-primary">
                        <h1 class="md-toolbar-tools">
                            Login 
                        </h1>
                    </md-toolbar>
                    <md-content layout-padding>
                        <form name="loginForm" action="{{ URL::route('backManageAuthen') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <md-input-container>
                                <label>User name</label>
                                <input type="email" name="email" ng-model="vm.model.forms.login.fields.email.value" required autofocus>
                                <div ng-messages="loginForm.email.$error" ng-if="loginForm.email.$touched">
                                    <div ng-message="required">Email is required.</div>
                                </div>
                            </md-input-container>

                            <md-input-container>
                                <label>Password</label>
                                <input type="password" name="password" ng-model="vm.model.forms.login.fields.password.value" -required>
                                <div ng-messages="loginForm.password.$error" ng-if="loginForm.password.$touched">
                                    <div ng-message="required">Password is required.</div>
                                </div>
                            </md-input-container>

                            @if($message)
                            <div class="alert alert-warning" role="alert">
                                <div class="common-err">
                                    {{ $message }} 
                                </div>
                            </div>
                            @endif

                            <md-input-container>
                                <md-button class="md-raised md-primary">Login</md-button>
                            </md-input-container>

                        </form>
                    </md-content>
                </div>


            </div>
            <div flex="15" hide-md hide-sm>&nbsp;</div>
        </div>
        
        @include('back.common.footer_ref')
    </body>
</html>
