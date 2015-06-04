@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!};
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	
	<div flex ng-controller="Scene as vm">
		
		<table class="list-table" ng-show="vm.model.vars.listItem | count">
			<tr ng-repeat="item in vm.model.vars.listItem">
				<td class="row-content">
					{$ item.scene_name $}
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
			&nbsp; No scene exist.
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
                            <!--
                            <label>{$ 'mainForm.device_id.'|fm:vm $}</label>
                            -->
                            <div>
                            <selectize config="vm.CUtils.selectizeDefaultConf" options="vm.model.refs.list_device"  ng-model="vm.model.forms.mainForm.fields.device_id.value"></selectize>
                            </div>
                            <!--
                            <input name="device_id" ng-model="vm.model.forms.mainForm.fields.device_id.value" required>
                            <div ng-messages="mainForm.device_id.$error" ng-if="mainForm.device_id.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.device_id.$error">
                                <div ng-message="custom">
                                    {$ vm.model.forms.mainForm.fields.device_id.error $}
                                </div>
                            </div>
                            -->
                        </div>


						<md-input-container>
                            <label>{$ 'mainForm.scene_name.'|fm:vm $}</label>
                            <input name="scene_name" ng-model="vm.model.forms.mainForm.fields.scene_name.value" required>
                            <div ng-messages="mainForm.scene_name.$error" ng-if="mainForm.scene_name.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.scene_name.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.scene_name.error $}
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container>
                            <label>{$ 'mainForm.scene_no.'|fm:vm $}</label>
                            <input name="scene_no" ng-model="vm.model.forms.mainForm.fields.scene_no.value" required>
                            <div ng-messages="mainForm.scene_no.$error" ng-if="mainForm.scene_no.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.scene_no.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.scene_no.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_1_value.'|fm:vm $}</label>
                            <input name="channel_1_value" ng-model="vm.model.forms.mainForm.fields.channel_1_value.value">
                            <div ng-messages="mainForm.channel_1_value.$error" ng-if="mainForm.channel_1_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_1_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_1_value.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_2_value.'|fm:vm $}</label>
                            <input name="channel_2_value" ng-model="vm.model.forms.mainForm.fields.channel_2_value.value">
                            <div ng-messages="mainForm.channel_2_value.$error" ng-if="mainForm.channel_2_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_2_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_2_value.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_3_value.'|fm:vm $}</label>
                            <input name="channel_3_value" ng-model="vm.model.forms.mainForm.fields.channel_3_value.value">
                            <div ng-messages="mainForm.channel_3_value.$error" ng-if="mainForm.channel_3_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_3_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_3_value.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_4_value.'|fm:vm $}</label>
                            <input name="channel_4_value" ng-model="vm.model.forms.mainForm.fields.channel_4_value.value">
                            <div ng-messages="mainForm.channel_4_value.$error" ng-if="mainForm.channel_4_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_4_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_4_value.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_5_value.'|fm:vm $}</label>
                            <input name="channel_5_value" ng-model="vm.model.forms.mainForm.fields.channel_5_value.value">
                            <div ng-messages="mainForm.channel_5_value.$error" ng-if="mainForm.channel_5_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_5_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_5_value.error $}
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container>
                            <label>{$ 'mainForm.channel_6_value.'|fm:vm $}</label>
                            <input name="channel_6_value" ng-model="vm.model.forms.mainForm.fields.channel_6_value.value">
                            <div ng-messages="mainForm.channel_6_value.$error" ng-if="mainForm.channel_6_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_6_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_6_value.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_7_value.'|fm:vm $}</label>
                            <input name="channel_7_value" ng-model="vm.model.forms.mainForm.fields.channel_7_value.value">
                            <div ng-messages="mainForm.channel_7_value.$error" ng-if="mainForm.channel_7_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_7_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_7_value.error $}
                                </div>
                            </div>
                        </md-input-container>

						<md-input-container>
                            <label>{$ 'mainForm.channel_8_value.'|fm:vm $}</label>
                            <input name="channel_8_value" ng-model="vm.model.forms.mainForm.fields.channel_8_value.value">
                            <div ng-messages="mainForm.channel_8_value.$error" ng-if="mainForm.channel_8_value.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.channel_8_value.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.channel_8_value.error $}
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container>
                            <label>{$ 'mainForm.status.'|fm:vm $}</label>
                            <input name="status" ng-model="vm.model.forms.mainForm.fields.status.value">
                            <div ng-messages="mainForm.status.$error" ng-if="mainForm.status.$touched">
                                <div ng-message="required">Scene is required.</div>
                            </div>
                            <div ng-messages="mainForm.status.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.status.error $}
                                </div>
                            </div>
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
