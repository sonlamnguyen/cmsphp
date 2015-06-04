<?php namespace App\Http\Controllers\back\user;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use App\Helpers\Tools as Tools;

class PiController extends Controller {
    const VIEW_DIR = 'back/user/pi/';

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

    public function piCommand(Request $request){
        $subnetId = $request->input('subnetId', '');
        $RTUID = $request->input('RTUID', '');
        $AreaNo = $request->input('AreaNo', '');
        $SceneNo = $request->input('SceneNo', '');
        $ChannelNo = $request->input('ChannelNo', '');
        $Value = $request->input('Value', '');

        /*
        $result = [
            $subnetId, $RTUID, $AreaNo, $SceneNo, $ChannelNo, $Value
        ];
        return $result; 
        */

        $result = Tools::piController($subnetId, $RTUID, $AreaNo, $SceneNo, $ChannelNo, $Value);
        return $result;
        /*
        if($result['success'] == true){
            $this->info($result['message']);
        }else{
            $this->error($result['message']['common']);
        } 
        */
    }

}
