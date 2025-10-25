<?php
if ($_SESSION["peran"] == "0") {
?>
    <!--Sidebar Admin-->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="../dashboard_admin" class="nav-link <?php if($halaman == "dashboard_admin"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../dashboard_admin/profile.php" class="nav-link <?php if($halaman == "profile"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../guru" class="nav-link <?php if($halaman == "guru"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>Data Guru BK</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../siswa" class="nav-link <?php if($halaman == "data_siswa"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-user-graduate"></i>
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
                <a href="../auth/logout.php" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Keluar</p>
                </a>
            </li>
        </ul>
    </nav>
<?php
} else if ($_SESSION["peran"] == "1") {
?>
    <!--Sidebar Guru-->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="../dashboard_guru" class="nav-link <?php if($halaman == "dashboard_guru"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../dashboard_guru/profile.php" class="nav-link <?php if($halaman == "profile"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
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
<?php
} else if ($_SESSION["peran"] == 2) {
?>
    <!--Sidebar Siswa-->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="../dashboard_siswa" class="nav-link <?php if($halaman == "dashboard_siswa"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../dashboard_siswa/profile.php" class="nav-link <?php if($halaman == "profile"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../catatan_siswa" class="nav-link <?php if($halaman == "catatan_siswa"){echo 'active';} ?>">
                    <i class="nav-icon fas fa-file"></i>
                    <p>Catatan Siswa</p>
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
<?php
}
?>
