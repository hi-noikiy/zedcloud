<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
       return redirect('index/list')   ;     
    }

    /**
     * Logout authorization
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Auth::logout();
        return redirect('login');
    }
    
    /**
     * site
     */
    public function site()
    {
       $company_id =  company_id();
       
       //get merchant infomation
       $company = DB::table('companies')->where('id',$company_id)->first();
       
       $data = [
       		
       ];
       
        
     /*   if($process)
        $process->appsecret0 =  substr($process->appsecret,0,10) . '*********'; */
       return view('site',['data'=>$data,'company'=>$company]);
    }
    
    /**
     * 网站设置
     */
     public function site_set(Request $request)
    {
    	$rules = [
    			
    			'phone'=>'required|string|max:15',
    			'addr'=>'required|string|max:30',
    			'latitude'=>'required|numeric|max:1000', 
    			'longitude'=>'required|numeric|max:1000',    			
    			'appid'=>'required|string|max:50',
    			'appsecret'=>'required|string|max:50',
    	];
    	$this->validate($request,$rules);
    	
    	$company_id =  company_id();
    	$data = $request->all();
    	
 
    	
    	DB::table('companies')->where('id',$company_id)->update([
    			'telephone' =>$data['phone'],
    			'address' =>$data['addr'],
    			'latitude' =>$data['latitude'],
    			'longitude' =>$data['longitude']  ,
    			'appid' =>$data['appid'],
    			'appsecret' =>$data['appsecret']
    	]);
    	
    	return back()->with('alert-success','设置成功');
    } 
    
    public function process_set(Request $request)
    {
        $this->validate($request, [
                'key'=>'required|string',
                'secret'=>'required|string',
        ]);
        $company_id =  company_id();
        $process = DB::table('little_process')->where('company_id',$company_id)->first();
        if($process)
        {
            DB::table('little_process')->where('company_id',$company_id)->update(['appid'=>$request->key,'appsecret'=>$request->secret]);
        }
        else
        {
            DB::table('little_process')->where('company_id',$company_id)->insert(['company_id'=>$company_id,'appid'=>$request->key,'appsecret'=>$request->secret]);
        }
        return back()->with('alert-success','成功设置');
    }
    
    
    


}
