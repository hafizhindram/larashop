@extends('layouts.global')
@section('title','Trashed Book')
@section('content')

	<div class="row">
		<div class="col-md-12">
			
			<table class="table table-bordered table-stripped">
				<thead>
					<tr>
						<th>Cover</th>
						<th>Title</th>
						<th>Author</th>
						<th>Categories</th>
						<th>Stock</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($book_deleted as $book)
					<tr>
						<td>
							@if($book->cover)
							<img src="{{asset('public/storage/'.$book->cover)}}" width="48px">
							@else
							No Cover
							@endif
						</td>
						<td>{{$book->title}}</td>
						<td>{{$book->author}}</td>
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
							<a href="{{route('books.restore', $book->id)}}" class="btn btn-success btn-sm">Restore</a>
							<form method="POST" action="{{route('books.delete-permanent', $book->id)}}" class="d-inline" onsubmit="return confirm('Delete this book permanently?')">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<input type="submit" value="Delete" class="btn btn-danger btn-sm">
							</form>
						</td>
					</tr>
					
					@endforeach
				</tbody>
			</table>

		</div>
	</div>

@endsection