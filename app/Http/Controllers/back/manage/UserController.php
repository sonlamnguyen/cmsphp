<?php namespace App\Http\Controllers\back\manage;

use Auth;
use Hash;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\User as User;
use App\Helpers\ResTools as ResTools;
use App\Helpers\Tools as Tools;

class UserController extends Controller {
    const VIEW_DIR = 'back/manage/user/';

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
            'title' => 'User',
            'activeMenu' => Route::currentRouteName(),
        ];
        $data['js_vars'] = [];
        $data['js_vars']['list_item'] = User::orderBy('created_at', 'desc')->get();
        if(count($data['js_vars'])){
            $data['js_vars'] = Tools::jencode($data['js_vars']);
        }else{
            $data['js_vars'] = 'null';
        }
        return view(self::VIEW_DIR.'index', $data);
    }

    public function profile(Request $request){
        $user  = Auth::user();
        $data = [ 
            'email' => $user->email,
            'name' => $user->name
        ];
        return ResTools::resObj($data);
    }

    public function editProfile(Request $request){
        $id = Auth::user()->id;
        $name = $request->input('name', null);
        $data = [
            'name' => $name
        ];
        return User::editProfile($id, $data);
    }

    public function editPassword(Request $request){
        $id = Auth::user()->id;
        $password = $request->input('password', null);
        $newPassword = $request->input('newPassword', null);
        return User::editPassword($id, $password, $newPassword);
    }

    public function obj(Request $request){
        $id = $request->input('id', null);
        return User::obj($id);
    }

    public function objs(Request $resuest){

    }

    public function add(Request $request){
        $name = $request->input('name', null);
        $email = $request->input('email', null);
        $password = $request->input('password', null);
        $role = $request->input('role', 0);
        $role = intval($role);
        if($role){
            $role = 'ADMIN';
        }else{
            $role = 'USER';
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ];
        return User::add($data);
    }

    public function edit(Request $request){
        $id = $request->input('id', null);
        $name = $request->input('name', null);
        $email = $request->input('email', null);
        $password = $request->input('password', null);
        $role = $request->input('role', 0);
        $role = intval($role);
        if($role){
            $role = 'ADMIN';
        }else{
            $role = 'USER';
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ];
        return User::edit($id, $data);
    }

    public function remove(Request $request){
        $id = $request->input('id', null);
        return User::remove($id);
    }
}
