@extends('layouts.global')
@section('title','List Order')
@section('content')

	<form action="{{route('orders.index')}}">
	<div class="row">
		<div class="col-md-5">
			<input type="text" name="name" class="form-control" placeholder="Search by Name"
			value="{{Request::get('name')}}">
		</div>
		<div class="col-md-2">
			<select name="status" id="status" class="form-control">
				<option value="">Any</option>
				<option {{Request::get('status') == "SUBMIT" ? "selected" : ""}} value="SUBMIT">SUBMIT</option>
				<option {{Request::get('status' == "PROCESS" ? "selected" : "")}} value="PROCESS">PROCESS</option>
				<option {{Request::get('status') == "FINISH" ? "selected" : ""}} value="FINISH">FINISH</option>
				<option {{Request::get('status') == "CANCEL" ? "selected" : ""}} value="CANCEL">CANCEL</option>
			</select>
		</div>
		<div class="col-md-4">
			<input type="submit" value="Filter" class="btn btn-primary">
			<a href="{{route('orders.index')}}" class="btn btn-light">Reset Filter</a>
		</div>
	</div>
	</form>

	<hr class="my-3">

	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-stripped">
				<thead>
					<tr align="center">
						<th>Invoice Number</th>
						<th>Status</th>
						<th>Buyer</th>
						<th>Total Quantity</th>
						<th>Order Date</th>
						<th>Total Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orders as $order)
					<tr align="center">
						<td>
							{{$order->invoice_number}}
						</td>
						<td>
							@if($order->status == "SUBMIT")
							<span class="badge bg-warning text-light">{{$order->status}}</span>
							@elseif($order->status == "PROCESS")
							<span class="badge bg-info text-light">{{$order->status}}</span>
							@elseif($order->status == "FINISH")
							<span class="badge bg-success text-light">{{$order->status}}</span>
							@elseif($order->status == "CANCEL")
							<span class="badge bg-danger text-light">{{$order->status}}</span>
							@endif
						</td>
						<td>
							{{$order->user->name}}
						</td>
						<td>{{$order->totalQuantity}}</td>
						<td>{{$order->created_at}}</td>
						<td>{{$order->total_price}}</td>
						<td>
							<a href="{{route('orders.edit', $order->id)}}" class="btn btn-primary btn-sm">Edit</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection