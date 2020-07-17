<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserPermission;
use App\Setting;
use App\UserType;
use App\Menu;
use Auth;
use App\Helpers\Helper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use View;
use App\Contact;

class SettingController extends Controller
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
			$menu = Helper::menu($this->userRole, Auth::user()->created_by);
			$this->userPermission = Helper::getPermission($this->userRole, Auth::user()->created_by);
			view()->composer('admin.layouts.header', function($view) use($menu)
			{
				$view->with('menu', $menu);
			});
			return $next($request);
		});
    }
	
	   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index() {
		if(!in_array('setting',$this->userPermission)){
				return view('admin.not-allow');	
		}
        $setting = Setting::find(1);
        return view('admin.setting.edit')->withSetting($setting);
    }
	
	
	    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        try {
			$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['edit']=='No'){
						return view('admin.not-allow');	
					}
            $this->validate($request, [
                'site_name' => 'required',
				'logo' => 'mimes:jpeg,bmp,png',
            ]);
        } catch (\Laracasts\Validation\FormValidationException $e) {

            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }	
		$Setting = Setting::find($id);
        $Setting->site_name = $request->site_name;
        $Setting->site_url = $request->site_url;
		if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('/uploadimage');
            $image->move($imagePath, $name);
            $Setting->logo_log = $name;
        }
        $Setting->admin_email = $request->admin_email;
        $Setting->robot_email = $request->robot_email;
        $Setting->meta_description = $request->meta_description;
        $Setting->meta_key = $request->meta_key;
        $Setting->panel_color = $request->panel_color;
        $Setting->side_menu = $request->side_menu;
//        $Setting->created_at = date('Y-m-d h:i:s');
        $Setting->save();

        return back()->with('success', 'You have just updated one item');
    }

	public function adminMenu(Request $request){
		if(!in_array('menu',$this->userPermission)){
				return view('admin.not-allow');	
		}
		try 
		{
			$searchKey = (isset($request->all()['Search']))?$request->all()['Search']:'';
			
			$menulist = Menu::sortable()
						->where('Menu','LIKE','%'.$searchKey.'%')
						->paginate(10);
		} catch (\Laracasts\Validation\FormValidationException $e) {
	
			return Redirect::back()->withInput()->withErrors($e->getErrors());

		}		
		return view('admin.setting.menu',compact('menulist'));
	}
	
	public function addMenu(){
		$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
		if($menupermission['add']=='No' || !in_array('add-menu',$this->userPermission)){
				return view('admin.not-allow');	
		}
		$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['add']=='No'){
						return view('admin.not-allow');	
					}
		$pmenu = Menu::whereParent(0)->get();
		return view('admin.setting.add-menu', compact('pmenu'));
	}
	
	public function saveMenu(Request $request){
		 try {
            $this->validate($request, [
                'menu' => 'required'
				]);
			$menu = new Menu;
			$menu->menu = $request->menu;
			$menu->parent = $request->pmenu;
			$menu->link = $request->link;
			$menu->icon = $request->icon;
			$menu->position = $request->position;
			$menu->created_at = date('Y-m-d h:i:s');
			$menu->save();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return back()->with('success', 'You have just created one item');
		
	}
	
	public function showMenu($id){
		$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['edit']=='No'){
						return view('admin.not-allow');	
					}
		$pmenu = Menu::whereParent(0)->whereStatus(1)->get();
		$menu = Menu::whereId($id)->first();
		return view('admin.setting.edit-menu', compact('pmenu', 'menu'));
	}
	
	public function editMenu(Request $request, $id){
		try {
            $this->validate($request, [
                'menu' => 'required'
				]);
			$menu = Menu::find($id);
			$menu->menu = $request->menu;
			$menu->parent = $request->pmenu;
			$menu->link = $request->link;
			$menu->icon = $request->icon;
			$menu->position = $request->position;
			$menu->save();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return back()->with('success', 'You have just updated one item');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	 
	public function destroy($id) {
		try {
			$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['delete']=='No'){
						return view('admin.not-allow');	
					}
			$menu = Menu::find($id)->delete();
		} catch (\Laracasts\Validation\FormValidationException $e) {

			return $e->getErrors();
		}
		return redirect('admin/menu');
	}
	
	public function setPermission(){
		$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['add']=='No'){
						return view('admin.not-allow');	
					}
		$pmenu = Menu::whereParent(0)->whereStatus(1)->get();
                $groupUser = array();
                $userper = UserPermission::select('user_type')->whereCreatedBy(Auth::user()->id)->get();
				foreach($userper as $key){ $groupUser[] = $key->user_type; }				
                $usertype = UserType::whereNotIn('type', $groupUser)->get();
                $usertypelist =array();
                foreach($usertype as $index=> $value){
				   if($value['type'] != 'Super Admin' && $value['id'] != Auth::user()->usertype){
					  $usertypelist[$value['id']] = $value['type']; 
				   }                    
                }
        $getOwnMenu = UserPermission::select('menu','sub_menu')->where('user_type', Auth::user()->usertype)->whereCreatedBy(Auth::user()->created_by)->first();
		//print_r($getOwnMenu);die();
		$userMenu	= explode(',', $getOwnMenu->menu);
		$userSubMenu = explode(',', $getOwnMenu->sub_menu);
		$allMenu = array();
		foreach($pmenu as $menu){
			if(in_array($menu->id, $userMenu)){
					$data['menu'] =  $menu->menu;
					$data['menu_id'] =  $menu->id;
					$data['sub_menu'] =  Menu::select('menu','id')->whereIn('id', $userSubMenu)->whereParent($menu->id)->get();;
					$allMenu[] = $data;
			}
		
		}
		
		return view('admin.setting.add-permission', compact('allMenu','usertypelist'));
		
	}
	
	public function storePermission(Request $request){
		$menu = implode(',',$request->menu);
		$sub_menu = implode(',',$request->submenu);
		$query = new UserPermission;
		$query->menu = $menu;
		$query->sub_menu = $sub_menu;
		$query->user_type = $request->role;
		$query->created_by = Auth::user()->id;
		$query->add = ($request->add=='on')?1:0;
		$query->edit = ($request->edit=='on')?1:0;
		$query->delete = ($request->delete=='on')?1:0;
		$query->save();
		return back()->with('success', 'You have just created one item');
		
	}
	
		public function userPermission(Request $request){
			try 
			{
				$searchKey = (isset($request->all()['Search']))?$request->all()['Search']:'';
				$query 			= 	UserPermission::sortable();
									$query->where('user_type','LIKE','%'.$searchKey.'%');
									if(Auth::user()->usertype != 11){$query->whereCreatedBy(Auth::user()->id);}
									$query->OrderBy('created_at','Desc');
				$userPermission =	$query->paginate(20);
			
			} catch (\Laracasts\Validation\FormValidationException $e) {
				return Redirect::back()->withInput()->withErrors($e->getErrors());
			}		
			return view('admin.setting.permission-index',compact('userPermission'));	
		}
		
		public function showUserPermission($id){
		$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['edit']=='No'){
						return view('admin.not-allow');	
					}	
		$userPermission = UserPermission::find($id);
		$userPermission['menu'] = explode(",",$userPermission['menu']);	
		if($userPermission['user_type']=='Super Admin'){
		$userPermission['role'] = 1;
		}else if($userPermission['user_type']=='Admin'){
		$userPermission['role'] = 2;	
		}elseif($userPermission['user_type']=='Editor'){
		$userPermission['role'] = 4;	
		}elseif($userPermission['user_type']=='Publisher'){
		$userPermission['role'] = 5;	
		}
		$userPermission['sub_menu'] = explode(",",$userPermission['sub_menu']);	
		$pmenu = Menu::whereParent(0)->whereStatus(1)->get();
		$allMenu = array();
		foreach($pmenu as $menu){
			$data['menu'] =  $menu->menu;
			$data['menu_id'] =  $menu->id;
			$data['sub_menu'] =  Menu::select('menu','id')->whereParent($menu->id)->get();;
			$allMenu[] = $data;
		}
		
		return view('admin.setting.edit-permission', compact('userPermission','allMenu'));
			
		}
		public function editPermission(Request $request, $id){
			
		try {
			$menu = implode(',',$request->menu);
			$sub_menu = implode(',',$request->submenu);
			$query = UserPermission::find($id);
			$query->menu = $menu;
			$query->sub_menu = $sub_menu;
			//$query->user_type = $request->usertype;
			$query->add = ($request->add=='on')?1:0;
			$query->edit = ($request->edit=='on')?1:0;
			$query->delete = ($request->delete=='on')?1:0;
			$query->save();
        } catch (\Laracasts\Validation\FormValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        return back()->with('success', 'You have just updated one item');	
			
		}
		
		public function destroyPermission($id) {
		try {
			$menupermission = Helper::getPerMenu(Auth::user()->usertype, Auth::user()->created_by);
					if($menupermission['delete']=='No'){
						return view('admin.not-allow');	
					}
			$menu = UserPermission::find($id)->delete();
		} catch (\Laracasts\Validation\FormValidationException $e) {

			return $e->getErrors();
		}
		return redirect('admin/user-permission');
	}
        public function setRoleName($role){
		    if($role=='Super Admin'){
		        return 1;
		    }else if($role=='Admin'){
		        return 2;
		    }else if($role=='Customer'){
		        return 3;
		    }else if($role=='Editor'){
		        return 4;
		    }else if($role=='Publisher'){
		        return 5;
		    }
		    
		}
		
	/**
	 * Update the specified status resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	 
	public function changeStatus(Request $request) {
		$id = $request->id;
		$val = $request->status;
		try {
			$model = Menu::find($id);
			$model->status = $val;
			$model->save();
			return response()->json($id);
		} catch (\Laracasts\Validation\FormValidationException $e) {
			return $e->getErrors(); 
		}
	}

	public function getContactInfo(){

		if(!in_array('contact',$this->userPermission)){
			return view('admin.not-allow');	
		}
		$query	=	Contact::sortable()->orderBy('id', 'DESC')->paginate(20);
		return view('admin.setting.contact',compact('query'));


	}
        public function getbtncolor() {
             $setting = Setting::find(1);
             return response()->json(['btncolor' => $setting->panel_color]);
        }
		
}
