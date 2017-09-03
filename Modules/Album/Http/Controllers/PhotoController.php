<?php

namespace Modules\Album\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\Album\Http\Requests\ApiPhotoPost;
use Storage;
use Modules\Album\Entities\Album;
use Modules\Album\Entities\AlbumPhoto;
use Modules\Album\Http\Requests\PhotoGet;
use Modules\Album\Http\Requests\PhotoPost;
use Modules\Album\Http\Requests\PhotoPut;

use App\Lib\KrOperation;
use App\Lib\Common;
use DB;
use App\Lib\Qiniu_Factory;
use Illuminate\Validation\Rules\Unique;
class PhotoController extends Controller
{
    /***
     * album.aubum.addpics
     */
    /**
     * 物体环视功能
     *
     */
    public function addpics(Request $request)
    {
        $params = $request->input('params');
        $_album_id = $request->input('_album_id');
        $album_id = hash_decode($_album_id);
        //过滤非法字符
        $this->filter_array($params);
        
        if(empty($params))
        {
            $re['msg'] = '请先上传图片';
        }
        
        else
        {
            //添加服装
            $imgs = $params['imgs'];
            foreach ($imgs as &$v)
            {
                $key[] = $v['index'];
            }
            array_multisort($key,SORT_NUMERIC,SORT_ASC,$imgs);
                       
            $data = [];
            foreach ($imgs as $v)
            {
                $tmp = ['album_id'=>$album_id,'url'=>$v['imgsrc']];
                array_push($data, $tmp);
            }

            $inall = DB::table('album_photos')->insert($data);
            if($inall)
            {
                $num = count($imgs);
                $rs = DB::table('albums')->where('id',$album_id)->increment('photo_number',$num);
                $re['flag'] = 1;
            }
    
            
        }
        return response()->json($re);
    }
    
    
    /**
     * 过滤非法字符
     * @param unknown $arr
     */
    public function filter_array(&$arr){
        foreach($arr as $k => &$v){
            if(is_array($v))
                $this->filter_array($v);
            else{
                $k =Common::sfilter($k);
                $v =Common::sfilter($v);
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @param PhotoGet $request
     * @return Response
     */
    public function index(PhotoGet $request) {
        $_album_id = $request->input('_album_id');
        $album_id  = hash_decode($_album_id);

        if (!$album_id) {
            return back()->with('alert-danger', trans('album::album.invalid'));
        }
        $album = Album::find($album_id, ['id', 'name']);
        if (!$album) {
            return back()->with('alert-danger', trans('album::album.not.found'));
        }
        $photos              = $album->photos()->select(['id', 'album_id', 'url', 'like'])->orderBy('id', 'DESC')->paginate(20);
        foreach ($photos as $photo) {
            $photo->album_name = $album->name;
            $photo->_id        = hash_encode($photo->id);
        }
        return view('album::photo.index', [
            'album'  => $album,
            'photos' => $photos,
            '_album_id'=>$_album_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PhotoGet $request
     * @return Response
     */
    public function create(PhotoGet $request) {
        $_album_id = $request->input('_album_id');
        $album_id  = hash_decode($_album_id);
        if (!$album_id) {
            return back()->with('alert-danger', trans('album::album.invalid'));
        }
        $album = Album::find($album_id, ['id', 'category_id']);
        if (!$album) {
            return back()->with('alert-danger', trans('album::album.not.found'));
        }
        $album->_id          = hash_encode($album->id);
        $album->_category_id = hash_encode($album->category_id);
        return view('album::photo.create', [
            'album' => $album,
            '_album_id'=>$_album_id,
            '_category_id'=>$album->_category_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  PhotoPost $request
     * @return Response
     */
    public function store(PhotoPost $request) {
        $fields    = $request->all();
        $url       = $request->file('lunbo');
        $_album_id = $request->input('_album_id');
        $album_id  = hash_decode($_album_id);
        if (!$album_id) {
            return back()->withInput($fields)->with('alert-danger', '456');
        }
        $album = Album::find($album_id, ['id']);
        if (!$album) {
            return back()->withInput($fields)->with('alert-danger', 'kong');
        }
        $_company_id = hash_encode(Auth::user()->company_id);

        $disk      = Storage::disk('qiniu');
        $dir       = "photo/";
        $rs = $disk->put($dir, $url);

        $photo           = new AlbumPhoto();
        $photo->album_id = $album->id;
        $photo->url      = $rs;
        $photo->like     = $request->input('like', 0);
        if ($photo->save()) {
            DB::table('albums')->where('id',$album->id)->increment('photo_number');
            return redirect()->route('album.photo.list', ['_album_id' => $_album_id])->with('alert-success', trans('main.success'));
        } else {
            return back()->withInput($fields)->with('alert-danger', trans('main.operate.failed'));
        }
    }

    /**
     * Show the specified resource.
     *
     * @param $photo_id
     * @return Response
     */
    public function show($_photo_id) {
        $photo_id = hash_decode($_photo_id);
        if (!$photo_id) {
            return back()->with('alert-danger', trans('album::photo.invalid'));
        }
        $model = AlbumPhoto::select(['id', 'album_id', 'url', 'like', 'created_at']);
        $model->where('id', $photo_id);
        $photo = $model->first();
        if (!$photo) {
            return back()->with('alert-danger', trans('album::photo.not.found'));
        }

        $photo->_id                 = hash_encode($photo->id);
        $photo->_album_id           = hash_encode($photo->album_id);
        $photo->album               = $photo->album()->select(['id', 'category_id', 'name'])->first();
        $photo->album->_category_id = hash_encode($photo->album->category_id);

        return view('album::photo.show', [
            'photo' => $photo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $_photo_id
     * @return Response
     */
    public function edit($_photo_id) {
        $photo_id = hash_decode($_photo_id);
        if (!$photo_id) {
            return back()->with('alert-danger', trans('album::photo.invalid'));
        }
        $photo = AlbumPhoto::find($photo_id, ['id', 'album_id', 'url', 'like']);
        if (!$photo) {
            return back()->with('alert-danger', trans('album::photo.not.found'));
        }
        $photo->_id                 = hash_encode($photo->id);
        $photo->_album_id           = hash_encode($photo->album_id);
        $photo->album               = $photo->album()->select(['id', 'category_id'])->first();
        $photo->album->_category_id = hash_encode($photo->album->category_id);
        return view('album::photo.edit', [
            'photo' => $photo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  PhotoPut $request
     * @param  $_photo_id
     * @return Response
     */
    public function update(PhotoPut $request, $_photo_id) {
        $photo_id = hash_decode($_photo_id);
        if (!$photo_id) {
            return back()->with('alert-danger', trans('album::photo.invalid'));
        }

        $url = $request->file('url');

        $photo = AlbumPhoto::find($photo_id, ['id', 'album_id', 'url', 'like']);
        if (!$photo) {
            return back()->with('alert-danger', trans('album::photo.not.found'));
        }
        if ($url) {
            $_company_id = hash_encode(Auth::user()->company_id);
            $disk        = Storage::disk('qiniu');
            $dir         = "{$_company_id}/album/photo";
            $photo_url   = $disk->put($dir, $url);
            $photo->url  = $photo_url;
        }
        $photo->like = $request->input('like', 0);
        if ($photo->save()) {
            $_album_id = hash_encode($photo->album_id);
            return redirect()->route('album.photo.list', ['_album_id' => $_album_id])->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $_photo_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($_photo_id) {
        $photo_id = hash_decode($_photo_id);
        if (!$photo_id) {
            return back()->with('alert-danger', trans('album::photo.invalid'));
        }

        $photo = AlbumPhoto::find($photo_id, ['id', 'album_id']);
        if (!$photo) {
            return back()->with('alert-danger', trans('album::photo.not.found'));
        }
        if ($photo->delete()) {
            $_album_id = hash_encode($photo->album_id);
            $rs = DB::table('albums')->where('id',$photo->album_id)->decrement('photo_number',1);
            return redirect()->route('album.photo.list', ['_album_id' => $_album_id])->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }

    /**
     * Api store album's photo
     *
     * @param ApiPhotoPost $request
     * @return Response
     */
    public function apiStore(ApiPhotoPost $request) {
        $_album_id = $request->input('_album_id');
        $album_id  = hash_decode($_album_id);
        if (!$album_id) {
            return un_processable(trans('album::album.invalid'));
        }
        $album = Album::find($album_id, ['id']);
        if (!$album) {
            return un_processable(trans('album::album.not.found'));
        }

        $photo           = new AlbumPhoto();
        $photo->album_id = $album->id;
        $photo->url      = $request->input('url');
        $photo->like     = $request->input('like', 0);
        if ($photo->save()) {
            return success(trans('main.success'));
        } else {
            return error('main.operate.invalid');
        }
    }
}
