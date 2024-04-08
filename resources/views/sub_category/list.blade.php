@extends('admin.layout.app')
    @section('content')
				<section class="content-header">					
					<div class="container-fluid my-2">
						
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Sub Categories</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('create.subcategory') }}" class="btn btn-primary">New Subcategory</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					@include('admin.message')
					<!-- Default box -->
					<div class="container-fluid">
						<form method="get" id= "myForm">
						<div class="card">
							<div class="card-header">
								<div class="card-title">
									<button type="button" class="btn btn-default btn-sm" onclick="resetForm()">Reset</button>
								</div>
								<div class="card-tools">
									<div class="input-group input-group" style="width: 250px;">
										<input type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{ Request::get('keyword') }}">
					
										<div class="input-group-append">
										  <button type="submit" class="btn btn-default">
											<i class="fas fa-search"></i>
										  </button>
										</div>
									  </div>
								</div>
							</div>
							<div class="card-body table-responsive p-0">								
								<table class="table table-hover text-nowrap">
									<thead>
										<tr>
											<th width="60">ID</th>
											<th>Name</th>
											<th>Parent Category</th>
											<th>Slug</th>
											<th width="100">Status</th>
											<th width="100">Action</th>
										</tr>
									</thead>
									<tbody>
										@if(!$subcategories->isEmpty())
											@foreach ( $subcategories as $subcategory )
											<tr id= "sid{{ $subcategory->id }}">
												<td>{{ $subcategory->id }}</td>
												<td>{{ $subcategory->name }}</td>
												<td>{{ $subcategory->categoryName }}</td>
												<td>{{ $subcategory->slug }}</td>
												

												<td>
													@if( $subcategory->status == '1' )
													<svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
														<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
													</svg>
													@else
													<svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
														<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
													</svg>
													@endif
												</td>
												<td>
													<a href="{{ route('edit.subcategory',$subcategory->id) }}">
														<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
															<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
														</svg>
													</a>
													<a href="javascript:void(0)" onclick="deleteSubCategory({{$subcategory->id  }})" class="text-danger w-4 h-4 mr-1 deleteData">
														<svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
															<path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
														</svg>
													</a>
												</td>
											</tr>
										
											
											@endforeach
										@else
										 <tr>
											<td colspan="5">No Record Found</td>
										</tr>	
										@endif
							
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
								{{ $subcategories->links() }}
							</div>
						</div>
						</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
	@endsection

	@section('custom-js')
	<script>
		function deleteSubCategory(id)
		{

			$.ajaxSetup({

		headers:
			{

			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}

			});
			
			$.ajax({
				
				url: 'delete-subcategory/'+id,
				type: "DELETE",
				data: {
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
            if (response) {
				if(response['status']){
					window.location.href = "{{ route('show.subcategory') }}";
					 $("#sid" + id).remove();
				}
               
            } else {
                // Display error message if category was not found or an error occurred
                $('#flash-message').html('<div class="alert alert-danger">' + response.error + '</div>');
            }
        },
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		}

		$('.deleteData').click(function(){
			var id = $(this).attr("data-id");
			var url = '{{ route("delete.category", ":category") }}';
			url = url.replace(':category', id);
			var obj = $(this);

			
		});

	function resetForm() {
        // Get the form element
        var form = document.getElementById("myForm");
        
        if (form) {
            // Reset the form if it exists
            form.reset();
        } else {
            console.error("Form element not found");
        }
    }
	</script>

@endsection