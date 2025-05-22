<?php 

ob_start();
require_once('../../pegawai/config.php');

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT user.id_pegawai, user.username, user.status, user.role, 
pegawai.* FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");

?>

<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Home</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="<?=base_url('assets/images/favicon.svg') ?>" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="<?=base_url('assets/assets/fonts/tabler-icons.min.css') ?>" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="<?=base_url ('assets/assets/fonts/feather.css') ?>" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="<?=base_url ('assets/assets/fonts/fontawesome.css') ?>" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="<?=base_url ('assets/assets/fonts/material.css') ?>" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="<?=base_url('assets/assets/css/style.css') ?>" id="main-style-link" >
<link rel="stylesheet" href="../../assets/assets/css/style-preset.css" >

</head>
<!-- [Head] end -->
<!-- [Body] Start -->
 <?php
while ($pegawai = mysqli_fetch_array($result)) :
    # code...
?>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->

<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <img src="<?= base_url('assets/assets/images/foto_pegawai/' . $pegawai['foto']) ?>" alt="user-image" class="user-avtar">
        <span><?= $_SESSION['nama'] ?></span>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="<?= base_url('assets/assets/images/foto_pegawai/' . $pegawai['foto']) ?>" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1"><?= $_SESSION['nama'] ?></h6>
              <span><?= $_SESSION['jabatan'] ?></span>
            </div>
            </div>
        </div>
        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="drp-t1"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-1"
              type="button"
              role="tab"
              aria-controls="drp-tab-1"
              aria-selected="true"
              ><i class="ti ti-user"></i> Profile</button
            >
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="drp-t2"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-2"
              type="button"
              role="tab"
              aria-controls="drp-tab-2"
              aria-selected="false"
              ><i class="ti ti-settings"></i> Setting</button
            >
          </li>
        </ul>
        <div class="tab-content" id="mysrpTabContent">
          <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
            <a href="<?= base_url('admin/fitur_lainnya/edit.php') ?>" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Edit Profile</span>
            </a>
            <a href="<?= base_url('admin/fitur_lainnya/profile.php') ?>" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>View Profile</span>
            </a>
            <a href="<?= base_url('auth/logout.php') ?>" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
          </div>
          <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
            <a href="<?= base_url('admin/fitur_lainnya/ubah_password.php') ?>" class="dropdown-item">
              <i class="ti ti-lock"></i>
              <span>Ubah Passsword</span>
            </a>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header mt-3">
      <a href="<?=  base_url('admin/data_jabatan/jabatan.php') ?>" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="../../assets/assets/images/logoMP.png" class="img-fluid" alt="logo">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="<?=  base_url('admin/home/home.php') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
        </li>
        <li class="pc-item">
          <a href="<?=  base_url('admin/data_pegawai/pegawai.php') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">Pegawai</span>
          </a>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span class="pc-mtext">Master
          Data</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?=  base_url('admin/data_jabatan/jabatan.php') ?>"> Jabatan</a></li>
            <li class="pc-item"><a class="pc-link" href="<?=  base_url('admin/data_lokasi/lokasi.php') ?>"> Lokasi Presensi</a></li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-clipboard-check"></i></span><span class="pc-mtext">Rekap Presensi
          Data</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?=  base_url('admin/presensi/rekap_harian.php') ?>"> Rekap Harian</a></li>
            <li class="pc-item"><a class="pc-link" href="<?=  base_url('admin/presensi/rekap_bulanan.php') ?>"> Rekap Bulanan</a></li>
          </ul>
        </li>
        <li class="pc-item">
          <a href="<?=  base_url('admin/data_ketidakhadiran/ketidakhadiran.php') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-clipboard-x"></i></span>
            <span class="pc-mtext">Ketidakhadiran</span>
          </a>
        </li>               
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end --> 
<!-- [ Header ] end -->


<?php endwhile; ?>