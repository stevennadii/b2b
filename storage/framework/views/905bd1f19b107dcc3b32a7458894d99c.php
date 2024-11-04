<style>
    .app-menu.collapsed {
    width: 80px; /* Adjust width when collapsed */
}

.app-menu.collapsed .navbar-nav .nav-link span {
    display: none; /* Hide the text */
}

.app-menu.collapsed .logo-lg, .app-menu.collapsed .logo-lg img {
    display: none; /* Hide large logo */
}

.app-menu.collapsed .logo-sm, .app-menu.collapsed .logo-sm img {
    display: inline-block; /* Ensure small logo stays */
}
</style><!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('assets/images/evo.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('assets/images/evo.png')); ?>" alt="" height="60">
            </span>
        </a>
        <!-- Light Logo-->
        <a class="logo logo-light">
            <span class="logo-sm">
                <img style="border-radius: 20px" src="<?php echo e(URL::asset('assets/images/evo.png')); ?>"
                    alt="" height="22">
            </span>
            <span class="logo-lg">
                <img style="border-radius: 20px" src="<?php echo e(URL::asset('assets/images/evo.png')); ?>"
                    alt="" height="60">
            </span>
        </a>
     <!-- Sidebar Toggle Button -->
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover" onclick="toggleSidebar()">
            <i class="ri-record-circle-line"></i>
        </button>

    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title  "><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
             
                <li class="nav-item ">
                    <a href="<?php echo e(url('dashboard')); ?>"
                        class="nav-link menu-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
                        <i class="ri-home-line"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link  " href="#sidebarPenawaran" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPenawaran">
                        <i class="ri-profile-line"></i> <span>Quotation</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPenawaran">
                        <ul class="nav nav-sm flex-column">
                            <!-- List Penawaran -->
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/list_quotation')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('list-penawaran') ? 'active' : ''); ?>">
                                    <span>List Penawaran</span>
                                </a>
                            </li>
                    
                            <!-- Create Penawaran -->
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link menu-link <?php echo e(request()->is('create-penawaran') ? 'active' : ''); ?> disabled">
                                    <span>Create Penawaran</span>
                                </a>
                            </li>
                            <ul class="nav nav-sm flex-column">
                            <!-- Submenu for Freight Quotation -->
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/freight_quotation')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('freight-quotation') ? 'active' : ''); ?>">
                                    <span>Freight Quotation</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/freight_expense')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('freight-expense') ? 'active' : ''); ?>">
                                    <span>Freight Expense</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/freight_comparison')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('freight-comparison') ? 'active' : ''); ?>">
                                    <span>Freight Comparison</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('forwarding')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('forwarding') ? 'active' : ''); ?>">
                                    <span>Forwarding</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/expedition')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('ekspedisi') ? 'active' : ''); ?>">
                                    <span>Expedition</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/rawMaterial')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('bahan-baku') ? 'active' : ''); ?>">
                                    <span>Raw Material</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/packaging')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('packaging') ? 'active' : ''); ?>">
                                    <span>Packaging</span>
                                </a>
                            </li>
                            </ul>
                            <!-- Approval Penawaran -->
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-logistik') ? 'active' : ''); ?> disabled">
                                    <span>Approval Penawaran</span>
                                </a>
                            </li>
                            <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_freight')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-freight') ? 'active' : ''); ?>">
                                    <span>Freight</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_expedition_user')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-expedition') ? 'active' : ''); ?>">
                                    <span>Expedition</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_raw_material_user')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-bahan-baku') ? 'active' : ''); ?>">
                                    <span>Raw Material</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_packaging_user')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-packaging') ? 'active' : ''); ?>">
                                    <span>Packaging</span>
                                </a>
                            </li>
                            </ul>
                        </ul>
                    </div>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link menu-link  " href="#sidebarApproval" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApproval">
                        <i class="ri-profile-line"></i> <span>Approval</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApproval">
                        <ul class="nav nav-sm flex-column">
                            <!-- List Penawaran -->
                            
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-logistik') ? 'active' : ''); ?> disabled">
                                    <span>Approval Penawaran</span>
                                </a>
                            </li>
                            <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_freight_admin')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-bahan-baku') ? 'active' : ''); ?>">
                                    <span>Freight</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_expedition_admin')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-bahan-baku') ? 'active' : ''); ?>">
                                    <span>Expedition</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_raw_material_admin')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-logistik') ? 'active' : ''); ?>">
                                    <span>Raw Material</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('new/approval_packaging_admin')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('approval-logistik') ? 'active' : ''); ?>">
                                    <span>Packaging</span>
                                </a>
                            </li>
                            </ul>
                        </ul>
                    </div>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link menu-link  " href="#sidebarDO" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDO">
                        <i class="ri-profile-line"></i> <span>Delivery Order</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDO">
                        <ul class="nav nav-sm flex-column">
                            <!-- List Penawaran -->
                            <li class="nav-item ">
                                <a href="<?php echo e(url('new/display-order')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('purchase-order') ? 'active' : ''); ?>">
                                    <span>Display Order</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo e(url('new/purchase-order')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('purchase-order') ? 'active' : ''); ?>">
                                    <span>Transaksi</span>
                                </a>
                            </li>
                    
                           
                        </ul>
                    </div>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link  " href="#Profil" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="Profil">
                        <i class="ri-profile-line"></i> <span>Profile</span>
                    </a>
                    <div class="collapse menu-dropdown" id="Profil">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item ">
                                <a href="<?php echo e(url('new/list_perusahaan')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('master-jenis-bantuan') ? 'active' : ''); ?>">
                                    <span>List Perusahaan</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo e(url('new/profil_perusahaan')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('master-jenis-bantuan') ? 'active' : ''); ?>">
                                    <span>Profil Perusahaan</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo e(url('new/jenis_angkutan')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('master-jenis-bantuan') ? 'active' : ''); ?>">
                                    <span>Jenis Angukatan</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link  " href="#Master" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="Master">
                        <i class="ri-profile-line"></i> <span>Master</span>
                    </a>
                    <div class="collapse menu-dropdown" id="Master">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item ">
                                <a href="<?php echo e(url('master-jenis-bantuan')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('master-jenis-bantuan') ? 'active' : ''); ?>">
                                    <span>Jenis Angkutan</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo e(url('master-jenis-bantuan')); ?>"
                                    class="nav-link menu-link <?php echo e(request()->is('master-jenis-bantuan') ? 'active' : ''); ?>">
                                    <span>Biaya Freight</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

            </ul>
            
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>


</script>
<?php /**PATH C:\laragon\www\b2b\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>