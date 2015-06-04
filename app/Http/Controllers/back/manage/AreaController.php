<?php namespace App\Http\Controllers\back\manage;

use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Area as Area;
use App\Helpers\ResTools as ResTools;
use App\Helpers\Tools as Tools;

class AreaController extends Controller {
    const VIEW_DIR = 'back/manage/area/';

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
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = 'null';
        }
        return view(self::VIEW_DIR.'index', $data);
    }

    public function obj(Request $request){
        $id = $request->input('id', null);
        return Area::obj($id);
    }

    public function objs(Request $resuest){

    }

    public function add(Request $request){
        $area = $request->input('area', null);
        $area_no = $request->input('area_no', null);
        $data = [
            'area' => $area,
            'area_no' => $area_no,
        ];
        return Area::add($data);
    }

    public function edit(Request $request){
        $id = $request->input('id', null);
        $area = $request->input('area', null);
        $area_no = $request->input('area_no', null);
        $data = [
            'area' => $area,
            'area_no' => $area_no,
        ];
        return Area::edit($id, $data);
    }

    public function remove(Request $request){
        $id = $request->input('id', null);
        return Area::remove($id);
    }
}
