<?php namespace App\Http\Controllers\back\manage;
use App\Http\Controllers\Controller as Controller;
use Auth;
use Route;
use App\Helpers\Tools as Tools;

class HomeController extends Controller {
    const VIEW_DIR = 'back/manage/home/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index(){
        $data = [
            'title' => 'Profile',
            'activeMenu' => Route::currentRouteName(),
        ];

        $user_data = [ 
            'email' => Auth::user()->email,
            'name' => Auth::user()->name
        ]; 
        $data['js_vars'] = [];
        $data['js_vars']['user_data'] = $user_data;
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = '';
        }
        return view(self::VIEW_DIR.'index', $data);
    }

}
