@extends('layouts.global')
@section('titel','Book List')
@section('content')

	<div class="row">
		<div class="col-md-6">
			<form action="{{route('books.index')}}">
				<div class="input-group">
					<input type="text" name="title" class="form-control" placeholder="Filter by Book Title"
					value="{{Request::get('title')}}">
					<div class="input-group-append">
						<input type="submit" value="Filter" class="btn btn-primary">
						<a href="{{route('books.index')}}" class="btn btn-light">Reset Filter</a>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<ul class="nav nav-pills card-header-pills">
				<li class="nav-item">
					<div class="dropdown">
					  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Status
					  </button>
					  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					    <a class="dropdown-item" href="{{route('books.index',['status'=>'publish'])}}">Publish</a>
					    <a class="dropdown-item" href="{{route('books.index',['status'=>'draft'])}}">Draft</a>
					  </div>
					</div>
				</li>

				<li class="nav-item">
					<a href="{{route('books.trash')}}" class="nav-link">Trashed</a>
				</li>
			</ul>
		</div>

		

	</div>

	<hr class="my-3">

	<div class="row">
		<div class="col-md-12">

			<div class="row mb-3">
				<div class="col-md-12 text-right">
					<a href="{{route('books.create')}}" class="btn btn-primary">Create Book</a>
				</div>
			</div>

			<table class="table table-bordered table-stripped">
				<thead>
					<tr align="center">
						<th>Cover</th>
						<th>Title</th>
						<th>Author</th>
						<th>Status</th>
						<th>Categories</th>
						<th>Stock</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($books as $book)
					<tr align="center">
						<td>
							@if($book->cover)
							<img src="{{asset('public/storage/'.$book->cover)}}" width="48px">
							@else
							No Image
							@endif
						</td>
						<td>{{$book->title}}</td>
						<td>{{$book->author}}</td>
						<td>
							@if($book->status == 'PUBLISH')
							<span class="badge bg-success">{{$book->status}}</span>
							@else
							<span class="badge bg-dark text-white">{{$book->status}}</span>
							@endif
						</td>
						<td>
							<ul class="pl-3">
								@foreach($book->categories as $category)
								<li>{{$category->name}}</li>
								@endforeach
							</ul>
						</td>
						<td>{{$book->stock}}</td>
						<td>{{$book->price}}</td>
						<td>
							<a href="{{route('books.edit', $book->id)}}" class="btn btn-primary btn-sm">Edit</a>
							<form method="POST" class="d-inline" onsubmit="return confirm('Move this book to trash?')" action="{{route('books.destroy', $book->id)}}">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<input type="submit" value="Trash" class="btn btn-warning btn-sm">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<td colspan="10">
						{{$books->appends(Request::all())->links()}}
					</td>
				</tfoot>
			</table>
		</div>
	</div>

@endsection