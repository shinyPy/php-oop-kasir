 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">
     <ul class="sidebar-nav" id="sidebar-nav">

         <!-- End Dashboard Nav -->

         <li class="nav-item">
             <a id="master-pages-button" class="nav-link <?= (currentPath('master') ? '' : 'collapsed') ?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?= (currentPath('master') ? 'true' : 'false') ?>">
                 <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="master-nav" class="nav-content collapse <?= (currentPath('master') ? 'show' : 'collapse') ?>" data-bs-parent="#sidebar-nav">

                 <?php if ($_SESSION['user']['role'] === "admin") : ?>
                     <li>
                         <a class="<?= currentPath('master/users') ? 'active' : '' ?>" href="<?= route('master/users') ?>">
                             <i class="bi bi-circle"></i><span>Users</span>
                         </a>
                     </li>
                 <?php endif; ?>
                 <li>
                     <a class="<?= currentPath('master/produk') ? 'active' : '' ?>" href="<?= route('master/produk') ?>">
                         <i class="bi bi-circle"></i><span>Produk</span>
                     </a>
                 </li>
                 <li>
                     <a class="<?= currentPath('master/pelanggan') ? 'active' : '' ?>" href="<?= route('master/pelanggan') ?>">
                         <i class="bi bi-circle"></i><span>Pelanggan</span>
                     </a>
                 </li>
             </ul>
         </li>
         <!-- End Components Nav -->

       
         <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link <?= (!currentPath('pages/penjualan')) ? 'collapsed' : '' ?>" href="<?= route('pages/penjualan') ?>">
                <i class="bi bi-cart"></i>
                <span>Penjualan</span>
            </a>
        </li>

        <li class="nav-item">
            <a id="laporan-penjualan-button" class="nav-link <?= (!currentPath('pages/laporan')) ? 'collapsed' : '' ?>" data-bs-target="#laporan-penjualan-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?= (!currentPath('pages/laporan')) ? 'false' : 'true' ?>">
                <i class="bi bi-envelope-paper"></i>
                <span>Laporan Penjualan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="laporan-penjualan-nav" class="nav-content collapse <?= (!currentPath('pages/laporan')) ? 'collapse' : 'show' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?= currentPath('pages/laporan/perhari') ? 'active' : '' ?>" href="<?= route('pages/laporan/perhari') ?>">
                        <i class="bi bi-circle"></i><span>Penjualan Perhari</span>
                    </a>
                </li>
                <li>
                    <a class="<?= currentPath('pages/laporan/keseluruhan') ? 'active' : '' ?>" href="<?= route('pages/laporan/keseluruhan') ?>">
                        <i class="bi bi-circle"></i><span>Penjualan Keseluruhan</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
 </aside>
 <!-- End Sidebar-->