@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!};
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	
	<div flex ng-controller="Area as vm">
		
		<table class="list-table" ng-show="vm.model.vars.listItem | count">
			<tr ng-repeat="item in vm.model.vars.listItem">
				<td class="row-content">
					{$ item.area $}
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
			&nbsp; No area exist.
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
                            <label>{$ 'mainForm.area.'|fm:vm $}</label>
                            <input name="area" ng-model="vm.model.forms.mainForm.fields.area.value" required>
                            <div ng-messages="mainForm.area.$error" ng-if="mainForm.area.$touched">
                                <div ng-message="required">Area is required.</div>
                            </div>
                            <div ng-messages="mainForm.area.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.area.error $}
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container>
                            <label>{$ 'mainForm.area_no.'|fm:vm $}</label>
                            <input name="area_no" ng-model="vm.model.forms.mainForm.fields.area_no.value" required>
                            <div ng-messages="mainForm.area_no.$error" ng-if="mainForm.area_no.$touched">
                                <div ng-message="required">Area is required.</div>
                            </div>
                            <div ng-messages="mainForm.area_no.$error">
                                <div ng-message="custom">
                                	{$ vm.model.forms.mainForm.fields.area_no.error $}
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
