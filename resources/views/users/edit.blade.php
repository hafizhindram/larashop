@extends('layouts.global')
@section('title','Edit User')
@section('content')

	<div class="col-md-8">

{{-- 		@if(session('status'))
			<div class="alert alert-success">
				{{session('status')}}
			</div>
		@endif --}}
		
		<form enctype="multipart/form-data" class="bg-white shadow-sm p-3" 
	action="{{route('users.update', $user->id)}}" method="POST">
		@csrf
		<input type="hidden" name="_method" value="PUT">

		<label for="name">Name</label>
		<input type="text" name="name" id="name" placeholder="Full Name" class="form-control" value="{{$user->name}}">
		<br>

		<label for="username">Username</label>
		<input value="{{$user->username}}" disabled class="form-control" placeholder="username" type="text" name="username" id="username"/>
		<br>

		<label for="">Status</label>
		<br>
		<input type="radio" value="ACTIVE" class="form-control" name="status" id="active" {{$user->status == "ACTIVE" ? "checked" : ""}}>
		<label for="active">Active</label>
		<input type="radio" name="status" value="INACTIVE" class="form-control" id="inactive" {{$user->status == "INACTIVE" ? "checked" : ""}}>
		<label for="inactive">InActive</label>

		<br>
		<label for="">Roles</label>
		<br>
		<input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}}>
		<label for="ADMIN">Administrator</label>
		<input type="checkbox" name="roles[]" id="STAFF" value="STAFF" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}}>
		<label for="STAFF">Staff</label>
		<input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER" {{in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : ""}}>
		<label for="CUSTOMER">Customer</label>
		<br>

		<label for="phone">Phone</label>
		<input type="text" name="phone" class="form-control" value="{{$user->phone}}">
		<br>

		<label for="address">Address</label>
		<textarea name="address" id="address" class="form-control">{{$user->address}}</textarea>
		
		<label for="avatar">Avatar Image</label>
		<br>Current Avatar :<br>
		@if($user->avatar)
		<img src="{{asset('public/storage/'.$user->avatar)}}" width="120px">
		<br>
		@else
		No Avatar
		@endif
		<br>
		<input type="file" name="avatar" id="avatar" class="form-control">
		<small class="text-muted">Kosongkan jika tidak ingin mengubah Avatar</small>

		<hr class="my-3">

		<label for="email">Email</label>
		<input type="email" name="email" id="email" placeholder="user@email.com" class="form-control" disabled value="{{$user->email}}">
		<br>
		<input type="submit" class="btn btn-primary" value="save">
		</form>
	</div>

@endsection
