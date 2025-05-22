<?php 

session_start();
ob_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} elseif ($_SESSION["role"] != 'Admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

require_once('../../pegawai/config.php');

$id = $_SESSION['id'];

if (isset($_POST['update'])) {
    # code...
    $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
    $ulangi_password_baru = password_hash($_POST['ulangi_password_baru'], PASSWORD_DEFAULT);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST['password_baru'])){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>New Password wajib diisi";
        }
        if(empty($_POST['ulangi_password_baru'])){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Confirm Password Baru wajib diisi";
        }
        if($_POST['password_baru'] != $_POST['ulangi_password_baru']){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Password Tidak Cocok";
        }
        
        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $pegawai = mysqli_query($connection, "UPDATE user SET 
                password = '$password_baru' WHERE id=$id");

        if (!$pegawai) {
            $_SESSION['validasi'] = "Update password pegawai gagal: " . mysqli_error($connection);
        } else {
            $_SESSION['berhasil'] = "Password berhasil diupdate";
            header("Location: ../home/home.php");
            exit;
        }

    }

}
}

?>

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Home</h5>
              </div>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=  base_url('admin/home/home.php') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?=  base_url('admin/home/home.php') ?>">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Ubah Password</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-4 text-center">Ubah Password</h3>

      <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="card">
                    <div class="card-header">
                      <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                            <form action="" method="POST">
                          <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password_baru" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="ulangi_password_baru" class="form-control">
                          </div>
                          <input type="hidden" name="id" value="<?= $id ?>">
                        </div>
                        <div class="col-sm-6">
                          <h5>New password must contain:</h5>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 8 characters</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 lower letter (a-z)
                            </li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 uppercase letter
                              (A-Z)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 number (0-9)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 special characters
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 text-end">
                      <button class="btn btn-outline-dark ms-2">Clear</button>
                      <button type="submit" name="update" class="btn btn-primary">Update Password</button>
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
<?php include('../layout/footer.php') ?>