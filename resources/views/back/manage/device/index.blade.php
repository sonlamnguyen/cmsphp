@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!};
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	
	<div flex ng-controller="Device as vm">
		
		<table class="list-table" ng-show="vm.model.vars.listItem | count">
			<tr ng-repeat="item in vm.model.vars.listItem">
				<td class="row-content">
					{$ item.device_name $}
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
			&nbsp; No device exist.
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
		            	<div>
                        	<selectize config="vm.CUtils.selectizeDefaultConf" options="vm.model.refs.list_area"  ng-model="vm.model.forms.mainForm.fields.area_id.value"></selectize>
                        </div>
	            		<div>
                        	<selectize config="vm.CUtils.selectizeDefaultConf" options="vm.model.refs.types"  ng-model="vm.model.forms.mainForm.fields.device_type.value"></selectize>
                        </div>

						<div>
                        	<selectize config="vm.CUtils.selectizeDefaultConf" options="vm.model.refs.controlTypes"  ng-model="vm.model.forms.mainForm.fields.control_type.value"></selectize>
                        </div>

                        <div>
                        	<selectize config="vm.CUtils.selectizeDefaultConf" options="vm.model.refs.channels"  ng-model="vm.model.forms.mainForm.fields.channel_id.value"></selectize>
                        </div>

						<md-input-container>
                            <label>{$ 'mainForm.device_name.'|fm:vm $}</label>
                            <input name="device_name" ng-model="vm.model.forms.mainForm.fields.device_name.value" required>
                            <div ng-messages="mainForm.device_name.$error" ng-if="mainForm.device_name.$touched">
                                <div ng-message="required">Device is required.</div>
                            </div>
                            <div ng-messages="mainForm.device_name.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.device_name.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.subnet_id.'|fm:vm $}</label>
                            <input type="number" name="subnet_id" ng-model="vm.model.forms.mainForm.fields.subnet_id.value" required>
                            <div ng-messages="mainForm.subnet_id.$error" ng-if="mainForm.subnet_id.$touched">
                                <div ng-message="required">Device is required.</div>
                            </div>
                            <div ng-messages="mainForm.subnet_id.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.subnet_id.error $}
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container>
                            <label>{$ 'mainForm.rtu_id.'|fm:vm $}</label>
                            <input type="number" name="rtu_id" ng-model="vm.model.forms.mainForm.fields.rtu_id.value" required>
                            <div ng-messages="mainForm.rtu_id.$error" ng-if="mainForm.rtu_id.$touched">
                                <div ng-message="required">Device is required.</div>
                            </div>
                            <div ng-messages="mainForm.rtu_id.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.rtu_id.error $}
                                </div>
                            </div>
                        </md-input-container>
						
                        <!--
                        <md-input-container>
                            <label>{$ 'mainForm.device_type.'|fm:vm $}</label>
                            <input type="number" name="device_type" ng-model="vm.model.forms.mainForm.fields.device_type.value" required>
                            <div ng-messages="mainForm.device_type.$error" ng-if="mainForm.device_type.$touched">
                                <div ng-message="required">Device is required.</div>
                            </div>
                            <div ng-messages="mainForm.device_type.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.device_type.error $}
                                </div>
                            </div>
                        </md-input-container>
						-->
						
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
