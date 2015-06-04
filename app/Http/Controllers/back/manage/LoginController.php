<?php namespace App\Http\Controllers\back\manage;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\User as User;

class LoginController extends Controller {
    const VIEW_DIR = 'back/manage/login/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        # $this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index(){
        $data = [];
        $data['title'] = 'Login';
        $data['message'] = '';
        return view(self::VIEW_DIR.'login', $data);
    }

    public function authenticate(Request $request){
        # Only allow user with role NOT EQUAL ADMIN

        $data = [];
        $data['title'] = 'Login';
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $user = Auth::user();
            if($user->role !== 'USER'){
                return redirect()->route('backManageIndex');
            }
            Auth::logout();
            $data['message'] = 'You are not enough primitive to log in this zone!';
        }else{
            $data['message'] = 'Wrong username or password!';
        }
        return view(self::VIEW_DIR.'login', $data);
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('backManageLoginForm');
    }
}
