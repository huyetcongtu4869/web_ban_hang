<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function League\Flysystem\get;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $title = "hello laravel";
        $name = "tuntuncute";
        $category = DB::table('category')
                    ->get();
      
        return view('category.category', compact('title', 'name', 'category'));
    }
    public function addCategory(CategoryRequest $request)
    {
        if ($request->isMethod('POST')) { 
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['image'] = uploadFile('hinh', $request->file('image'));
            }

            $category = category::create($params);

            if ($category->id) {
                Session::flash('success', 'Thêm mới thành công');
                return redirect('/adminCategory');
            }
        }
        return view('category.add');
    }
    public function editCategory(CategoryRequest $request, $id)
    {
       
        $category = category::find($id);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $resultDL = Storage::delete('/public/' . $category->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('hinh', $request->file('image'));
                } else {
                    $params['image'] = $category->image;
                }
            }
            $result = category::where('id', $id)
                ->update($params);
            if ($result) {
                Session::flash('success', 'Sửa thành công');
                return redirect('/adminCategory');
            }
        }
        return view('category.edit',compact('category'));
    }
    public function delete($id)
    {
        category::where('id', $id)->delete();
        Session::flash('success', 'xóa thành công');
        return redirect('/adminCategory');
    }
}
