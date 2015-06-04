<?php namespace App\Http\Controllers\back\user;
use App\Http\Controllers\Controller as Controller;

class HomeController extends Controller {
    const VIEW_DIR = 'back/user/home/';

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
        return view(self::VIEW_DIR.'index');
    }

}
