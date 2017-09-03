<?php

namespace Modules\Album\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Album\Entities\AlbumCategory;
use Modules\Album\Http\Requests\CategoryPost;
use Modules\Album\Http\Requests\CategoryPut;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $categories = AlbumCategory::select(['id', 'name','created_at'])->orderByDesc('created_at')->paginate(20);
        foreach ($categories as $category) {
            $category->_id = hash_encode($category->id);
        }
        return view('album::category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('album::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  CategoryPost $request
     * @return Response
     */
    public function store(CategoryPost $request) {
        $model       = new AlbumCategory();
        $model->name = $request->input('name');
        if ($model->save()) {
            return redirect()->route('album.category.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }

    /**
     * Show the specified resource.
     *
     * @param  string $_category_id
     * @return Response
     */
    public function show($_category_id) {
        $category_id = hash_decode($_category_id);
        if (!$category_id) {
            return back()->with('alert-danger', trans('album::category.invalid'));
        }
        $category = AlbumCategory::select(['id', 'name', 'created_at'])->where('id', $category_id)->first();
        if (!$category) {
            return back()->with('alert-danger', trans('album::category.not.found'));
        }
        return view('album::category.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $_category_id
     * @return Response
     */
    public function edit($_category_id) {
        $category_id = hash_decode($_category_id);
        if (!$category_id) {
            return back()->with('alert-danger', trans('album::category.invalid'));
        }
        $category = AlbumCategory::select(['id', 'name'])->where('id', $category_id)->first();
        if (!$category) {
            return back()->with('alert-danger', trans('album::category.not.found'));
        }
        $category->_id = hash_encode($category->id);
        return view('album::category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryPut $request
     * @param  string $_category_id
     * @return Response
     */
    public function update(CategoryPut $request, $_category_id) {
        $category_id = hash_decode($_category_id);
        if (!$category_id) {
            return back()->with('alert-danger', trans('album::category.invalid'));
        }
        $model = AlbumCategory::select(['id', 'name'])->where('id', $category_id)->first();

        if (!$model) {
            return back()->with('alert-danger', trans('album::category.not.found'));
        }
        $model->name = $request->input('name');
        if ($model->save()) {
            return redirect()->route('album.category.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $_category_id
     * @return Response
     */
    public function destroy($_category_id) {
        $category_id = hash_decode($_category_id);
        if (!$category_id) {
            return back()->with('alert-danger', trans('album::category.invalid'));
        }
        $model = AlbumCategory::select(['id', 'name'])->where('id', $category_id)->first();

        if (!$model) {
            return back()->with('alert-danger', trans('album::category.not.found'));
        }
        if ($model->delete()) {
            return redirect()->route('album.category.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }
}
