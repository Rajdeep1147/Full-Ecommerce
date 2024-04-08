@extends('admin.layout.app')

    @section('content')
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Update Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('show.category') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
						
						<span id="output">@include('admin.message')</span>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                     <form id="category-edit"> 						
                        @csrf
                        <div class="container-fluid">
						<div class="card">
							<div class="card-body">		
                                <div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" placeholder="Name">	
											 <span id="name-error" class="text-danger"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Slug</label>
											<input type="text" name="slug" id="slug" class="form-control" value="{{ $category->slug }}" placeholder="Slug">
											<span id="slug-error" class="text-danger"></span>	
										</div>
									</div>		
                                    <div class="col-md-6">
										<div class="mb-3">
											<div class="form-group">
												<label>Status</label>
												<select class="form-control" name="status" value="{{ $category->status }}">
												<option value="1" <?php echo $category->status == 1 ? 'selected':'';?>>Active</option>
												<option value="0" <?php echo $category->status == 0 ? 'selected':'';?> >Block</option>
												</select>
												<span id="status-error" class="text-danger"></span>
											</div>
										</div>
									</div>		
									{{-- {{ dd($category->vehicle) }} 	 --}}
									<div class="col-md-6">
										<label for="status">Vehicle</label>
										<input type="checkbox" name="vehicle[]" id="car" value="car" <?php echo strpos($category->vehicle, 'car') !== false ? 'checked' : ''; ?>>Car
										<input type="checkbox" name="vehicle[]" id="bike" value="bike" <?php echo strpos($category->vehicle, 'bike') !== false ? 'checked' : ''; ?>>Bike
										<input type="checkbox" name="vehicle[]" id="scooty" value="scooty" <?php echo strpos($category->vehicle, 'scooty') !== false ? 'checked' : ''; ?>>Scooty

									</form>
										<span id="vehicle-error" class="text-danger"></span>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="image">Upload Image:</label>
											@if($category->image)
												<img src="{{ asset('new_image/' . $category->image) }}" alt="Category Image" height="100px" width="220px">
											@else
												<p>No image uploaded for this category.</p>
											@endif
											<input type="file" name="image" id="image" class="form-control-file" accept="image/*" aria-describedby="imageHelpBlock">
											<small id="imageHelpBlock" class="form-text text-muted">@if($category->image) @else Please choose an image file (JPG, JPEG, PNG, or GIF). @endif</small>
										</div>

									<span id="image-error" class="text-danger"></span>	
								</div>
                           
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary">Update</button>
							<a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                         </form>
						 
					</div>
					<!-- /.card -->
				</section>
	@endsection	

@section('custom-js')

<script>
    $(document).ready(function(){
        $("#category-edit").submit(function(e){
            e.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: '{{ route("update.category",$category->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.success){
                        $("#category-name").text(response.success); 
                        
                        $("#output").text(response.success); 
                    } else {
                        $("#output").text('Category Updation Fail'); 
                    }
                    // Reload the page
                    location.reload();
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Show error message
                    $("#output").text('Error: ' + xhr.responseText); 
                }
            });
        });
    });
</script>



@endsection