<?php $__env->startSection('body'); ?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Pages List</h4>
            <a href="<?php echo e(route('pages.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Page
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($page->name); ?></td>
                                <td><?php echo e($page->slug); ?></td>
                                <td><span class="badge bg-primary"><?php echo e(ucfirst($page->type)); ?></span></td>
                                <td><?php echo e($page->created_at->format('Y-m-d')); ?></td>
                                <td class="text-end">
                                    
                                    <a href="<?php echo e(route('pages.edit', $page->id)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('pages.destroy', $page->id)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this page?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($pages->isEmpty()): ?>
                            <tr>
                                <td colspan="5" class="text-center">No pages found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="m-3">
                <?php echo e($pages->links()); ?> 
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('dashboard.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/macstoreegypt/Documents/Projects/sadaadd.com/resources/views/dashboard/pages/index.blade.php ENDPATH**/ ?>