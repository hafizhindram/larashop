@extends('layouts.global')
@section('title','Edit Category')
@section('content')

	<div class="col-md-8">
		<form action="{{route('categories.update', $category_to_edit->id)}}" enctype="multipart/form-data"
			method="POST" class="bg-white shadow-sm p-3">
				
			@csrf
			<input type="hidden" value="PUT" name="_method">

			<label>Category Name</label>
			<input type="text" name="name" class="form-control" value="{{$category_to_edit->name}}">
			<br>

			<label>Category Slug</label>
			<input type="text" name="slug" class="form-control" value="{{$category_to_edit->slug}}" disabled>
			<br>

			<label>Current image</label><br>
			@if($category_to_edit->image)
				<img src="{{asset('public/storage/'. $category_to_edit->image)}}" width="120px">
				<br>
			@endif
			<br>

			<input type="file" name="image" class="form-control">
			<small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
			<br><br>

			<input type="submit" value="Save" class="btn btn-primary">

		</form>
	</div>

@endsection