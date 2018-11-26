<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Category;
use Session;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function($request, $next){
            if(Gate::allows('manage-categories')) return $next($request);

            abort(403, 'Anda tidak memiliki cukup hak akases');
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(10);

        $filterKeyword = $request->get('name');
        if($filterKeyword){
            $categories = Category::where('name', 'LIKE', "%$filterKeyword%")->paginate(10);
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

             $this->validate ($request, array(
            'name'=>'required|min:5|max:100',
            'image'=>'required'
            ));

            $name = $request->get('name');

            $new_category = new Category;
            $new_category->name = $name;

            if($request->file('image')){
                $image_path = $request->file('image')
                ->store('category_images', 'public');

                $new_category->image = $image_path;

            $new_category->created_by = \Auth::user()->id;
            $new_category->slug = str_slug($name);

            $new_category->save();

            Session::flash('success', 'Kategori berhasil ditambah');

            return redirect()->route('categories.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_to_edit = Category::findOrFail($id);

        return view('categories.edit', compact('category_to_edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'name'=>'required',
            'slug' => ['required', Rule::unique('categories')->ignore($category->slug, 'slug')]
        ));

        $name = $request->get('name');
        $category = Category::findOrFail($id);
        $category->name = $name;
        if($request->file('image')){
            if($category->image && file_exists(storage_path('app/public'.$category->image))){
                \Storage::delete('public/'.$category->image);
            }
            $new_image = $request->file('image')->store('category_images', 'public');
            $category->image = $new_image;
        }
        $category->updated_by = \Auth::user()->id;
        $category->slug = str_slug($name);
        $category->save();

        Session::flash('success', 'Data berhasil diedit');

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        Session::flash('success', 'Category successfully moved to trash');

        return redirect()->route('categories.index');
    }

    public function trash()
    {
        $deleted_category = Category::onlyTrashed()->paginate(10);

        return view('categories.trash', compact('deleted_category'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if($category->trashed()){
            $category->restore();
        }else{
            Session::flash('success', 'Category is not in trash');

            return redirect()->route('categories.index');
        }
        Session::flash('success', 'Category successfully restored');

        return redirect()->route('categories.index');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if(!$category->trashed()){
            Session::flash('success','Can not delete permanent this Category');
            return redirect()->route('categories.index');
        }else{
            $category->forceDelete();
            Session::flash('success', 'Category permanently deleted');
            return redirect()->route('categories.index');
        }
    }

    public function ajaxSearch(Request $request){
        $keyword = $request->get('q');

        $categories = Category::where('name', 'LIKE', "%$keyword%")->get();

        return $categories;
    }
}
