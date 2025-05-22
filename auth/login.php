<?php 
session_start();

require_once('../pegawai/config.php');

if (isset($_POST["login"])) {
    # code...
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($connection,"SELECT * FROM user JOIN pegawai ON user.id_pegawai = pegawai.id 
    WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
     $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            if ($row['status'] == 'Aktif') {
                $_SESSION["login"] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['nip'] = $row['nip'];
                $_SESSION['jabatan'] = $row['jabatan'];
                $_SESSION['lokasi_presensi'] = $row['lokasi_presensi'];
                $_SESSION['username'] = $row['username'];

                if ($row['role'] === 'Admin') {
                    header("Location: ../admin/home/home.php");
                    exit();
                }else if($row['role'] === 'pegawai'){
                    header("Location: ../pegawai/home/home.php");
                    exit();
                } else {
                  header("Location: ../workshop/home/home.php");
                    exit();
                }
            }else{
                $_SESSION["gagal"] = "Akun anda belum aktif";
            }
        } else {
            $_SESSION["gagal"] = "Password salah, silahkan coba lagi";
        }
    } else {
        $_SESSION["gagal"] = "Username salah, silahkan coba lagi";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login | Mantis Bootstrap 5 Admin Template</title>
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

<body>
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="logo justify-content-center mt-n3" >
          <a href="#"><img src="<?= base_url('assets/assets/images/logoMP.png') ?>" alt="" style="width: 250px; height: 250px; object-fit:contain;"></a>
        </div>
        
        <?php 
        
        if (isset($_GET['pesan'])){
            if($_GET['pesan'] == "belum_login"){
                $_SESSION['gagal'] = 'Anda belum login';
            }else if($_GET['pesan']=="tolak_akses"){
                $_SESSION['gagal'] = 'Akses ke halaman ini ditolak';
            }
        }
        
        ?>

        <div class="card mt-n5">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class=""><b>Login</b></h3>
              <!-- <a href="#" class="link-primary">Don't have an account?</a> -->
            </div>
            <form action="" method="POST" autocomplete="off" novalidate>
            <div class="form-group mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <!-- <div class="d-flex mt-1 justify-content-between">              
              <h5 class="text-secondary f-w-400">Forgot Password?</h5>
            </div> -->
            <div class="d-grid mt-4">
              <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
            </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <!-- Required Js -->
  <script src="<?= base_url('assets/assets/js/plugins/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/plugins/simplebar.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/plugins/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/fonts/custom-font.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/pcoded.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/plugins/feather.min.js') ?>"></script>

  <!-- sweet alert START -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if ($_SESSION['gagal']){ ?>
    <script>
        Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "<?= $_SESSION['gagal'] ?>",
        });
    </script>
    <?php unset($_SESSION['gagal']); ?>
  <?php } ?>
  <!-- sweet alert END-->

  
  
  
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
    
 
</body>
<!-- [Body] end -->

</html>