<?php namespace App\Http\Controllers\back\user;

use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Scene as Scene;
use App\Device as Device;
use App\Helpers\ResTools as ResTools;
use App\Helpers\Tools as Tools;

class SceneController extends Controller {
    const VIEW_DIR = 'back/user/scene/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the scene.
     *
     * @return Response
     */
    public function index(){
        $data = [
            'title' => 'Scene',
            'activeMenu' => Route::currentRouteName(),
        ];
        $data['js_vars'] = [];
        $data['js_vars']['list_item'] = Scene::orderBy('created_at', 'desc')->get();
        $data['js_vars']['devices'] = Device::orderBy('created_at', 'desc')->get();
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = 'null';
        }
        return view(self::VIEW_DIR.'index', $data);
    }

    public function applyScene(Request $request){
        $id = $request->input('id', null);
        return Scene::applyScene($id);
    }

}
