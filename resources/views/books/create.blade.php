@extends('layouts.global')
@section('title','Create New Book')
@section('content')

	<div class="row">
		<div class="col-md-8">
			<form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data"
			class="shadow-sm p-3 bg-white">
				
				@csrf

				<label for="title">Title</label>
				<br>
				<input type="text" name="title" class="form-control" placeholder="Book title">
				<br>

				<label for="cover">Cover</label>
				<input type="file" name="cover" class="form-control">
				<br>

				<label for="description">Description</label>
				<textarea name="description" id="description" class="form-control" placeholder="Give description for this book"></textarea>
				<br>
				
				{{-- <label for="categories">Categories</label>
				<br>
				<select name="categories[]" multiple id="categories" class="form-control"> --}}
					{{-- <option value="-">Pilih Kategori</option>
					@foreach($categories as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
					@endforeach --}}
				{{-- </select>
				<br> --}}
				<label for="categories">Categories</label><br>
		        <select name="categories[]" multiple id="categories" class="form-control"></select>
		        <br><br>

				<label for="stock">Stock</label>
				<input type="number" name="stock" class="form-control" id="stock" min="0" value="0">
				<br>

				<label for="author">Author</label>
				<input type="text" name="author" id="author" class="form-control" placeholder="Book author">
				<br>

				<label for="publisher">Publisher</label>
				<input type="text" name="publisher" id="publisher" class="form-control" placeholder="Book publisher">
				<br>

				<label for="price">Price</label>
				<input type="number" name="price" class="form-control" id="price" placeholder="Book price">
				<br>

				<button class="btn btn-success" name="save_action" value="PUBLISH">PUBLISH</button>
				<button class="btn btn-warning" name="save_action" value="DRAFT">DRAFT</button>

			</form>
		</div>
	</div>

@endsection
@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
$('#categories').select2({
  ajax: {
    url: 'http://localhost/larashop/ajax/categories/search',
    processResults: function(data){
      return {
        results: data.map(function(item){return {id: item.id, text: item.name} })
      }
    }
  }
});
</script>
@endsection