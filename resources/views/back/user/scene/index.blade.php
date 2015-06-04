@extends('back.manage.base_back_manage')

@section('title', $title)

@section('content')
    <script type="text/javascript">
		var js_vars = {!! $js_vars !!};
	</script>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	
	<div flex ng-controller="Scene as vm">
		
        <md-list ng-show="vm.model.vars.listItem | count">
            <md-list-item class="list-border" ng-repeat="item in vm.model.vars.listItem" ng-click="vm.model.acts.applyScene(item.id)">
                <p>
                    {$ item.scene_name $}                       
                </p>
            </md-list-item>
        </md-list>

		<h2 class="md-display-1" ng-show="!(vm.model.vars.listItem | count)">
			&nbsp; No scene exist.
		</h2>

	</div>
	
@stop
