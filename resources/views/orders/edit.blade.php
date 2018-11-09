@extends('layouts.global')
@section('title','Edit Order')
@section('content')

	<div class="row">
		<div class="col-md-8">
			<form class="shadow-sm bg-white p-3" action="{{route('orders.update', $order->id)}}"
				method="POST">
				
				@csrf
				<input type="hidden" name="_method" value="PUT">

				<label for="invoice_number">Invoice Number</label>
				<input type="text" class="form-control" disabled value="{{$order->invoice_number}}">
				<br>

				<label for="">Buyer</label>
				<input type="text" class="form-control" disabled value="{{$order->user->name}}">
				<br>

				<label for="created_at">Order Date</label>
				<input type="text" disabled class="form-control" value="{{$order->created_at}}">
				<br>

				<label for="">Books ({{$order->totalQuantity}})</label>
				<ul>
					@foreach($order->books as $book)
						<li>{{$book->title}} <b>({{$book->pivot->quantity}})</b></li>
					@endforeach
				</ul>

				<label for="">Total Price</label>
				<input type="text" class="form-control" value="{{$order->total_price}}" disabled>
				<br>

				<label for="status">Status</label>
				<select class="form-control" name="status" id="status">
					<option {{$order->status == "SUBMIT" ? "selected" : "" }} value="SUBMIT">SUBMIT
					</option>
					<option {{$order->status == "PROCESS" ? "selected" : "" }} value="PROCESS">PROCESS
					</option>
					<option {{$order->status == "FINISH" ? "selected" : "" }} value="FINISH">FINISH
					</option>
					<option {{$order->status == "CANCEL" ? "selected" : "" }} value="CANCEL">CANCEL
					</option>
				</select>
				<br>

				<input type="submit" value="Update" class="btn btn-primary">

			</form>
		</div>
	</div>

@endsection