@extends('layouts.global')
@section('title', 'User List')
@section('content')

	<form action="{{route('users.index')}}">
	<div class="row">
		
		<div class="col-md-6">
			<input type="text" name="keyword" class="form-control" 
			value="{{Request::get('keyword')}}" placeholder="Filter berdasarkan email">		
		</div><!--div class col-md-6-->
		
		<div class="col-md-6">
			<input type="radio" name="status" value="ACTIVE" class="form-control" id="active" 
			{{Request::get('status') == 'ACTIVE' ? 'checked' : ""}}>
			<label for="active">Active</label>
			<input type="radio" name="status" value="INACTIVE" class="form-control" id="inactive"
			{{Request::get('status') == 'INACTIVE' ? 'checked' : ""}}>
			<label for="inactive">InActive</label>
			<input type="submit" value="Filter" class="btn btn-primary">
			<a href="{{route('users.index')}}" class="btn btn-light">Reset Filter</a>
			
		</div>
		
	</div>
	</form>

	<hr class="my-3">

	<div class="row">
		<div class="col-md-12 text-right">
			<a href="{{route('users.create')}}" class="btn btn-primary" style="margin-bottom: 20px">Create User</a>
		</div>
	</div>

	<table class="table table bordered table-striped">
		<thead>
			<tr align="center">
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Avatar</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr align="center">
				<td>{{$user->name}}</td>
				<td>{{$user->username}}</td>
				<td>{{$user->email}}</td>
				<td>
					@if($user->avatar)
					<img src="{{asset('public/storage/' . $user->avatar)}}" width="70px">
					@else N/A
					@endif
				</td>
				<td>
					@if($user->status == "ACTIVE")
					<span class="badge badge-success">
						{{$user->status}}
					</span>
					@else
					<span class="badge badge-danger">
						{{$user->status}}
					</span>
					@endif
				</td>
				<td>
					<a href="{{route('users.edit',$user->id)}}" class="btn btn-info text-white btn-sm">Edit</a>
					<a href="{{route('users.show', $user->id)}}" class="btn btn-primary btn-sm">Detail</a>
					<form onsubmit="return confirm('Delete this user permanently?')" class="d-inline" 
					action="{{route('users.destroy', $user->id)}}" method="POST">
						@csrf
						<input type="hidden" name="_method" value="DELETE">
						<input type="submit" value="Delete" class="btn btn-danger btn-sm">
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<!-- Pagination -->
    <ul class="pagination justify-content-center mb-4">
      <li class="page-item">
      </li>
      {{ $users->appends(Request::all())->links()}}
      <li class="page-item disabled">
      </li>
    </ul>

@endsection