<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $company_id = company_id();
        
        $company = DB::table('companies')->select(['notice','logo','shop_introduce'])->where('id',$company_id)->first();
         $albums = DB::table('albums')
                    ->select('albums.id','albums.name as a_name','cover')

                    ->whereNull('albums.deleted_at')
                    ->where('company_id',$company_id)
                    ->where('hot',1)
                    ->get();
         
        foreach($albums as $album)
        {
            $album->_id = hash_encode($album->id);
        }
        
       

        //最多只允许五个轮播图
        $lunbos= DB::table('app_lunbo')->where('company_id',company_id())->where('type',1)->get();
        foreach($lunbos as $lunbo)
        {
            $lunbo->_id = hash_encode($lunbo->id);
            $lunbo->link = hash_encode($lunbo->link);
        }
        
      
        
        
        $us = DB::table('app_abortus')->where('company_id',company_id())->first();
        if($us){
            $us->_id = hash_encode($us->id);
        }
        
       
       
        return view('index::index',['company'=>$company,'us'=>$us,'lunbos'=>$lunbos,'albums'=>$albums]);
    }

  
    public function create_abort()
    {
        return view('index::create_abort');
    }
    
    
    public function notice_create(Request $request){
        $notice = $request->input('notice');
        $rs = DB::table('companies')->where('id',company_id())->update(['notice'=>$notice]);
        if($rs)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    }
    
    
    public function about_create(Request $request){
        $file = $request->file('shop');
        $intro = $request->input('introduce');
        $data = [];
     
        $disk      = Storage::disk('qiniu');
        $dir       = company_id()."/lunbo";
        $photo_url = $disk->put($dir, $file);
        if(!empty($file))
        {
            $data['logo'] =$photo_url;
        }
        $data['shop_introduce'] = $intro;
        
        $rs = DB::table('companies')->where('id',company_id())->update($data);
        if($rs)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','服务器繁忙');
        
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function lunbo_create(Request $request)
    {
       
        $num = DB::table('app_lunbo')->where('company_id',company_id())->where('type',1)->count();
        if($num >= 3)
        {
            return back()->with('alert-danger','轮播图不能多于3个');
        }
        
        $file = $request->file('lunbo');
        if(empty($file))
        {
            return back()->with('alert-danger','文件不能为空');
        }
        
        $disk      = Storage::disk('qiniu');
        $dir       = company_id()."/lunbo";
        $photo_url = $disk->put($dir, $file);
        
        
        
        //存入数据库
        $data = ['link_type'=>1,'link'=>1,'company_id'=>company_id(),'imgurl'=>$photo_url,'created_at'=>date('Y-m-d H:i:s',time()),'type'=>1];
        $add = DB::table('app_lunbo')->insert($data);
        if($add)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    }
    
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function gift_create(Request $request)
    {
    	$validator = validator($request->all(),
    			[
    					'name'=> 'required|string',
    					'price'=>'required|numeric',
    					'intro'=>'required|string',
    					'content2'=>'required|string'
    			]
    	);
    	if($validator->fails())
    	{
    		return back()->withErrors($validator)->withInput();
    	}
    
    	//最多只允许五个轮播图
    	$num = DB::table('gift')->where('company_id',company_id())->first();
    	if($num)
    	{
    		return back()->with('alert-danger','大礼包已经创建，请对其进行修改');
    	}

    	//存入数据库
    	$data = ['name'=>$request->name,'price'=>$request->price,'company_id'=>company_id(),'introduce'=>$request->intro,'created_at'=>date('Y-m-d H:i:s',time()),'detail'=>$request->content2];
    	$add = DB::table('gift')->insert($data);
    	if($add)
    	{
    		return back()->with('alert-success','成功');
    	}
    	return back()->with('alert-danger','服务器繁忙');
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function gift_update(Request $request)
    {
    	$validator = validator($request->all(),
    			[
    					'name2'=> 'required|string',
    					'price2'=>'required|numeric',
    					'intro2'=>'required|string',
    					'content3'=>'required|string'
    			]
    	);
    	if($validator->fails())
    	{
    		return back()->withErrors($validator)->withInput();
    	}
  
    	//存入数据库
    	$data = ['name'=>$request->name2,'price'=>$request->price2,'introduce'=>$request->intro2,'update_at'=>date('Y-m-d H:i:s',time()),'detail'=>$request->content3];
    	$add = DB::table('gift')->where('company_id',company_id())->update($data);
    	if($add)
    	{
    		return back()->with('alert-success','成功');
    	}
    	return back()->with('alert-danger','服务器繁忙');
    }
    
    
    
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function us_create(Request $request)
    {
        $validator = validator($request->all(),
                [
                        'content'=> 'required|string',
                ]
        );
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        $data = ['content'=>$request->content,'company_id'=>company_id()];
        //最多只允许1个轮播图
        $num = DB::table('app_abortus')->where('company_id',company_id())->first();
        if($num)
        {
            $add = DB::table('app_abortus')->where('company_id',company_id())->update($data);
            return back()->with('alert-success','成功');
        }
    
    /*     $file = $request->file('pic');
        if(empty($file))
        {
            return back()->with('alert-danger','文件不能为空');
        }
    
        $disk      = Storage::disk('qiniu');
        $dir       = company_id()."/pic";
        $photo_url = $disk->put($dir, $file); */
    
    
    
        //存入数据库
       
        $add = DB::table('app_abortus')->insert($data);
        if($add)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    }
    
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function us_edit(Request $request)
    {
        $validator = validator($request->all(),
                [
                        'title'=> 'required|string',
                        'content'=> 'required|string',
                ],
                [
                        
                ]
        );
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
    
        //最多只允许1个轮播图
        $us = DB::table('app_abortus')->where('company_id',company_id())->first();
        if(!$us)
        {
            return back()->with('alert-danger','请求错误');
        }
        $data = [];
        
        $file = $request->file('pic');
        if($file)
        {
            $disk      = Storage::disk('qiniu');
            $dir       = company_id()."/pic";
            $photo_url = $disk->put($dir, $file);
            $data['imgurl'] = $photo_url;
        }
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $rs = DB::table('app_abortus')->where('company_id',company_id())->update($data);
        if($rs)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    }
    

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function lunbo_update(Request $request)
    {
        $validator = validator($request->all(),
                [
                    'link_type'=> 'required',
                    'url'=> 'required|string',
                    '_lunbo_id'=> 'required|string',
                ],
                []
        );
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        
        $lunbo_id = hash_decode($request->_lunbo_id);
        
        
        $data = [];
        $file = $request->file('lunbo');
        if($file)
        {
            $disk      = Storage::disk('qiniu');
            $dir       = company_id()."/pic";
            $photo_url = $disk->put($dir, $file);
            $data['imgurl'] = $photo_url;
        }
        
        $data['link_type'] = $request->link_type;
        $data['link'] = hash_decode($request->url);

        $lunbo = DB::table('app_lunbo')->where('id',$lunbo_id)->update($data);
        if($lunbo)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','系统异常');
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function lunbo_edit($_lunbo_id)
    {
        $lunbo_id = hash_decode($_lunbo_id);
        $company_id = company_id();
        $lunbo = DB::table('app_lunbo')->where('id',$lunbo_id)->first();
        if(!$lunbo)
        {
            return back()->with('alert-danger','系统异常');
        }
        return view('index::lunbo_edit');
    }
    
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function lunbo_remove($_lunbo_id)
    {
        $lunbo_id = hash_decode($_lunbo_id);
        $company_id = company_id();
        $delres = DB::table('app_lunbo')->where('id',$lunbo_id)->where('company_id',$company_id)->delete();
        if($delres)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    }
    
    
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function gift_remove($_gift_id)
    {
    	$gift_id = hash_decode($_gift_id);
    	$company_id = company_id();
    	$delres = DB::table('gift')->where('id',$gift_id)->where('company_id',$company_id)->delete();
    	if($delres)
    	{
    		return back()->with('alert-success','成功');
    	}
    	return back()->with('alert-danger','服务器繁忙');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('index::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('index::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
