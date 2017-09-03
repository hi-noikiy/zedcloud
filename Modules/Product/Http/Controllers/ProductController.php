<?php

namespace Modules\Product\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Http\Requests\ProductGet;
use Modules\Product\Http\Requests\ProductPost;
use Modules\Product\Http\Requests\ProductPut;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductGet $request
     * @return Response
     */
    public function index(ProductGet $request) {

        $products  = DB::table('products')
                ->select([ 'id', 'cover', 'name', 'price','old_price','introduce','unit','status','hot' ])
                ->orderBy('created_at', 'DESC')
                ->whereNull('deleted_at')
                ->where('company_id',company_id())
                ->paginate(20);

     
        foreach($products as $product) {
            $product->_id            = hash_encode($product->id);
        }

        return view('product::product.index', [
            'products' => $products, 		
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * @param  ProductPost $request
     * @return Response
     */
    public function store(ProductPost $request) {
        $fields       = $request->all();
        $cover        = $request->file('cover');

        $_company_id = hash_encode(Auth::user()->company_id);

        $disk      = Storage::disk('qiniu');
        $dir       = "{$_company_id}/product/cover";
        $cover_url = $disk->put($dir, $cover);

        $data = [
            'company_id'      => company_id(),
            'unit'   => $request->input('unit'),
            'cover'        => $cover_url,
            'name'         =>$request->input('name'),
            'price'       => $request->input('price', 0),
            'old_price' =>$request->input('old_price', 0),
            'introduce' =>$request->input('intro'),
            'created_at' =>date("Y-m-d H:i:s",time())           
        ];
      
        $rs = DB::table('products')->insert($data);
        if($rs) {
            return redirect()->route('product.product.list')->with('alert-success', '新增成功');
        } else {
            return back()->with('alert-danger', '新增失败');
        }
    }

    
     public function sethot($_product_id)
     {        
         
         $product_id = hash_decode($_product_id);
         $rs = DB::table('products')->where('id',$product_id)->update(['hot'=>1]);
        if($rs) {
            return redirect()->route('product.product.list')->with('alert-success', '成功');
        } else {
            return back()->with('alert-danger', '失败');
        }
         
         
     }

     public function unsethot($_product_id)
     {
         
         $product_id = hash_decode($_product_id);
         $rs = DB::table('products')->where('id',$product_id)->update(['hot'=>0]);
         if($rs) {
             return redirect()->route('product.product.list')->with('alert-success', '成功');
         } else {
             return back()->with('alert-danger', '失败');
         }
          
          
     }
    
    /**
     * Show the specified resource.
     *
     * @param $_product_id
     * @return Response
     */
    public function show($_product_id) {
        $product_id = hash_decode($_product_id);
        if(!$product_id) {
            return back()->with('alert-danger', trans('product::product.invalid'));
        }
        $model = Product::select([ 'id', 'sale_type', 'category_id', 'cover', 'name', 'price', 'sales_volume', 'created_at' ]);
        $model->where('id', $product_id);
        $product = $model->first();
        if(!$product) {
            return back()->with('alert-danger', trans('product::product.not.found'));
        }
        $product->_id            = hash_encode($product->id);
        $product->sale_type_text = $product->saleTypeText();
        $product->_category_id   = hash_encode($product->category_id);
        $product->price          = $product->price / 100.0;

        return view('product::product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $_product_id
     * @return Response
     */
    public function edit($_product_id) {
        $product_id = hash_decode($_product_id);
        if(!$product_id) {
            return back()->with('alert-danger', trans('product::product.invalid'));
        }
        $model = Product::select([ 'id', 'sale_type', 'category_id', 'cover', 'name', 'price', 'sales_volume' ]);
        $model->where('id', $product_id);
        $product = $model->first();
        if(!$product) {
            return back()->with('alert-danger', trans('product::product.not.found'));
        }
        $product->_id          = hash_encode($product->id);
        $product->_category_id = hash_encode($product->category_id);
        $product->price        = $product->price / 100.0;

        $productModel          = new Product();
        $sale_types            = $productModel->saleTypes();

        return view('product::product.edit', [
            'product'    => $product,
            'sale_types' => $sale_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  ProductPut $request
     * @param  $_product_id
     * @return Response
     */
    public function update(ProductPut $request, $_product_id) {
        $product_id = hash_decode($_product_id);
        if(!$product_id) {
            return back()->with('alert-danger', trans('product::product.invalid'));
        }
        $cover = $request->file('cover');

        $product = Product::find($product_id, [ 'id']);
        if(!$product) {
            return back()->with('alert-danger', trans('product.not.found'));
        }
        if($cover) {
            $_company_id    = hash_encode(Auth::user()->company_id);
            $disk           = Storage::disk('qiniu');
            $dir            = "{$_company_id}/product/cover";
            $cover_url      = $disk->put($dir, $cover);
            $product->cover = $cover_url;
        }
        $product->unit    = $request->input('unit');
        $product->introduce = $request->input('intro', 0);
        $product->name         = $request->input('name');
        $product->price        = $request->input('price', 0);
        $product->old_price = $request->input('old_price', 0);
        if($product->save()) {
           
            return redirect()->route('product.product.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $_product_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($_product_id) {
        $product_id = hash_decode($_product_id);
        if(!$product_id) {
            return back()->with('alert-danger', trans('product::product.invalid'));
        }

        $product = Product::find($product_id, [ 'id']);
        if(!$product) {
            return back()->with('alert-danger', trans('product::product.not.found'));
        }
        if($product->delete()) {
           
            return redirect()->route('product.product.list')->with('alert-success', trans('main.success'));
        } else {
            return back()->with('alert-danger', trans('main.operate.invalid'));
        }
    }
}
