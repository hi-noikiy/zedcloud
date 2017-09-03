<?php

namespace Modules\Activity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;
class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //更新活动状态
        $this->update_activity();
        
        $company_id = company_id();
        $activities = DB::table('activity')->where('company_id',$company_id)->paginate(10);
        foreach ($activities as $activity)
        {
            $activity->_id = hash_encode($activity->id);
            $activity->cover = env('APP_CDN').$activity->cover;
            $activity->before_price = format_price($activity->before_price);
            $activity->new_price = format_price($activity->new_price);
        }
        
        return view('activity::index',['activities'=>$activities]);
    }
    
    public function update_activity()
    {
        $company_id = company_id();
        
        DB::table('activity')->where('company_id',$company_id)
                             ->where('end_time', "<", date('Y-m-d H:i:s',time()))
                             ->update(['status'=>2]);
        
        DB::table('activity')->where('company_id',$company_id)
        ->where('end_time', ">", date('Y-m-d H:i:s',time()))
        ->where('start_time', "<", date('Y-m-d H:i:s',time()))
        ->update(['status'=>1]);
        
    }
    

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('activity::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        validator($request->all(),[
                'name'=>'require|string|max:30',
                'combo_id'=>'string|max:15',
                'before_price'=>'require|numeric',
                'new_price'=>'require|numeric',
                'address'=>'require|string|max:50', 
                 
        ]);
        
        $inputs = $request->all();
        $file = $request->file('cover');
        $disk      = Storage::disk('qiniu');
        $dir       = company_id()."/activity/cover";
        $cover_url = $disk->put($dir, $file);
        
        
        if($inputs['combo_id']){
        	$combo_id = hash_decode($inputs['combo_id']);
        	$rs = DB::table('combos')->leftJoin('combo_categories', 'combo_categories.id','=','category_id')
        	->where(['company_id'=>company_id(),'combos.id'=>$combo_id])
        	->first();
        	if(empty($rs)){
        		return back()->with('alert-danger','您没有该套系，请输入正确的套系序号');
        	}
        }        
        $combo_id = hash_decode($inputs['combo_id']);
        $rs = DB::table('activity')->insert([
                'name'=>$inputs['name'],
                'combo_id'=>$combo_id,
                'before_price'=>$inputs['before_price'] * 100,
                'new_price'=>$inputs['new_price'] * 100,
                'address'=>$inputs['address'],
                'detail'=>$inputs['content'],
                'start_time'=>$inputs['start_time'],
                'end_time'=>$inputs['end_time'],
                'company_id'=>company_id(),
                'cover'=>$cover_url
                
        ]);
        if($rs)
        {
            return redirect(route('activity.activity.list'));
        }
        else{
            return back()->with('alert-danger','操作失败，请重试');
        }
        
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('activity::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($_id)
    {
        $id = hash_decode($_id);
        $activity = DB::table('activity')->where('id',$id)->first(); 
        if(!$activity)
        {
            return back()->with('alert-danger','操作失败，请重试');
        }   
        $activity->_id = $_id;
        if(empty($activity->combo_id)){
        	$activity->combo_id = '';
        }else {
        	$activity->combo_id = hash_encode($activity->combo_id);
        }
        $activity->before_price = format_price($activity->before_price);
        $activity->new_price = format_price($activity->new_price);
        return view('activity::edit',['activity'=>$activity]);
    }
    
    

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $check = validator($request->all(),[
                'name'=>'required|string',
                'before_price'=>'required|numeric',
                'new_price'=>'required|numeric',
                'address'=>'required|string',
        ]);
        if($check->fails()){
        	return back()->withErrors($check);
        }
        
        $inputs = $request->all();
        $file = $request->file('cover');
        
        if($inputs['combo_id']){
        	$combo_id = hash_decode($inputs['combo_id']);
        	$rs = DB::table('combos')->leftJoin('combo_categories', 'combo_categories.id','=','category_id')
        	->where(['company_id'=>company_id(),'combos.id'=>$combo_id])
        	->first();
        	if(empty($rs)){
        		return back()->with('alert-danger','您没有该套系，请输入正确的套系序号');
        	}
        }
        $combo_id = hash_decode($inputs['combo_id']);
        $data = [
                'name'=>$inputs['name'],
                'combo_id'=>$combo_id,
                'before_price'=>$inputs['before_price']* 100,
                'new_price'=>$inputs['new_price'] * 100,
                'address'=>$inputs['address'],
                'detail'=>$inputs['content'],
                'start_time'=>$inputs['start_time'],
                'end_time'=>$inputs['end_time'],       
        ];
        
        if($file)
        {
            $disk      = Storage::disk('qiniu');
            $dir       = company_id()."/activity/cover";
            $cover_url = $disk->put($dir, $file);
            $data['cover'] = $cover_url;
        }
        
        $id = hash_decode($inputs['_id']);
        $rs = DB::table('activity')->where('id',$id)->update($data);
        if($rs)
        {
            return redirect(route('activity.activity.list'))->with('alert-success','编辑成功');;
        }
        else{
            return back()->with('alert-danger','操作失败，请重试');
        }
    }
    
    
    
    /**
     * 样片热推
     */
    public function sethot($_activity_id)
    {
        $company_id = company_id();
        $hot_num = DB::table('activity')
        ->where('company_id',$company_id)
        ->where('hot',1)
        ->get();
    
        if(count($hot_num) >= 5)
        {
            return back()->with('alert-danger','热推数量不能超过3个');
        }
    
        $activity_id = hash_decode($_activity_id);
        $activity = DB::table('activity')->where('id',$activity_id)->first();
        if(empty($activity))
        {
            return back()->with('alert-danger','参数错误');
        }
        $activity = DB::table('activity')->where('id',$activity_id)->update(['hot'=>1]);
        if($activity)
        {
            return back()->with('alert-success','设置成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    
    }
    
    /**
     * 取消样片热推
     */
    public function unsethot($_activity_id)
    {
        $activity_id = hash_decode($_activity_id);
        $activity = DB::table('activity')->where('id',$activity_id)->first();
        if(empty($activity))
        {
            return back()->with('alert-danger','参数错误');
        }
        $activity = DB::table('activity')->where('id',$activity_id)->update(['hot'=>0]);
        if($activity)
        {
            return back()->with('alert-success','设置成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    
    }
    

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($_id)
    {
        $id = hash_decode($_id);
        $rs = DB::table('activity')->where('id',$id)->where('company_id',company_id())->delete();
        if($rs)
        {
            return back()->with('alert-success','删除成功');
        }
        else{
            return back()->with('alert-danger','操作失败，请重试');
        }
    }
}
