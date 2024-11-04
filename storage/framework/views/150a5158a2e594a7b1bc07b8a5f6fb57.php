

<?php $__env->startSection('css'); ?>
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<style>
    table{
        font-size:10px;
    }
    .req{
        background-color: #FFF7D1 !important;
        text-align: center;
 
    }
    .prog{
        background-color: #E2F1E7 !important;
        text-align: center;
      
    }

    td{
    
        text-align: center;
    }
    .badges {
        background-color: #FFD09B;
        color: black;
        padding: 2px 5px;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
        font-size: 10px;
    }
</style>

<?php $__env->startSection('content'); ?>

<div class="card mb-3">
    <div class="container-fluid mt-3">
        <div class="table-responsive">
<table class="table table-bordered dt-responsive nowrap align-middle" style="width:100%; padding:5px">
    <thead>
        <tr class="text-center">
            <th colspan="6" style="background-color: #FFF7D1;">Purchase Order</th>
            <th colspan="6" style="background-color: #E2F1E7;">Dalam Pengiriman</th>
            <th  rowspan="2" style="background-color: #E78F81; width: auto; white-space: nowrap;" class="align-middle">Out Standing</th>
            <th  rowspan="2" style="background-color: #B7E0FF; width: auto; white-space: nowrap; " class="align-middle">Status</th>
        </tr>
        <tr>   
            <th class="req" style="width: auto; white-space: nowrap;">No PO</th>
            <th class="req" style="width: auto; white-space: nowrap;">Kode Barang</th>
            <th class="req" style="width: auto; white-space: nowrap;">Nama Barang</th>
            <th class="req" style="width: auto; white-space: nowrap;">Qty</th>
            <th class="req" style="width: auto; white-space: nowrap;">Satuan</th>
            <th class="req" style="width: auto; white-space: nowrap;">Terima</th>
            <th class="prog" style="width: auto; white-space: nowrap;">No DO</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Estimasi Kedatangan</th> 
            <th class="prog" style="width: auto; white-space: nowrap;">Waktu Kedatangan</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Qty Kirim</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Qty Terima</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $displayPO; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            
            <?php
                $noDOs = '';
                $etas = '';
                $qtyDOs = '';
                $ActualTA = '';
                $ActualQty = '';
                $statuses = ''; // Handle multiple statuses
                $outstanding = null; // Only show one outstanding value
            ?>
    
            
            <?php $__currentLoopData = $item['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $noDOs .= $detail['NoDO'] . '<br>';
                    $etas .= $detail['ETA'] . '<br>';
                    $qtyDOs .= $detail['QtyDO'] . '<br>';
                    $ActualTA .= $detail['ActualTA'] . '<br>';
                    $ActualQty .= $detail['ActualQty'] . '<br>';
                    $statuses .= $detail['Status'] . '<br>';  // Concatenate statuses
                    
                    // Set the first encountered outstanding value (only once)
                    if (is_null($outstanding)) {
                        $outstanding = $detail['Outstanding'];
                    }
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
            <td style="width: auto; white-space: nowrap;"><?php echo e($item['NoFaktur']); ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo e($item['KodeBarang']); ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo e($item['NamaBarang']); ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo e($item['Qty']); ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo e($item['Satuan']); ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo $ActualQty; ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo $noDOs; ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo $etas; ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo $ActualTA; ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo $qtyDOs; ?></td>
            <td style="width: auto; white-space: nowrap;"><?php echo $ActualQty; ?></td>
    
            
            <td style="width: auto; white-space: nowrap;">
                <?php $__currentLoopData = explode('<br>', $statuses); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(trim($status) === 'N'): ?>
                        <span class="badge bg-warning mb-1"><?php echo 'Dalam Pengiriman'; ?></span><br>
                    <?php elseif(trim($status) === 'Y'): ?>
                        <span class="badge bg-success"><?php echo 'Selesai'; ?></span><br>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
    
            
            <td style="width: auto; white-space: nowrap;"><?php echo $outstanding; ?></td>
    
            
            <td style="width: auto; white-space: nowrap;">
                <?php if($outstanding > 0): ?>
                    <span class="badge bg-warning"><?php echo 'On Progress'; ?></span>
                <?php elseif($outstanding == 0): ?>
                <span class="badge bg-primary"><?php echo 'Belum Diproses'; ?></span>
                <?php elseif($outstanding == null): ?>
                <span class="badge bg-success"><?php echo 'Selesai'; ?></span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    
    </tbody>
</table>

            
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="<?php echo e(URL::asset('assets/libs/prismjs/prismjs.min.js')); ?>"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/modal.init.js')); ?>"></script>


    <script src="<?php echo e(URL::asset('assets/js/pages/datatables.init.js')); ?>"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/form-wizard.init.js')); ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\b2b\resources\views/trackingPO.blade.php ENDPATH**/ ?>