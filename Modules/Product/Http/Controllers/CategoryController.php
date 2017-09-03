<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Http\Requests\CategoryPost;
use Modules\Product\Http\Requests\CategoryPut;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $categories = ProductCategory::select(['id', 'name','created_at'])->orderByDesc('created_at')->paginate(20);
        foreach ($categories as $category) {
            $category->_id = hash_encode($category->id);
        }
        return view('product::category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('product::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  CategoryPost $request
     * @return Response
     */
    public function store(CategoryPost $request) {
        $model       = new ProductCategory();
        $model->name = $request->input('name');
        if ($model->save()) {
            return redirect()->route('product.category.list')->with('alert-success', trans('main.success'));
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
            return back()->with('alert-danger', trans('product::category.invalid'));
        }
        $category = ProductCategory::select(['id', 'name', 'created_at'])->where('id', $category_id)->first();
        if (!$category) {
            return back()->with('alert-danger', trans('product::category.not.found'));
        }
        return view('product::category.show', [
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
            return back()->with('alert-danger', trans('product::category.invalid'));
        }
        $category = ProductCategory::select(['id', 'name'])->where('id', $category_id)->first();
        if (!$category) {
            return back()->with('alert-danger', trans('product::category.not.found'));
        }
        $category->_id = hash_encode($category->id);
        return view('product::category.edit', [
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
            return back()->with('alert-danger', trans('product::category.invalid'));
        }
        $model = ProductCategory::select(['id', 'name'])->where('id', $category_id)->first();

        if (!$model) {
            return back()->with('alert-danger', trans('product::category.not.found'));
        }
        $model->name = $request->input('name');
        if ($model->save()) {
            return redirect()->route('product.category.list')->with('alert-success', trans('main.success'));
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
            return back()->with('alert-danger', trans('product::category.invalid'));
        }
        $model = ProductCategory::select(['id', 'name'])->where('id', $category_id)->first();

        if (!$model) {
            return back()->with('alert-danger', trans('product::category.not.found'));
        }
        if ($model->delete()) {
            return redirect()->route('product.category.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }
}
