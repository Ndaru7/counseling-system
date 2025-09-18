<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="../pengguna/dashboard.php" class="nav-link <?php if($halaman == "dashboard"){echo 'active';} ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="../pengguna/profile.php" class="nav-link <?php if($halaman == "profile"){echo 'active';} ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>Profil</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="../siswa" class="nav-link <?php if($halaman == "data_siswa"){echo 'active';} ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>Data Siswa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="../pelanggaran" class="nav-link <?php if($halaman == "data_pelanggaran"){echo 'active';} ?>">
                <i class="nav-icon fas fa-exclamation"></i>
                <p>Pelanggaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="../catatan_konseling" class="nav-link <?php if($halaman == "catatan_konseling"){echo 'active';} ?>">
                <i class="nav-icon fas fa-file"></i>
                <p>Catatan Konseling</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="../riwayat" class="nav-link <?php if($halaman == "riwayat"){echo 'active';} ?>">
                <i class="nav-icon fas fa-history"></i>
                <p>Riwayat</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="../auth/logout.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Keluar</p>
            </a>
        </li>
    </ul>
</nav>