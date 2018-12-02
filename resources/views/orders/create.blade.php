@extends('layouts.global')
@section('title','Create Order')
@section('content')

	<?php
	$conn=mysqli_connect("localhost","root","","larashop");
	$query = "SELECT max(invoice_number) as maxId from orders";
	$hasil = mysqli_query($conn,$query);
	$data = mysqli_fetch_array($hasil);
	$idDaftar = $data['maxId'];
	$noUrut = (int) substr($idDaftar, 3, 3);
	$noUrut++;
	$char = "IM";
	$newID = $char . sprintf("%03s", $noUrut);

	?>

	<div class="row">
		<div class="col-md-8">
			
			<form enctype="multipart/form-data"
			class="shadow-sm p-3 bg-white" name="form1">
				
				@csrf

				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" disabled value="{{Auth::user()->name}}" style="background-color: #e7ecf1">

				<label for="title">Invoice Number</label>
				<input type="text" name="invoice_number" disabled class="form-control" value="<?php echo $newID; ?>" style="background-color: #e7ecf1">

				<label>Judul Buku</label>
				<select name="book" id="book" class="form-control" onChange="myFunction1();">
					<option value="-">--Pilih Judul--</option>
					{{-- @foreach($judulbuku as $jb)
					<option value="{{$jb->id}}">{{$jb->name}}</option>
					@endforeach --}}
					<?php
					$conn=mysqli_connect("localhost","root","","larashop");
						$sql = "SELECT * from books";
						$qry = mysqli_query($conn,$sql);
						while($data2=mysqli_fetch_array($qry))
						{
							?>
                            <option value="<?php echo $data2['id']; ;?>" data-nasabah="<?php echo $data2['price']; ;?>"><?php echo $data2['title']; ?></option>
                            <?php	
						}
					?>
				</select>

				<label>Harga</label>
				<input type="text" name="harga" id="harga" class="form-control">

				<label>Jumlah Beli</label>
				<input type="number" name="qty" id="qty" class="form-control" min="0" value="0">

				<label>Total Harga</label>
				<input type="double" name="totalharga" id="totalharga" class="form-control" disabled style="background-color: #e7ecf1">

			</form>

		</div>
	</div>	 

	

@endsection

<script>
	function myFunction1() 
	{
		
		var x = $("#book").find(':selected').data("nasabah")
		document.getElementById("harga").value=x;
	}
		$("#book").change(function() {
		});

		
</script>