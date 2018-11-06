@extends('layouts.global')
@section('title', 'Detail Category')
@section('content')

	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<label><b>Category Name</b></label>
				<br>
				{{$category->name}}

				<br>
				<label><b>Category Slug</b></label>
				<br>
				{{$category->slug}}

				<br>
				<label><b>Category Image</b></label>
				<br>
				@if($category->image)
				<img src="{{asset('public/storage/'.$category->image)}}" width="250px">
				@else
				No Image
				@endif
			</div>
		</div>
	</div>

@endsection