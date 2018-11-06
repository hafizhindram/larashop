@extends('layouts.global')
@section('title', 'Trashed Categories')
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
					<a class="nav-link" href="{{route('categories.index')}}">Published</a>
				</li>

				<li class="nav-item">
					<a href="{{route('categories.trash')}}" class="nav-link active">Trashed</a>
				</li>
			</ul>
		</div>
	</div>

	<hr class="my-3">

	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Slug</th>
						<th>Image</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($deleted_category as $category)
					<tr>
						<td>{{$category->name}}</td>
						<td>{{$category->slug}}</td>
						<td>
							@if($category->image)
							<img src="{{asset('public/storage/'.$category->image)}}" width="48px">
							@else
							No Image
							@endif
						</td>
						<td>
							<a href="{{route('categories.restore', $category->id)}}" class="btn btn-success btn-sm">Restore</a>
							<form class="d-inline" action="{{route('categories.delete-permanent', $category->id)}}" method="POST" onsubmit="return confirm('Delete this category Permanently?')">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<input type="submit" value="Delete" class="btn btn-danger btn-sm">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10">{{$deleted_category->appends(Request::all())}}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

@endsection