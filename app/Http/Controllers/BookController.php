<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Book;
use App\Category;
use Session;

class BookController extends Controller
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
            if(Gate::allows('manage-books')) return $next($request);

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

        $filterKeyword = $request->get('title');
        if($filterKeyword){
            $books = Book::where('title', 'LIKE', "%$filterKeyword%")->paginate(10);
        }

        $status = $request->get('status');
        if($status){
            $books = Book::where('status', strtoupper($status))->paginate(10);
        }else{
            $books = Book::with('categories')->paginate(10);
        }

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('books.create');

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
            'title'=>'required|min:5|max:100',
            'description'=>'"required|min:20|max:1000',
            'author'=>'required|min:3|max:100',
            'publisher'=>'required|min:3|max:191',
            'price'=>'required|digits_between:0,10',
            'stock' => 'required|digits_between:0,10',
        ));

        $new_book = new Book;
        $new_book->title = $request->get('title');
        $new_book->cover = $request->get('cover');
        $new_book->description = $request->get('description');
        $new_book->author = $request->get('author');
        $new_book->publisher = $request->get('publisher');
        $new_book->price = $request->get('price');
        $new_book->stock = $request->get('stock');
        $new_book->status = $request->get('save_action');


        if($request->file('cover')){
            $cover = $request->file('cover')->store('book_covers', 'public');
            $new_book->cover = $cover;
        }
        $new_book->slug = str_slug($request->get('title'));
        $new_book->created_by = \Auth::user()->id;

        $new_book->save();

        $new_book->categories()->attach($request->get('categories'));

        if($request->get('save_action') == 'PUBLISH'){
            Session::flash('success', 'Book successfully saved and Published');
            return redirect()->route('books.index');
        }else{
            Session::flash('success', 'Book successfully saved as Draft');
            return redirect()->route('books.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book_edit = Book::findOrFail($id);

        return view('books.edit', compact('book_edit'));
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
            'title'=>'required|min:5|max:191',
            'slug' => ['required', Rule::unique('books')->ignore($books->slug, 'slug')],
            'description' => 'required|min:20|max:1000',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:191',
            'price' => 'required|digits_between:0,10',
            'stock' => 'required|digits_between:0,10'
        ));

        $book = Book::findOrFail($id);

        $book->title = $request->get('title');
        $book->slug = $request->get('slug');
        $book->description = $request->get('description');
        $book->author = $request->get('author');
        $book->publisher = $request->get('publisher');
        $book->stock = $request->get('stock');
        $book->price = $request->get('price');

        if($request->file('cover')){
            if($book->cover && file_exists(storage_path('app/public'.$book->cover))){
                \storage::delete('public/'.$book->cover);
            }
            $new_cover_path = $request->file('cover')->store('book-covers','public');
            $book->cover = $new_cover_path;
        }
        $book->updated_by = \Auth::user()->id;

        $book->status = $request->get('status');
        $book->save();
        $book->categories()->sync($request->get('categories'));

        Session::flash('Success', 'Book successfully edited');

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        Session::flash('success', 'Book successfully moved to trash');
        return redirect()->route('books.trash');
    }

    public function trash(){
        $book_deleted = Book::onlyTrashed()->paginate(10);

        return view('books.trash', compact('book_deleted'));
    }

    public function restore($id){
        $book = Book::withTrashed()->findOrFail($id);

        if($book->trashed()){
            $book->restore();
            Session::flash('success', 'Book successfully restored');
            return redirect()->route('books.index');
        }else{
            Session::flash('success', 'Book is not in trash');
            return redirect()->route('books.trash');
        }
    }

    public function deletePermanent($id){
        $book = Book::withTrashed()->findOrFail($id);

        if(!$book->trashed()){
            Session::flash('success','Book is not in trash');
            return redirect()->route('books.trash');
        }else{
            $book->categories()->detach();
            $book->forceDelete();

            Session::flash('success','Book permanently deleted');
            return redirect()->route('books.index');
        }
    }
}
