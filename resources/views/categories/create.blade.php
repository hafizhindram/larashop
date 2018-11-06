@extends('layouts.global')
@section('title', 'Create Category')
@section('content')

	<form enctype="multipart/form-data" class="bg-white shadow-sm p-3" method="POST" 
	action="{{route('categories.store')}}">
		
		@csrf

		<label>Category Name</label>
		<br>
		<input type="text" name="name" class="form-control">

		<label>Category Image</label>
		<input type="file" name="image" class="form-control">
		<br>

		<input type="submit" class="btn btn-primary" value="Save">

	</form>

@endsection