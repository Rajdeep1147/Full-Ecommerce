    <?php $__env->startSection('content'); ?>
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo e(route('show.category')); ?>" class="btn btn-primary">Back</a>
							</div>
						</div>
						<?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                     <form id="category-form"> 						
                        <?php echo csrf_field(); ?>
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
											<label for="email">Slug</label>
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
												<span id="status-error" class="text-danger"></span>
											</div>
										</div>
									</div>		
									<div class="col-md-6">
										<label for="status">Vehicle</label>
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="bike" name="vehicle[]" id="flexCheckDefault">
										<label class="form-check-label" for="flexCheckDefault">
											Bike
										</label>
										</div>
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="car" name="vehicle[]" id="flexCheckChecked" >
										<label class="form-check-label" for="flexCheckChecked">
											Car
										</label>
										</div>
										<span id="vehicle-error" class="text-danger"></span>
									</div>

                                    
                                    <div class="col-md-6">
										<div class="mb-3">
										<label for="image">Upload Image:</label>
                                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*" aria-describedby="imageHelpBlock">
                                        <small id="imageHelpBlock" class="form-text text-muted">Please choose an image file (JPG, JPEG, PNG, or GIF).</small>
                                    </div>	
									<span id="image-error" class="text-danger"></span>	
								</div>
                           
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary">Create</button>
							<a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                         </form>
					</div>
					<!-- /.card -->
				</section>
	<?php $__env->stopSection(); ?>	

<?php $__env->startSection('custom-js'); ?>
	<script>
		$(document).ready(function(){
			$("#category-form").submit(function(e){
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: 'POST',
					url: "<?php echo e(route('store.category')); ?>",
					data: formData,
					contentType: false,
					processData: false,
					success: function(response){
						if (response) {
							window.location.href="<?php echo e(route('show.category')); ?>"
							$(".text-danger").text(''); // Clear all error messages
						
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rocky/ecommerce/resources/views/category/create.blade.php ENDPATH**/ ?>