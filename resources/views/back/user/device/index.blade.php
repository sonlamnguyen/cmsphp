@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!};
		$(function () {
			setTimeout(function(){
				$('.collapse-card').paperCollapse();
			}, 200);
		})
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	
	<div flex ng-controller="Device as vm">
		
		<div class="collapse-card" ng-repeat="device_type in vm.model.refs.types">
			<div class="collapse-card__heading">
				<div class="collapse-card__title">
					{$ device_type.title $}
				</div>
			</div>
			<div class="collapse-card__body">
				<!-- Body Text -->
				<div ng-repeat="area in vm.model.vars.areas" ng-show="area.id|checkExistByArea:vm.model.vars.listItem:device_type.id">
					<md-list>
						<md-list-item class="list-border" ng-repeat="device in vm.model.vars.listItem | filterBy:'area_id':area.id | filterBy:'device_type':device_type.id" ng-click="vm.toggleModal('changingForm', true, device.subnet_id + '.' + device.rtu_id)">
							<p>
								<b>{$ area.area $}. </b> {$ device.device_name $}						
							</p>
							<p ng-show="!(device.control_type | checkNotControl)">Value: <span>{$ device.value | checkControlType : device.control_type $}</span></p>
						</md-list-item>
					</md-list>
				</div>
			</div>
		</div>

		<!-- Profile Modal -->
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <form class="modal-dialog" name="changingForm">
		        <div class="modal-content">

					<div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">{$ vm.model.vars.modalName $}</h4>
		            </div>

		            <div class="modal-body" style="text-align: center">
		            	<h2 class="md-title">{$ vm.model.vars.deviceName $}</h2><br/>
		            	
		            	<div ng-show="vm.model.vars.controlType==1">
			            	<input type="checkbox" name="my-checkbox" checked>
		            	</div>

		            	<div ng-show="vm.model.vars.controlType==2">
		            		<div class="row">
		            			<div class="col-xs-6" style="text-align: left">
		            				<button class="btn btn-primary" ng-click="vm.model.acts.toggleDimmer(true)">On</button>
		            			</div>
		            			<div class="col-xs-6" style="text-align: right">
		            				<button class="btn btn-warning" ng-click="vm.model.acts.toggleDimmer(false)">Off</button>
		            			</div>
		            		</div>
			            	<input type="text" value="75" class="dial">
		            	</div>
		            </div>

		            <div class="modal-footer">
		                <div class="alert alert-danger" role="alert">
		                	Some error
		                </div>
		                
		                <md-button data-dismiss="modal" type="button">Close</md-button>
		            </div>
		        </div>
		    </form>
		</div>


	</div>
	
@stop
