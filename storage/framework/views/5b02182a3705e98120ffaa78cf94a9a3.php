<?php $__env->startSection('content'); ?>
	<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Sub Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo e(route('show.subcategory')); ?>" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<!-- Default box -->
                     <form id="subcategory-form"> 
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
								<?php if(!empty($categories)): ?>
									<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
								
							</select>
							
							<span id="category_id-error" class="text-danger"></span>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button class="btn btn-primary">Create</button>
            <a href="<?php echo e(route('show.subcategory')); ?>" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
</form>

					</div>
					<!-- /.card -->
				</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom-js'); ?>
	<script>
		$(document).ready(function(){
			$("#subcategory-form").submit(function(e){
				e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: 'POST',
					url: "<?php echo e(route('store.subcategory')); ?>",
					data: formData,
					contentType: false,
					processData: false,
					success: function(response){
						if (response) {
							window.location.href="<?php echo e(route('show.subcategory')); ?>"
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rocky/ecommerce/resources/views/sub_category/create.blade.php ENDPATH**/ ?>