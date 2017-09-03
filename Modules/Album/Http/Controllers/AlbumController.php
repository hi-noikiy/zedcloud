<?php

namespace Modules\Album\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Storage;
use Modules\Album\Entities\Album;
use Modules\Album\Entities\AlbumCategory;
use Modules\Album\Http\Requests\AlbumGet;
use Modules\Album\Http\Requests\AlbumPost;
use Modules\Album\Http\Requests\AlbumPut;
use DB;
class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AlbumGet $request
     * @return Response
     */
    public function index(AlbumGet $request) {
        $model        = Album::select(['id', 'company_id','cover', 'name', 'like', 'photo_number','hot','created_at']);
        $model->orderBy('created_at', 'DESC');    
        $model->where('company_id', company_id());
        $albums = $model->paginate(20);
        foreach ($albums as $album) {
            $album->_id = hash_encode($album->id);

        }

        return view('album::album.index', [
            'albums' => $albums,
        ]);
    }

    /**
     * 样片热推
     */
    public function sethot($_album_id)
    {
        $company_id = company_id();
        $hot_num = DB::table('albums')
                    ->whereNull('albums.deleted_at')
                    ->where('company_id',company_id())
                    ->where('hot',1)
                    ->get();
        
        if(count($hot_num) >= 6)
        {
            return back()->with('alert-danger','热推数量不能超过6个');
        }
        
        $album_id = hash_decode($_album_id);
        $album = DB::table('albums')->where('id',$album_id)->first();
        if(empty($album))
        {
            return back()->with('alert-danger','参数错误');
        }
        $album = DB::table('albums')->where('id',$album_id)->update(['hot'=>1]);
        if($album)
        {
            return back()->with('alert-success','设置成功');
        }
        return back()->with('alert-danger','服务器繁忙');
        
    }
    
    /**
     * 取消样片热推
     */
    public function unsethot($_album_id)
    {
        $album_id = hash_decode($_album_id);
        $album = DB::table('albums')->where('id',$album_id)->first();
        if(empty($album))
        {
            return back()->with('alert-danger','参数错误');
        }
        $album = DB::table('albums')->where('id',$album_id)->update(['hot'=>0]);
        if($album)
        {
            return back()->with('alert-success','设置成功');
        }
        return back()->with('alert-danger','服务器繁忙');
    
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @param AlbumGet $request
     * @return Response
     */
    public function create(AlbumGet $request) {
        $_category_id = $request->input('_category_id');
        $category_id  = hash_decode($_category_id);
        if (!$category_id) {
            return back()->with('alert-danger', trans('album::category.invalid'));
        }
        $category = AlbumCategory::find($category_id, ['id']);
        if (!$category) {
            return back()->with('alert-danger', trans('album::category.not.found'));
        }
        return view('album::album.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  AlbumPost $request
     * @return Response
     */
    public function store(AlbumPost $request) {
        $fields       = $request->all();
        $cover        = $request->file('cover');
       
        $_company_id = hash_encode(Auth::user()->company_id);

        $disk      = Storage::disk('qiniu');
        $dir       = "{$_company_id}/album/cover";
        $cover_url = $disk->put($dir, $cover);

        $album              = new Album();
        $album->company_id = company_id();
        $album->cover       = $cover_url;
        $album->name        = $fields['name'];
        $album->like        = 0;
        if ($album->save()) {
            return redirect()->route('album.album.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->withInput($fields)->with('alert-danger', trans('main.operate.failed'));
        }
    }

    /**
     * Show the specified resource.
     *
     * @param $_album_id
     * @return Response
     */
    public function show($_album_id) {
        $album_id = hash_decode($_album_id);
        if (!$album_id) {
            return back()->with('alert-danger', trans('album::album.invalid'));
        }
        $model = Album::select(['id', 'category_id', 'cover', 'name', 'like', 'photo_number', 'created_at']);
        $model->where('id', $album_id);
        $album = $model->first();
        if (!$album) {
            return back()->with('alert-danger', trans('album::album.not.found'));
        }
        $album->_id          = hash_encode($album->id);
        $album->_category_id = hash_encode($album->category_id);

        return view('album::album.show', [
            'album' => $album,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $_album_id
     * @return Response
     */
    public function edit($_album_id) {
        $album_id = hash_decode($_album_id);
        if (!$album_id) {
            return back()->with('alert-danger', trans('album::album.invalid'));
        }
        $model = Album::select(['id', 'category_id', 'cover', 'name', 'like']);
        $model->where('id', $album_id);
        $album = $model->first();
        if (!$album) {
            return back()->with('alert-danger', trans('album::album.not.found'));
        }
        $album->_id          = hash_encode($album->id);
        $album->_category_id = hash_encode($album->category_id);
        return view('album::album.edit', [
            'album' => $album,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  AlbumPut $request
     * @param  $_album_id
     * @return Response
     */
    public function update(AlbumPut $request, $_album_id) {
        $album_id = hash_decode($_album_id);
        if (!$album_id) {
            return back()->with('alert-danger', trans('album::album.invalid'));
        }
        $cover = $request->file('cover');

        $album = Album::find($album_id, ['id', 'cover', 'name', 'like']);
        if (!$album) {
            return back()->with('alert-danger', trans('album.not.found'));
        }
        if ($cover) {
            $_company_id  = hash_encode(Auth::user()->company_id);
            $disk         = Storage::disk('qiniu');
            $dir          = "{$_company_id}/album/cover";
            $cover_url    = $disk->put($dir, $cover);
            $album->cover = $cover_url;
        }
        $album->name = $request->input('name');
        $album->like = $request->input('like', 0);
        if ($album->save()) {
           
            return redirect()->route('album.album.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $_album_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($_album_id) {
        $album_id = hash_decode($_album_id);
        if (!$album_id) {
            return back()->with('alert-danger', trans('album::album.invalid'));
        }

        $album = Album::find($album_id, ['id']);
        if (!$album) {
            return back()->with('alert-danger', trans('album::album.not.found'));
        }
        if ($album->delete()) {
          
            return redirect()->route('album.album.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }
}
