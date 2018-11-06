@extends('layouts.global')
@section('title','Create New User')
@section('content')

	<div class="col-md-8">
{{-- 
	@if(session('status'))
	 <div class="alert alert-success">
	 {{session('status')}}
	 </div>
	@endif --}}
	

	<form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.store')}}" 
	method="POST">

		@csrf

		<label for="name">Name</label>
		<input type="text" name="name" class="form-control" id="name" placeholder="Full Name">
		<br>

		<label for="username">Username</label>
		<input type="text" name="username" id="username" class="form-control" placeholder="Username">
		<br>

		<label for="">Roles</label>
		<br>

		<input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
		<label for="ADMIN">Administrator</label>
		<input type="checkbox" name="roles[]" id="STAFF" value="STAFF">
		<label for="STAFF">Staff</label>
		<input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
		<label for="CUSTOMER">Customer</label>

		<br>
		<label for="phone">Phone Number</label>
		<input type="text" name="phone" class="form-control">

		<br>
		<label for="phone">Address</label>
		<textarea id="address" name="address" class="form-control"></textarea> 

		<br>
		<label for="avatar">Avatar Image</label>
		<br>
		<input type="file" name="avatar" id="avatar" class="form-control">

		<hr class="my-3">

		<label for="email">Email</label>
		<input type="email" name="email" placeholder="user@email.com" id="email" class="form-control">

		<br>
		<label for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" placeholder="Password">

		<br>
		<label for="password_confirmation">Password Confirmation</label>
		<input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" id="password_confirmation">

		<br>
		<input type="submit" class="btn btn-primary" value="Save">

	</form>

	</div>

@endsection