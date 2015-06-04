<?php namespace App\Http\Controllers\back\manage;

use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Helpers\ResTools as ResTools;
use App\Helpers\Tools as Tools;
use App\Device as Device;
use App\Area as Area;

class DeviceController extends Controller {
    const VIEW_DIR = 'back/manage/device/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the device.
     *
     * @return Response
     */
    public function index(){
        $data = [
            'title' => 'Device',
            'activeMenu' => Route::currentRouteName(),
        ];
        $data['js_vars'] = [];
        $data['js_vars']['list_item'] = Device::orderBy('created_at', 'desc')->get();
        $data['js_vars']['areas'] = Area::orderBy('created_at', 'desc')->get();
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = 'null';
        }
        return view(self::VIEW_DIR.'index', $data);
    }

    public function obj(Request $request){
        $id = $request->input('id', null);
        return Device::obj($id);
    }

    public function objs(Request $resuest){

    }

    public function add(Request $request){
        $area_id = $request->input('area_id', null);
        $subnet_id = $request->input('subnet_id', null);
        $rtu_id = $request->input('rtu_id', null);
        $device_type = $request->input('device_type', null);
        $control_type = $request->input('control_type', null);
        $device_name = $request->input('device_name', null);
        $channel_id = $request->input('channel_id', null);
        $data = [
            'area_id' => $area_id,
            'subnet_id' => $subnet_id,
            'rtu_id' => $rtu_id,
            'device_type' => $device_type,
            'control_type' => $control_type,
            'device_name' => $device_name,
            'channel_id' => $channel_id,
        ];
        return Device::add($data);
    }

    public function edit(Request $request){
        $id = $request->input('id', null);
        $area_id = $request->input('area_id', null);
        $subnet_id = $request->input('subnet_id', null);
        $rtu_id = $request->input('rtu_id', null);
        $device_type = $request->input('device_type', null);
        $control_type = $request->input('control_type', null);
        $device_name = $request->input('device_name', null);
        $channel_id = $request->input('channel_id', null);
        $data = [
            'area_id' => $area_id,
            'subnet_id' => $subnet_id,
            'rtu_id' => $rtu_id,
            'device_type' => $device_type,
            'control_type' => $control_type,
            'device_name' => $device_name,
            'channel_id' => $channel_id,
        ];
        return Device::edit($id, $data);
    }

    public function remove(Request $request){
        $id = $request->input('id', null);
        return Device::remove($id);
    }
}
