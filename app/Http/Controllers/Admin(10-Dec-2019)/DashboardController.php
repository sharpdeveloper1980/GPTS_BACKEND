<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Helper;
use DB;
use Auth;
use App\Order;
use App\Product;
use App\Student;
use App\TteUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use View;
class DashboardController extends Controller
{
	use AuthenticatesUsers;
	private $userRole;
	private $userPermission;
	public function __construct(){
			View::composers([
			'App\Composers\DefaultComposer' => ['admin.layouts.header', 'admin.layouts.footer', 'emails.header']
			]);
			$this->middleware(function ($request, $next) {
				$this->userRole = Auth::user()->usertype;
				$this->userPermission = Helper::getPermission($this->userRole, Auth::user()->created_by);
				$menu = Helper::menu($this->userRole, Auth::user()->created_by);
				view()->composer('admin.layouts.header', function($view) use($menu)
				{
					$view->with('menu', $menu);
				});
				return $next($request);
			});
        
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$totalStudent 		= 	User::whereUsertype(1)->count();
		$currentStudent 	= 	User::whereUsertype(1)->limit(8)->orderBy('id', 'DESC')->get();
		
		$totalSchool 		= 	User::whereUsertype(4)->count();

		$tteResult	 		=   User::select('users.*');
								$tteResult->Join('tte_users', 'tte_users.student_id', '=', 'users.id');
								$tteResult->where('users.status',1);
								$tteResult->orderBy('id','DESC');
		$tteResult   		=  	$tteResult->get();

		$result	 			=   User::Join('tte_users', 'tte_users.student_id', '=', 'users.id');
								$result->orderBy('name','ASC');

		$totalTTEStudent	= 	$result->count();
        return view('admin.dashboard', compact('totalStudent', 'totalTTEStudent', 'totalSchool', 'currentStudent', 'tteResult'));
    }

}
