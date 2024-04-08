    <?php $__env->startSection('content'); ?>
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Update SubCategory</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo e(route('show.subcategory')); ?>" class="btn btn-primary">Back</a>
							</div>
						</div>
						
						<span id="output"><?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></span>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                     <form id="subcategory-edit"> 						
                        <?php echo csrf_field(); ?>
                        <div class="container-fluid">
						<div class="card">
							<div class="card-body">		
                                <div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" value="<?php echo e($subcategory->name); ?>" placeholder="Name">	
											 <span id="name-error" class="text-danger"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Slug</label>
											<input type="text" name="slug" id="slug" class="form-control" value="<?php echo e($subcategory->slug); ?>" placeholder="Slug">
											<span id="slug-error" class="text-danger"></span>	
										</div>
									</div>		
                                    <div class="col-md-6">
										<div class="mb-3">
											<div class="form-group">
												<label>Status</label>
												<select class="form-control" name="status" value="<?php echo e($subcategory->status); ?>">
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
        <?php if(!empty($categories)): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option  <?php echo e($subcategory->category_id == $category->id ? 'selected' : ''); ?> value="<?php echo e($category->id); ?>">
                    <?php echo e($category->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>
    <span id="category_id-error" class="text-danger"></span>
</div>
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
	<?php $__env->stopSection(); ?>	

<?php $__env->startSection('custom-js'); ?>

<script>
    $(document).ready(function(){
        $("#subcategory-edit").submit(function(e){	
            e.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);
			

            $.ajax({
                type: 'POST',
                url: '<?php echo e(route("update.subcategory",$subcategory->id)); ?>',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
						if (response) {
							window.location.href="<?php echo e(route('show.subcategory')); ?>"
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



<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rocky/ecommerce/resources/views/sub_category/edit-subcategory.blade.php ENDPATH**/ ?>