@extends('layouts.global')
@section('title','Detail User')
@section('content')

	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<b>Nama</b>
				<br>
				{{$user->name}}
				<br>

				@if($user->avatar)
				<img src="{{asset('public/storage/'.$user->avatar)}}" width="250px">
				@else
				No Avatar
				@endif
				<br>
				<br>

				<b>Username</b>
				<br>
				{{$user->username}}
				<br>

				<b>Phone Number</b>
				<br>
				{{$user->phone}}
				<br>

				<b>Address</b>
				<br>
				{{$user->address}}
				<br>

				<b>Roles</b>
				@foreach(json_decode($user->roles) as $role) &middot; {{$role}}
				<br>
				@endforeach
			</div>
		</div>
	</div>

@endsection