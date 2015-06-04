<?php namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller as Controller;

class HomeController extends Controller {
    const VIEW_DIR = 'front/home/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        # $this->middleware('auth');

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
