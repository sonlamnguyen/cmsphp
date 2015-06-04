@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!};
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	
	<div flex ng-controller="User as vm">
		
		<table class="list-table" ng-show="vm.model.vars.listItem | count">
			<tr ng-repeat="item in vm.model.vars.listItem">
				<td class="row-content">
					{$ item.name $} - {$ item.role $}<br/>
					<a href="mailto:{$ item.email $}">{$ item.email $}</a>
				</td>
				<td class="row-tool">
					<md-button ng-click="vm.toggleModal('mainForm', true, item.id)" aria-label="Edit item">
						<span class="glyphicon glyphicon-pencil tool-icon" ></span>
					</md-button>
					<md-button ng-click="vm.model.acts.confirmRemove(item.id)" aria-label="Remove item">
						<span class="glyphicon glyphicon-remove tool-icon"></span>
					</md-button>
				</td>
			</tr>
		</table>

		<h2 class="md-display-1" ng-show="!(vm.model.vars.listItem | count)">
			&nbsp; No user exist.
		</h2>

		<md-button class="md-fab md-warn tool-assis" aria-label="Add new" ng-click="vm.toggleModal('mainForm')">
			<md-icon md-svg-src="{$ STATIC_URL $}images/icons/plus.svg"></md-icon>
		</md-button>


		<!-- Profile Modal -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <form class="modal-dialog" name="mainForm" ng-submit="vm.model.acts.submitForm('mainForm')">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">{$ vm.model.vars.modalName $}</h4>
		            </div>

		            <div class="modal-body">
		           		<md-input-container>
                            <label>{$ 'mainForm.email.'|fm:vm $}</label>
                            <input type="email" name="email" ng-model="vm.model.forms.mainForm.fields.email.value" required>
                            <div ng-messages="mainForm.email.$error" ng-if="mainForm.email.$touched">
                                <div ng-message="required">Email is required.</div>
                            </div>
                            <div ng-messages="mainForm.email.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.email.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container ng-if="vm.model.forms.mainForm.id === null">
                            <label>{$ 'mainForm.password.'|fm:vm $}</label>
                            <input type="password" name="password" ng-model="vm.model.forms.mainForm.fields.password.value" required>
                            <div ng-messages="mainForm.password.$error" ng-if="mainForm.password.$touched">
                                <div ng-message="required">Password is required.</div>
                            </div>
                            <div ng-messages="mainForm.password.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.password.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container ng-if="vm.model.forms.mainForm.id === null">
                            <label>{$ 'mainForm.passwordAgain.'|fm:vm $}</label>
                            <input type="password" name="passwordAgain" ng-model="vm.model.forms.mainForm.fields.passwordAgain.value" required>
                            <div ng-messages="mainForm.passwordAgain.$error" ng-if="mainForm.passwordAgain.$touched">
                                <div ng-message="required">Password again is required.</div>
                            </div>
                            <div ng-messages="mainForm.passwordAgain.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.passwordAgain.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.name.'|fm:vm $}</label>
                            <input name="name" ng-model="vm.model.forms.mainForm.fields.name.value" required>
                            <div ng-messages="mainForm.name.$error" ng-if="mainForm.name.$touched">
                                <div ng-message="required">Name is required.</div>
                            </div>
                            <div ng-messages="mainForm.name.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.name.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
							<md-checkbox ng-model="vm.model.forms.mainForm.fields.role.value" ng-true-value="1" ng-false-value="0" aria-label="Role">
								{$ 'mainForm.role.'|fm:vm $}
							</md-checkbox>
                        </md-input-container>

		            </div>

		            <div class="modal-footer">
		                <div class="alert alert-danger" role="alert">
		                	Some error
		                </div>
		                
		                <md-button data-dismiss="modal" type="button">Close</md-button>
	    				<md-button class="md-raised md-primary">Save</md-button>
		            </div>
		        </div>
		    </form>
		</div>


	</div>
	
@stop
