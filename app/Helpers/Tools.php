<?php namespace App\Helpers;
use DateTime;
use App\Helpers\ResTools as ResTools;
class Tools {
    public static function current_timestamp(){
        $date = new DateTime();
        return $date->getTimestamp();
    }

    public static function piController($subnetId, $RTUID, $AreaNo=null, $SceneNo=null, $ChannelNo=null, $Value=null){
    	if(!config('params.call_device')) return null;
	/* Get the port for the WWW service. */
		# return ResTools::resObj(null, 'success');
		# var_dump('here');die;

		/*
		if($AreaNo !== '' && $SceneNo !== ''){
			var_dump('case 1 -> Scene');
		}else if($ChannelNo !== '' && $Value !== ''){
			var_dump('case 2 -> Single');
		}
		die;
		*/

		$service_port = 1234;
		$address = gethostbyname('localhost');
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

		if ($socket === false) {
			$error = "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
			return ResTools::resErr($error);
		}
		$result = socket_connect($socket, $address, $service_port);

		if ($result === false) {
			$error = "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
			return ResTools::resErr($error);
		}
		$out = '';
		if($AreaNo !== '' && $SceneNo !== ''){
			//Scene control
			# var_dump('case 1');die;
			$in = 'SceneControl '.$subnetId.' '.$RTUID.' '.$AreaNo.' '.$SceneNo;
			socket_write($socket, $in, strlen($in));
			$out = socket_read($socket, 2048);
		}else if($ChannelNo !== '' && $Value !== ''){
			# var_dump('case 2');die;
			//Single Channel Control
			$in = 'SingleChannelControl '.$subnetId.' '.$RTUID.' '.$ChannelNo.' '.$Value;
			socket_write($socket, $in, strlen($in));
			$out = socket_read($socket, 2048);
		}

		# socket_close($socket);
		return ResTools::resObj(trim($out), 'success');
    }

    public static function piInit(){
    	return [
    		'3' => 70,
    		'4' => 0,
    		'5' => 0,
    		'6' => 100,
    		'7' => 100,
    	];
    }

    public static function jencode($data){
		return json_encode($data, JSON_HEX_QUOT);
    }

}
