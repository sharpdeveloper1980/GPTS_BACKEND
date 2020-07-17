<?php 
namespace App\Composers;
use App\Blocks;
use App\Setting;
use URL;

class DefaultComposer
{

    public function compose($view)
    {
		$url = url()->full();
                $base_url = URL::to('/');
                $curr_path = str_replace($base_url,'',$url);
                $slug = array();
              $url =explode("/",$curr_path);
              $slug = 'home'; 
                   
		//$getHeader = Blocks::where(['identifier' => 'home-block-header'])->where(['status' => 1])->first();
		$getLogo = Setting::where(['id' => 1])->first();

		//$getFooter = Blocks::where(['identifier' => 'home-block-footer'])->where(['status' => 1])->first();
		$setting = Setting::first();
        $view->with('headerMenu', $slug)->with('logo', $getLogo)->with('setting', $setting);
		
    }
}