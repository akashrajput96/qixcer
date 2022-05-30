
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('All Tickets')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.frontend.seller-buyer-preloader','data' => []]); ?>
<?php $component->withName('frontend.seller-buyer-preloader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <!-- Dashboard area Starts -->
    <div class="body-overlay"></div>
    <div class="dashboard-area dashboard-padding">
        <div class="container-fluid">
            <div class="dashboard-contents-wrapper">
                <div class="dashboard-icon">
                    <div class="sidebar-icon">
                        <i class="las la-bars"></i>
                    </div>
                </div>
                <?php echo $__env->make('frontend.user.buyer.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if($tickets->count() >= 1): ?>
                    <div class="dashboard-right">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="dashboard-settings margin-top-40">
                                    <h2 class="dashboards-title"> <?php echo e(__('All Tickets')); ?> </h2>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrapper margin-top-50 text-right">
                            <a href="<?php echo e(route('buyer.orders')); ?>" class="cmn-btn btn-bg-1"> <?php echo e(__('Create Ticket For A Order' )); ?></a>
                        </div>
                        <div class="dashboard-service-single-item border-1 margin-top-40">
                            <div class="rows dash-single-inner">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('ID')); ?></th>
                                            <th><?php echo e(__('Title')); ?></th>
                                            <th><?php echo e(__('Priority')); ?></th>
                                            <th><?php echo e(__('Status')); ?></th>
                                            <th><?php echo e(__('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($data->id); ?></td>
                                            <td><?php echo e(__('Order Id')); ?> #<?php echo e($data->order_id); ?>, <?php echo e($data->title); ?></td>
                                            <td>
                                                <?php if($data->priority=='low'): ?><span class="btn btn-primary btn-bg-1"><?php echo e(ucfirst($data->priority)); ?></span><?php endif; ?>
                                                <?php if($data->priority=='high'): ?><span class="btn btn-warning btn-bg-1"><?php echo e(ucfirst($data->priority)); ?></span><?php endif; ?>
                                                <?php if($data->priority=='medium'): ?><span class="btn btn-info btn-bg-1"><?php echo e(ucfirst($data->priority)); ?></span><?php endif; ?>
                                                <?php if($data->priority=='urgent'): ?><span class="btn btn-danger btn-bg-1"><?php echo e(ucfirst($data->priority)); ?></span><?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($data->status=='open'): ?>
                                                <span class="btn btn-primary btn-bg-1"><?php echo e(ucfirst($data->status)); ?></span>
                                                <a href="<?php echo e(route('buyer.support.ticket.status.change', $data->id)); ?>">
                                                    <span class="icon dash-edit-icon-two color-1" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('Change Ticket Status')); ?>">
                                                        <i class="las la-edit"></i>
                                                    </span>
                                                </a>
                                                <?php endif; ?>
                                                <?php if($data->status=='close'): ?>
                                                <span class="btn btn-danger btn-bg-1"><?php echo e(ucfirst($data->status)); ?></span>
                                                <a href="<?php echo e(route('buyer.support.ticket.status.change', $data->id)); ?>">
                                                    <span class="icon dash-edit-icon-two color-1" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('Change Ticket Status')); ?>">
                                                        <i class="las la-edit"></i>
                                                    </span>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="dashboard-switch-single">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.seller-delete-popup','data' => ['url' => route('buyer.support.ticket.delete',$data->id)]]); ?>
<?php $component->withName('seller-delete-popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('buyer.support.ticket.delete',$data->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    <a href="<?php echo e(route('buyer.support.ticket.view', $data->id)); ?>">
                                                        <span class="icon dash-icon dash-eye-icon eye-icon" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('View Details')); ?>">
                                                            <i class="las la-eye"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#0" class="edit_priority_modal" 
                                                    data-toggle="modal"
                                                    data-target="#editPriorityModal" 
                                                    data-id="<?php echo e($data->id); ?>"
                                                    data-priority="<?php echo e($data->priority); ?>"
                                                    >
                                                    <span class="dash-icon dash-edit-icon color-1" data-toggle="tooltip" data-placement="top" title="<?php echo e(__('Change Priority')); ?>">
                                                        <i class="las la-edit"></i>
                                                    </span>
                                                </a>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="blog-pagination margin-top-55">
                            <div class="custom-pagination mt-4 mt-lg-5">
                                <?php echo $tickets->links(); ?>

                            </div>
                        </div>

                    </div>
                <?php else: ?> 
                <h2 class="no_data_found"><?php echo e(__('No Tickets Found')); ?></h2>
                <?php endif; ?>    
            </div>
        </div>
    </div>


     <!--priority Modal -->
     <div class="modal fade" id="editPriorityModal" tabindex="-1" role="dialog" aria-labelledby="editModal"
     aria-hidden="true">
     <form action="<?php echo e(route('buyer.support.ticket.priority.change')); ?>" method="post">
         <input type="hidden" id="ticket_id" name="ticket_id">
         <?php echo csrf_field(); ?>
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="editModal"><?php echo e(__('Change Priority')); ?></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">

                     <div class="form-group">
                         <label for="up_day_id"><?php echo e(__('Select Status')); ?></label>
                         <select name="priority" id="priority" class="form-control nice-select">
                            <option value="low"><?php echo e(__('Low')); ?></option>
                            <option value="medium"><?php echo e(__('Medium')); ?></option>
                            <option value="high"><?php echo e(__('High')); ?></option>
                            <option value="urgent"><?php echo e(__('Urgent')); ?></option>
                         </select>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                     <button type="submit" class="btn btn-primary"><?php echo e(__('Save changes')); ?></button>
                 </div>
             </div>
         </div>
     </form>
 </div>
    <?php $__env->stopSection(); ?>  


<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/backend/js/sweetalert2.js')); ?>"></script>
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){

                $(document).on('click','.swal_delete_button',function(e){
                    e.preventDefault();
                        Swal.fire({
                        title: '<?php echo e(__("Are you sure?")); ?>',
                        text: '<?php echo e(__("You would not be able to revert this item!")); ?>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).next().find('.swal_form_submit_btn').trigger('click');
                        }
                        });
                });

                $(document).on('click', '.edit_priority_modal', function(e) {
                    e.preventDefault();
                    let ticket_id = $(this).data('id');
                    let priority = $(this).data('priority');

                    $('#ticket_id').val(ticket_id);
                    $('#priority').val(priority);
                    $('.nice-select').niceSelect('update');
                });

            });

        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.user.seller.seller-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bytesed/public_html/laravel/qixer/beta/@core/resources/views/frontend/user/buyer/support-ticket/all-tickets.blade.php ENDPATH**/ ?>