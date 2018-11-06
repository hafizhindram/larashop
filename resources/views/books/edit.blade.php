@extends('layouts.global')
@section('title','Edit Book')
@section('content')

	<div class="row">
		<div class="col-md-8">
			<form method="POST" action="{{route('books.update', $book_edit->id)}}" enctype="multipart/form-data"
				class="p-3 shadow-sm bg-white">
					
					@csrf
					<input type="hidden" name="_method" value="PUT">

					<label for="title">Title</label>
					<input type="text" name="title" class="form-control" value="{{$book_edit->title}}" placeholder="Book Title">
					<br>

					<label for="cover">Current Cover</label>
					<br>
					@if($book_edit->cover)
					<img src="{{asset('public/storage/'.$book_edit->cover)}}" width="96px">
					@else
					No Image
					@endif
					<br>
					<input type="file" name="cover" class="form-control">
					<small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>

					<label for="slug">Slug</label>
					<input type="text" name="slug" value="{{$book_edit->slug}}" class="form-control" placeholder="enter-new-slug">
					<br>

					<label for="description">Description</label>
					<textarea type="text" id="description" name="description"  class="form-control">{{$book_edit->description}}</textarea>

					<label for="categories">Categories</label>
					<select multiple class="form-control" name="categories[]" id="categories"></select>
					<br>

					<label for="stock">Stock</label>
					<input type="number" min="0" name="stock" class="form-control" id="stock" placeholder="Stock"
					value="{{$book_edit->stock}}">
					<br>

					<label for="author">Author</label>
					<input type="text" name="author" class="form-control" value="{{$book_edit->author}}"
					placeholder="Author" id="author">
					<br>

					<label for="publisher">Publisher</label>
					<input type="text" name="publisher" class="form-control" id="publisher" value="{{$book_edit->publisher}}" placeholder="Publisher">
					<br>

					<label for="price">Price</label>
					<input type="text" name="price" id="price" placeholder="Price" value="{{$book_edit->price}}" class="form-control">
					<br>

					<label for="status">Status</label>
					<select name="status" id="status" class="form-control">
						<option {{$book_edit->status == 'PUBLISH' ? 'selected' : ""}} value="PUBLISH">PUBLISH
						</option>
						<option {{$book_edit->status == 'DRAFT' ? 'selected' : ""}} value="DRAFT">DRAFT
						</option>
					</select>
					<br>

					<button class="btn btn-primary" value="PUBLISH">Update</button>

				</form>
		</div>
	</div>

@endsection
@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-
rc.0/css/select2.min.css" rel="stylesheet" />
<script 
	src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js">
</script>
<script>
$('#categories').select2({
 ajax: {
 url: 'http://localhost/larashop/ajax/categories/search',
 	processResults: function(data){
 		return {
 	results: data.map(function(item){return {id: item.id, text:item.name} })
 		}
 	}
 }
});
var categories = {!! $book_edit->categories !!}
 	categories.forEach(function(category){
 		var option = new Option(category.name, category.id, true, true);
 	$('#categories').append(option).trigger('change');
 });
</script>
@endsection
