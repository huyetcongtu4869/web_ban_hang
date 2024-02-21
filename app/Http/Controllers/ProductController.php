<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
class ProductController extends Controller
{
    public function index()
    {
        $title = "hello word";
        $name = "thực tập";
        $product = Product::whereNull('deleted_at')
        ->leftJoin('category', 'category.id', '=', 'category_id')
        ->select('product.*', 'category.name as name_category')
        ->get();
        return view('admin.product', compact('title', 'name', 'product'));
    }
    public function addProduct(ProductRequest $request)
    {
        if ($request->isMethod('POST')) { 
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['image'] = uploadFile('hinh', $request->file('image'));
            }
            $product = Product::create($params);
            if ($product->id) {
                Session::flash('success', 'Thêm mới thành công');
                return redirect('/adminProduct');
            }
        }
        $category = Category::all();
        return view('admin.add', compact('category'));
    }
    public function editProduct(ProductRequest $request, $id)
    {
       
        $product = Product::find($id);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $resultDL = Storage::delete('/public/' . $product->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('hinh', $request->file('image'));
                } else {
                    $params['image'] = $product->image;
                }
            }
            $params['status'] = $params['quantity'] > 0 ? 'valid' : 'invalid';
            $result = Product::where('id', $id)
                ->update($params);
            if ($result) {
                Session::flash('success', 'Sửa thành công');
                return redirect('/adminProduct');
            }
        }
        $category = Category::all();
        return view('admin.edit', compact('product', 'category'));
    }
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        Session::flash('success', 'xóa thành công');
        return redirect('/adminProduct');
    }
}
