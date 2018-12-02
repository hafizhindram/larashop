@extends('layouts.global')
@section('title', 'List Category')
@section('content')

	<div class="row">
		<div class="col-md-6">
			<form action="{{route('categories.index')}}">
				<div class="input-group">
					<input type="text" name="name" class="form-control" placeholder="Filter by Category name"
					value="{{Request::get('name')}}">
					<div class="input-group-append">
						<input type="submit" value="Filter" class="btn btn-primary">
						<a href="{{route('categories.index')}}" class="btn btn-light">Reset Filter</a>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<ul class="nav nav-pills card-header-pills">
				<li class="nav-item">
					<a class="nav-link active" href="{{route('categories.index')}}">Published</a>
				</li>

				<li class="nav-item">
					<a href="{{route('categories.trash')}}" class="nav-link">Trashed</a>
				</li>
			</ul>
		</div>
	</div>

	<hr class="my-3">

	<div class="row">
		<div class="col-md-12">

			<div class="row mb-3">
				<div class="col-md-12 text-right">
					<a href="{{route('categories.create')}}" class="btn btn-primary">Create Category</a>
				</div>
			</div>

			<table class="table table-bordered table-striped">
				<thead>
					<tr align="center">
						<th>Name</th>
						<th>Slug</th>
						<th>Image</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
					<tr align="center">
						<td>{{$category->name}}</td>
						<td>{{$category->slug}}</td>
						<td>
							@if($category->image)
							<img src="{{asset('public/storage/'. $category->image)}}" width="48px">
							@else
							No Image
							@endif
						</td>
						<td>
							<a href="{{route('categories.edit', $category->id)}}" class="btn btn-info btn-sm">Edit</a>
							<a href="{{route('categories.show', $category->id)}}" class="btn btn-primary btn-sm">Detail</a>
							<form class="d-inline" method="POST" action="{{route('categories.destroy', $category->id)}}" onsubmit="return confirm('Move category to trash')">
								@csrf
								<input type="hidden" name="_method" value="Delete">
								<input type="submit" value="Trash" class="btn btn-warning btn-sm">

							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection