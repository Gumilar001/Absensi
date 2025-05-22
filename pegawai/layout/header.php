<?php 

ob_start();
require_once('../../pegawai/config.php');

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT user.id_pegawai, user.username, user.status, user.role, 
pegawai.* FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");
$row = mysqli_fetch_assoc($result);
$foto = $row['foto'];

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
  <link rel="icon" href="<?= base_url('assets/images/favicon.svg') ?>" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="<?= base_url('assets/assets/fonts/tabler-icons.min.css') ?>" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="<?= base_url ('assets/assets/fonts/feather.css') ?>" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="<?= base_url ('assets/assets/fonts/fontawesome.css') ?>" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="<?= base_url ('assets/assets/fonts/material.css') ?>" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="<?= base_url('assets/assets/css/style.css') ?>" id="main-style-link" >
<link rel="stylesheet" href="<?= base_url('assets/assets/css/style-preset.css') ?>" >
 <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/css/tabler.min.css" />

    <style>

    </style>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>

<header class="navbar navbar-expand-md d-print-none">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbar-menu" aria-controls="navbar-menu"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- BEGIN NAVBAR LOGO --><a href="../../.."
      class="navbar-brand navbar-brand-autodark me-3"><img src="<?= base_url('assets/assets/images/logoMP.png') ?>" alt="" width="100" height="100">
    </a><!-- END NAVBAR LOGO -->
    <div class="navbar-nav flex-row order-md-last ms-auto">
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset"
          data-bs-toggle="dropdown" aria-label="Open user menu">
          <span  
           ><img style="width: 50px; height: 50px; border-radius: 100%; object-fit: cover;" src="<?= base_url('assets/assets/images/foto_pegawai/' . $foto ) ?>" alt="user-image" class="user-avtar"></span>
          <div class="d-none d-xl-block ps-2">
            <div><?= $_SESSION['nama'] ?></div>
            <div class="mt-1 small text-secondary"><?= $_SESSION['jabatan'] ?></div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="#" class="dropdown-item">Status</a>
          <a href="./profile.html" class="dropdown-item">Profile</a>
          <a href="#" class="dropdown-item">Feedback</a>
          <div class="dropdown-divider"></div>
          <a href="./settings.html" class="dropdown-item">Settings</a>
          <a href="./sign-in.html" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- [ Header ] end -->