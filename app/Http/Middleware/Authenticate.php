<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Helpers\ResTools as ResTools;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		if ($this->auth->guest()){
			if ($request->ajax()){
				# return response('Unauthorized.', 401);
				return response(ResTools::resErr('You must to login to perform this function.', ResTools::$ERROR_CODES['UNAUTHORIZED']), 200);
			}else{
				if($request->is('back/manage/*') || $request->is('back/manage')){
					return redirect()->guest('back/manage/login');
				}else{
					return redirect()->guest('back/user/login');
				}
			}
		}

		return $next($request);
	}

}
