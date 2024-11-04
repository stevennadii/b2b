
<?php $__env->startPush('css'); ?>
      <?php echo app('Illuminate\Foundation\Vite')('resources/js/vueapp.js'); ?>
      <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://kit.fontawesome.com/5bb4e904c2.js" crossorigin="anonymous"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/form-wizard.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\b2b\resources\views/app.blade.php ENDPATH**/ ?>