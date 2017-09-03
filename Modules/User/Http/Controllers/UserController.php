<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
   
        $users = DB::table('c_user_product')->select(['c_user_product.user_id','c_user_product.product_id','c_user_product.status','openid','phone','nickname','sex','headimg','products.name as pname','price'])
                    ->leftJoin('c_users', 'c_users.id','=','c_user_product.user_id')
                    ->leftJoin('products', 'products.id','=','c_user_product.product_id')
                    ->where('c_user_product.company_id',company_id())
                    ->orderByDesc('c_user_product.id')
                    ->paginate(20);
     
        return view('user::user.index',['users'=>$users]);
    }
    
    /**
     * 访客主页
     */
    public function visit_index()
    {
    	//today
    	$today = date("Y-m-d",time());
    	$today_stime = $today." 00:00:00";
    	$today_etime = $today." 23:59:59";
    	
    	
    /* 	$users = DB::table('c_visitor')    		
    		->orderByDesc('update_at')
    		->where('company_id',company_id())
    		->orderByDesc('created_at')
    		->paginate(40);
    	
    	$man_num = DB::table('c_visitor')
    	->where('company_id',company_id())
    	->where('sex',1)
    	->count();
    	
    	$women_num = DB::table('c_visitor')
    	->where('company_id',company_id())
    	->where('sex',2)
    	->count();
    	*/
    	
    	 $today_num = DB::table('c_users')
    	    ->where('company_id',company_id())
    		->whereBetween('update_at',[$today_stime,$today_etime])
    		->count(); 
    	
    	 $total = DB::table('c_users')
    	 ->where('company_id',company_id())
    	 ->count();
    	  
    	$users = DB::table('c_users')->where('company_id',company_id())->orderByDesc('update_at')->paginate(20);
    	foreach ($users as $user){
    	    $user->_id = hash_encode($user->id);
    	}
    	 
   
    	return view('user::user.visit_index',['today'=>$today_num,'total'=>$total,'users'=>$users]);
    }

    
    
    public function deal(Request $request){
        $company_id = company_id();
        $rs = DB::table('c_user_product')->where(['company_id'=>$company_id,'user_id'=>$request->uid,'product_id'=>$request->pid])->update(['status'=>1]);
        if($rs)
        {
            return back()->with('alert-success','成功');
        }
        return back()->with('alert-danger','失败');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function get_user_combo(Request $request)
    {
        $id = hash_decode($request->input('id'));
        $company_id = company_id();       
        $users = DB::table('c_users')->where('id', $id)->first();
        $type = $request->input('type');
        
        if($type == 1){
        	$combos = DB::table('c_user_combo')
        	->leftjoin('combos','combos.id','=','c_user_combo.combo_id' )
        	->where('company_id', $company_id)
        	->where('c_user_combo.user_id', $id)
        	->get();
        	foreach ($combos as $combo){
        		$combo->price = sprintf('%0.2f',($combo->price)/100);
        	}
        	return view('user::user._user_combo',['users'=>$users,'combos'=>$combos]);
        }
        else if($type == 2){
        	$collets = DB::table('c_user_collet')
        	->where('user_id',$id)
        	->select(['id','common_id','type','created_at'])
        	->orderByDesc('created_at')
        	->paginate(10);
        	foreach ($collets as $collet){
        		if($collet->type == 2)
        		{
        			$combo = DB::table('combos')
        			->select(['name','price','cover'])
        			->where('id',$collet->common_id)
        			->first();
        			$collet->name = $combo->name;
        			$collet->price = format_price(($combo->price));
        			$collet->cover = $combo->cover;
        		}
        		if($collet->type == 3)
        		{
        			$activity = DB::table('activity')
        			->select(['name','new_price','cover'])
        			->where('id',$collet->common_id)
        			->first();
        			$collet->name = $activity->name;
        			$collet->price = format_price($activity->new_price);
        			$collet->cover = $activity->cover;
        		}

        		$collet->common_id = hash_encode($collet->common_id);
        		$collet->type = type_format($collet->type);
        	}

        	return view('user::user._user_collet',['users'=>$users,'collets'=>$collets]);
        }
        else if($type == 3){
        	$activities = DB::table('c_user_activity')
        	->select(['activity_id','cover','name','new_price','before_price','created_at'])
        	->leftJoin('activity', 'activity.id','=','c_user_activity.activity_id')
        	->where(['user_id'=>$id,'c_user_activity.company_id'=>$company_id])
        	->orderByDesc('created_at')
        	->paginate(10);
        	foreach ($activities as $activity){
        		
        		$activity->activity_id = hash_encode($activity->activity_id);
        		$activity->before_price = format_price($activity->before_price);
        		$activity->new_price = format_price($activity->new_price);
        	}
        	return view('user::user._user_activity',['users'=>$users,'activities'=>$activities]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('user::edit');
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
