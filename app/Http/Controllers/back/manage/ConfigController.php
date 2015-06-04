<?php namespace App\Http\Controllers\back\manage;
use App\Http\Controllers\Controller as Controller;

class ConfigController extends Controller {
    const VIEW_DIR = 'back/manage/config/';

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
