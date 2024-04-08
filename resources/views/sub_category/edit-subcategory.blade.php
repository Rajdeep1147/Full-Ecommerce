@extends('admin.layout.app')

    @section('content')
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Update SubCategory</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('show.subcategory') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
						
						<span id="output">@include('admin.message')</span>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                     <form id="subcategory-edit"> 						
                        @csrf
                        <div class="container-fluid">
						<div class="card">
							<div class="card-body">		
                                <div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" value="{{ $subcategory->name }}" placeholder="Name">	
											 <span id="name-error" class="text-danger"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Slug</label>
											<input type="text" name="slug" id="slug" class="form-control" value="{{ $subcategory->slug }}" placeholder="Slug">
											<span id="slug-error" class="text-danger"></span>	
										</div>
									</div>		
                                    <div class="col-md-6">
										<div class="mb-3">
											<div class="form-group">
												<label>Status</label>
												<select class="form-control" name="status" value="{{ $subcategory->status }}">
												<option value="1" <?php echo $subcategory->status == 1 ? 'selected':'';?>>Active</option>
												<option value="0" <?php echo $subcategory->status == 0 ? 'selected':'';?> >Block</option>
												</select>
												<span id="status-error" class="text-danger"></span>
											</div>
										</div>
									</div>		
								
                                    <div class="col-md-6">
                     <div class="mb-3">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="" disabled>Select Category</option>
        @if(!empty($categories))
            @foreach ($categories as $category)
                <option  {{ $subcategory->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        @endif
    </select>
    <span id="category_id-error" class="text-danger"></span>
</div>
                    </div>
                           </div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary">Update</button>
							<a href="{{ route('show.subcategory') }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                         </form>
						 
					</div>
					<!-- /.card -->
				</section>
	@endsection	

@section('custom-js')

<script>
    $(document).ready(function(){
        $("#subcategory-edit").submit(function(e){	
            e.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);
			

            $.ajax({
                type: 'POST',
                url: '{{ route("update.subcategory",$subcategory->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
						if (response) {
							window.location.href="{{ route('show.subcategory') }}"
							$(".text-danger").text(''); 
						
						}
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