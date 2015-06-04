@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!}
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	<!--
	<md-toolbar class="md-primary">
		<h1 class="md-toolbar-tools">
			Thong Tin Ca Nhan 
		</h1>
	</md-toolbar>
	-->
	<div class="padding-10" ng-controller="User as vm" ng-cloak>
		<div>
			<div class="md-headline">{$ vm.model.vars.userData.name $}</div>
			<div>Email: <a href="mailto:{$ vm.model.vars.user_data.email $}">{$ vm.model.vars.userData.email $}</a></div>
	    </div>
	    <br/>
	    <div>
	    	<md-button class="md-raised md-primary" ng-click="vm.toggleModal('profileForm')">Edit Profile</md-button>
	    	<md-button ng-click="vm.toggleModal('passwordForm')">Change Password</md-button>
	    </div>

		<!-- Profile Modal -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <form class="modal-dialog" name="profileForm" ng-submit="vm.model.acts.editProfile()">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Sửa thông tin cá nhân</h4>
		            </div>
		            <div class="modal-body">

		           		<md-input-container>
                            <label>{$ 'profileForm.name.'|fm:vm $}</label>
                            <input name="name" ng-model="vm.model.forms.profileForm.fields.name.value" required>
                            <div ng-messages="profileForm.name.$error" ng-if="profileForm.name.$touched">
                                <div ng-message="required">Name is required.</div>
                            </div>
                        </md-input-container>

		            </div>
		            <div class="modal-footer">
		                <div class="alert alert-danger" role="alert">
		                    <div class="common-err">
		                        Some error
		                    </div>
		                </div>
		                
		                <md-button data-dismiss="modal" type="button">Close</md-button>
	    				<md-button class="md-raised md-primary">Save</md-button>
		            </div>
		        </div>
		    </form>
		</div>
		<!-- Password Modal -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <form class="modal-dialog" name="passwordForm" ng-submit="vm.model.acts.editPassword()">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Đổi mật khẩu</h4>
		            </div>
		            <div class="modal-body">
						<md-input-container>
                            <label>{$ 'passwordForm.password.'|fm:vm $}</label>
                            <input type="password" name="password" ng-model="vm.model.forms.passwordForm.fields.password.value" required>
                            <div ng-messages="passwordForm.password.$error" ng-if="passwordForm.password.$touched">
                                <div ng-message="required">Old password is required.</div>
                            </div>
                            <div ng-messages="passwordForm.password.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.passwordForm.fields.password.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'passwordForm.newPassword.'|fm:vm $}</label>
                            <input type="password" name="newPassword" ng-model="vm.model.forms.passwordForm.fields.newPassword.value" required>
                            <div ng-messages="passwordForm.newPassword.$error" ng-if="passwordForm.newPassword.$touched">
                                <div ng-message="required">New assword again is required.</div>
                            </div>
                            <div ng-messages="passwordForm.newPassword.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.passwordForm.fields.newPassword.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'passwordForm.newPasswordAgain.'|fm:vm $}</label>
                            <input type="password" name="newPasswordAgain" ng-model="vm.model.forms.passwordForm.fields.newPasswordAgain.value" required>
                            <div ng-messages="passwordForm.newPasswordAgain.$error" ng-if="passwordForm.newPasswordAgain.$touched">
                                <div ng-message="required">New password again is required.</div>
                            </div>
                            <div ng-messages="passwordForm.newPasswordAgain.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.passwordForm.fields.newPasswordAgain.error $}
                                </div>
                            </div>
                        </md-input-container>
		            </div>

		            <div class="modal-footer">
		                <div class="alert alert-danger" role="alert">
		                    <div class="common-err">
		                        Some error
		                    </div>
		                </div>

				    	<md-button data-dismiss="modal" type="button">Close</md-button>
	    				<md-button class="md-raised md-primary">Save</md-button>
		            </div>
		        </div>
		    </form>
		</div>
	</div>
	
@stop
