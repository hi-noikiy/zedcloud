<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPhoto;
use Modules\Product\Http\Requests\PhotoGet;
use Modules\Product\Http\Requests\PhotoPost;
use Modules\Product\Http\Requests\PhotoPut;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PhotoGet $request
     * @return Response
     */
    public function index(PhotoGet $request) {
        $_product_id = $request->input('_product_id');
        $product_id  = hash_decode($_product_id);

        if (!$product_id) {
            return back()->with('alert-danger', trans('product::product.invalid'));
        }
        $product = Product::find($product_id, ['id', 'category_id', 'name']);
        if (!$product) {
            return back()->with('alert-danger', trans('product::product.not.found'));
        }
        $product->_category_id = hash_encode($product->category_id);
        $photos               = $product->photos()->select(['id', 'product_id', 'url'])->orderBy('created_at', 'DESC')->paginate(20);
        foreach ($photos as $photo) {
            $photo->product_name = $product->name;
            $photo->_id         = hash_encode($photo->id);
        }
        return view('product::photo.index', [
            'product' => $product,
            'photos' => $photos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PhotoGet $request
     * @return Response
     */
    public function create(PhotoGet $request) {
        $_product_id = $request->input('_product_id');
        $product_id  = hash_decode($_product_id);
        if (!$product_id) {
            return back()->with('alert-danger', trans('product::product.invalid'));
        }
        $product = Product::find($product_id, ['id', 'category_id']);
        if (!$product) {
            return back()->with('alert-danger', trans('product::product.not.found'));
        }
        $product->_id          = hash_encode($product->id);
        $product->_category_id = hash_encode($product->category_id);
        return view('product::photo.create', [
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  PhotoPost $request
     * @return Response
     */
    public function store(PhotoPost $request) {
        $fields     = $request->all();
        $url        = $request->file('url');
        $_product_id = $request->input('_product_id');
        $product_id  = hash_decode($_product_id);
        if (!$product_id) {
            return back()->withInput($fields)->with('alert-danger', trans('product::product.invalid'));
        }
        $product = Product::find($product_id, ['id']);
        if (!$product) {
            return back()->withInput($fields)->with('alert-danger', trans('product::product.not.found'));
        }
        $_company_id = hash_encode(Auth::user()->company_id);

        $disk      = Storage::disk('qiniu');
        $dir       = "{$_company_id}/product/photo";
        $photo_url = $disk->put($dir, $url);

        $photo            = new ProductPhoto();
        $photo->product_id = $product->id;
        $photo->url       = $photo_url;
        if ($photo->save()) {
            return redirect()->route('product.photo.list', ['_product_id' => $_product_id])->with('alert-success', trans('main.success'));
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
            return back()->with('alert-danger', trans('product::photo.invalid'));
        }
        $model = ProductPhoto::select(['id', 'product_id', 'url', 'created_at']);
        $model->where('id', $photo_id);
        $photo = $model->first();
        if (!$photo) {
            return back()->with('alert-danger', trans('product::photo.not.found'));
        }

        $photo->_id                  = hash_encode($photo->id);
        $photo->_product_id           = hash_encode($photo->product_id);
        $photo->product               = $photo->product()->select(['id', 'category_id', 'name'])->first();
        $photo->product->_category_id = hash_encode($photo->product->category_id);

        return view('product::photo.show', [
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
            return back()->with('alert-danger', trans('product::photo.invalid'));
        }
        $photo = ProductPhoto::find($photo_id, ['id', 'product_id', 'url']);
        if (!$photo) {
            return back()->with('alert-danger', trans('product::photo.not.found'));
        }
        $photo->_id                  = hash_encode($photo->id);
        $photo->_product_id           = hash_encode($photo->product_id);
        $photo->product               = $photo->product()->select(['id', 'category_id'])->first();
        $photo->product->_category_id = hash_encode($photo->product->category_id);
        return view('product::photo.edit', [
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
            return back()->with('alert-danger', trans('product::photo.invalid'));
        }

        $url = $request->file('url');

        $photo = ProductPhoto::find($photo_id, ['id', 'product_id', 'url']);
        if (!$photo) {
            return back()->with('alert-danger', trans('product::photo.not.found'));
        }
        if ($url) {
            $_company_id = hash_encode(Auth::user()->company_id);
            $disk        = Storage::disk('qiniu');
            $dir         = "{$_company_id}/product/photo";
            $photo_url   = $disk->put($dir, $url);
            $photo->url  = $photo_url;
        }
        if ($photo->save()) {
            $_product_id = hash_encode($photo->product_id);
            return redirect()->route('product.photo.list', ['_product_id' => $_product_id])->with('alert-success', trans('main.success'));
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
            return back()->with('alert-danger', trans('product::photo.invalid'));
        }

        $photo = ProductPhoto::find($photo_id, ['id', 'product_id']);
        if (!$photo) {
            return back()->with('alert-danger', trans('product::photo.not.found'));
        }
        if ($photo->delete()) {
            $_product_id = hash_encode($photo->product_id);
            return redirect()->route('product.photo.list', ['_product_id' => $_product_id])->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }
}
