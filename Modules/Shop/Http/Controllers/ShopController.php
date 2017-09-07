<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use Storage;

class ShopController extends Controller
{
    function __construct(){
        
        
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        $company = DB::table('companies')->whereNull('deleted_at')->paginate(20);
        
        return view('shop::index',['companies'=>$company]);
    }
    
    
    /**
     * 网站设置
     */
    public function store(Request $request)
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        
        
        $rules = [
            'name'=>'required|string|max:50',
            'phone'=>'required|string|max:15',
            'addr'=>'required|string|max:30',
            'latitude'=>'required|numeric|max:1000',
            'longitude'=>'required|numeric|max:1000',
            'appid'=>'required|string|max:50',
            'appsecret'=>'required|string|max:50',
        ];
        validator($request->all(),$rules);
         
        $company_id =  company_id();
        $data = $request->all();
        
        $disk      = Storage::disk('qiniu');
        $dir       = "shop/cover";
        $cover_url = $disk->put($dir, $request->file('cover'));
        
    
         
        DB::table('companies')->insert([
        'telephone' =>$data['phone'],
        'address' =>$data['addr'],
        'latitude' =>$data['latitude'],
        'longitude' =>$data['longitude']  ,
        'appid' =>$data['appid'],
        'appsecret' =>$data['appsecret'],
        'name' =>$data['name'],
        'logo'=>$cover_url
        ]);
         
        return back()->with('alert-success','成功');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        return view('shop::create');
    }

 
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        
        return view('shop::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($shop_id)
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        
        $shop = DB::table('companies')->where('id',$shop_id)->first();
        if(!$shop){
            return back()->with('alert-danger','fail');
        }
        $user = DB::table('users')->where('company_id',$shop_id)->first();
        if(!$user)
        {
            $user = [];
        }
 
        return view('shop::edit',['company'=>$shop,'user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        
        
        $rules = [
            'name'=>'required|string|max:50',
            'phone'=>'required|string|max:15',
            'addr'=>'required|string|max:30',
            'latitude'=>'required|numeric|max:1000',
            'longitude'=>'required|numeric|max:1000',
            'appid'=>'required|string|max:50',
            'appsecret'=>'required|string|max:50',
            'username'=>'required|string|max:50',
            'adminkey'=>'required|string|max:50',
        ];
        validator($request->all(),$rules);
         
        $company_id =  company_id();
        $data = $request->all();
        
        
        $data2 =  [
            'telephone' =>$data['phone'],
            'address' =>$data['addr'],
            'latitude' =>$data['latitude'],
            'longitude' =>$data['longitude']  ,
            'appid' =>$data['appid'],
            'appsecret' =>$data['appsecret'],
            'name' =>$data['name'],
        ];
        if($request->file('cover')){
            $disk      = Storage::disk('qiniu');
            $dir       = "shop/cover";
            $cover_url = $disk->put($dir, $request->file('cover'));
            $data2['logo'] = $cover_url;
        }

        DB::table('companies')->where('id',$request->com_id)->update($data2);
        
        if(empty($request->user_id))
        {
            DB::table('users')->insert(['key'=>$data['adminkey'],'username'=>$data['username'],'password'=>bcrypt($data['adminkey']),'company_id'=>$request->com_id]);
        }
        else{
            DB::table('users')->where('id',$request->user_id)->update(['key'=>$data['adminkey'],'username'=>$data['username'],'password'=>bcrypt($data['adminkey'])]);
        }

        
         
        return back()->with('alert-success','成功');
        
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($shop_id)
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
        
        $rs = DB::table('companies')->where('id',$shop_id)->update(['status'=>1]);
        if($rs)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','失败');
        
    }
    
    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function undestroy($shop_id)
    {
        $company_id = company_id();
        if($company_id != 1)
        {
            exit('非法入侵');
        }
    
        $rs = DB::table('companies')->where('id',$shop_id)->update(['status'=>0]);
        if($rs)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','失败');
    
    }
}
