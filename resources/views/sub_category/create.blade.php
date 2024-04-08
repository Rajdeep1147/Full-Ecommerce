@extends('admin.layout.app')

@section('content')
	<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Sub Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('show.subcategory') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					@include('admin.message')
					<!-- Default box -->
                     <form id="subcategory-form"> 
    @csrf
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">     
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                            <span id="name-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                            <span id="slug-error" class="text-danger"></span>
                        </div>
                    </div>      
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-group">
                                <label>Status</label>
								
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id">Category</label>
                              <select name="category_id" id="category_id" class="form-control">
								<option value="" disabled selected >Select Category</option>
								@if(!empty($categories))
									@foreach ($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								@endif
								
							</select>
							
							<span id="category_id-error" class="text-danger"></span>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button class="btn btn-primary">Create</button>
            <a href="{{ route('show.subcategory') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
</form>

					</div>
					<!-- /.card -->
				</section>
@endsection

@section('custom-js')
	<script>
		$(document).ready(function(){
			$("#subcategory-form").submit(function(e){
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: 'POST',
					url: "{{ route('store.subcategory') }}",
					data: formData,
					contentType: false,
					processData: false,
					success: function(response){
						if (response) {
							window.location.href="{{ route('show.subcategory') }}"
							$(".text-danger").text(''); 
						
						}
					},
					error: function(xhr) {
						var errors = xhr.responseJSON.errors;
						$.each(errors, function(key, value) {
							// Display validation error messages
							$("#" + key + "-error").text(value[0]);
						});
					}
				});
			});
			// Clear error messages on input focus
			$("#category-form input").on("focus", function() {
				var fieldName = $(this).attr("name");
				$("#" + fieldName + "-error").text('');
			});
	});
	</script>

@endsection