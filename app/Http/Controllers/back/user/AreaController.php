<?php namespace App\Http\Controllers\back\user;

use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Helpers\ResTools as ResTools;
use App\Helpers\Tools as Tools;
use App\Area as Area;
use App\Device as Device;

class AreaController extends Controller {
    const VIEW_DIR = 'back/user/area/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the area.
     *
     * @return Response
     */
    public function index(){
        $data = [
            'title' => 'Area',
            'activeMenu' => Route::currentRouteName(),
        ];
        $data['js_vars'] = [];
        $data['js_vars']['list_item'] = Area::orderBy('created_at', 'desc')->get();
        $data['js_vars']['devices'] = Device::orderBy('created_at', 'desc')->get();
        $data['js_vars']['init_data'] = Tools::piInit();
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = 'null';
        }
        return view(self::VIEW_DIR.'index', $data);
    }
}
