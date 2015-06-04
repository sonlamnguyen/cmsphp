<?php namespace App\Http\Controllers\back\user;

use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Helpers\ResTools as ResTools;
use App\Helpers\Tools as Tools;
use App\Device as Device;
use App\Area as Area;

class DeviceController extends Controller {
    const VIEW_DIR = 'back/user/device/';

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
        # $data['js_vars']['init_data'] = Tools::piInit();
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = 'null';
        }
        return view(self::VIEW_DIR.'index', $data);
    }

    public function info(Request $request){
        $subnet_id = $request->input('subnet_id', null);
        $rtu_id = $request->input('rtu_id', null);
        return Device::info($subnet_id, $rtu_id);
    }

    public function setValue(Request $request){
        $subnet_id = $request->input('subnet_id', null);
        $rtu_id = $request->input('rtu_id', null);
        $value = $request->input('value', null);
        return Device::setValue($subnet_id, $rtu_id, $value);
    }
}
