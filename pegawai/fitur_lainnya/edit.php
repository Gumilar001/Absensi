<?php

session_start();
ob_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

if (isset($_POST['update'])) {
    $id = $_SESSION['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $username = htmlspecialchars($_POST['username']);
    $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
    $ulangi_password_baru = password_hash($_POST['ulangi_password_baru'], PASSWORD_DEFAULT);


    if($_FILES['foto']['error'] === 4){
        $nama_file = $_POST['foto_lama'];
    }else{
        if(isset($_FILES['foto'])){
            $file = $_FILES['foto'];
            $nama_file = $file['name'];
            $file_tmp = $file['tmp_name'];
            $ukuran_file = $file['size'];
            $file_direktori = "../../assets/assets/images/foto_pegawai/" . $nama_file;
    
            $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
            $ekstensi_diizinkan = ["jpg", "png", "jpeg"];
            $maks_ukuran_file = 10 * 1024 * 1024;
    
            move_uploaded_file($file_tmp, $file_direktori);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($nama)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Nama wajib diisi";
        }
        if(empty($jenis_kelamin)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Jenis Kelamin wajib diisi";
        }
        if(empty($alamat)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Alamat wajib diisi";
        }
        if(empty($no_hp)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>No Handphone wajib diisi";
        }
        if(empty($username)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Username wajib diisi";
        }
        if(empty($_POST['password_baru'])){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>New Password wajib diisi";
        }
        if(empty($_POST['ulangi_password_baru'])){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Confirm Password Baru wajib diisi";
        }
        if($_POST['password_baru'] != $_POST['ulangi_password_baru']){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Password Tidak Cocok";
        }
        if($_FILES['foto']['error'] != 4){
            if(!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)){
                $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Hanya file JPG, JPEG, dan PNG yang diizinkan!";
            }
            if($ukuran_file > $maks_ukuran_file){
                $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Ukuran file melebihi 10mb!";
            }
        }
        
        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $pegawai = mysqli_query($connection, "UPDATE pegawai SET 
                nama = '$nama', 
                jenis_kelamin = '$jenis_kelamin', 
                alamat = '$alamat',
                no_hp = '$no_hp',
                foto = '$nama_file'
            WHERE id=$id");

            $user = mysqli_query($connection, "UPDATE user SET
                username='$username', password = '$password_baru'
            WHERE id=$id");

        if (!$pegawai) {
            $_SESSION['validasi'] = "Update data pegawai gagal: " . mysqli_error($connection);
        } elseif (!$user) {
            $_SESSION['validasi'] = "Update data user gagal: " . mysqli_error($connection);
        } else {
            $_SESSION['berhasil'] = "Data Pegawai berhasil diupdate";
            header("Location: ../home/home.php");
            exit;
        }

    }

}

}

$id = isset($_SESSION['id']) ? $_SESSION['id'] : $_POST['id'];

  // Ambil data dari database
  $result = mysqli_query($connection, "SELECT user.id_pegawai, user.username,
            pegawai.nama, pegawai.jenis_kelamin, pegawai.alamat, pegawai.no_hp, pegawai.foto 
            FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");
  while ($pegawai = mysqli_fetch_array($result)) {
    $nama = $pegawai['nama'];
    $jenis_kelamin = $pegawai['jenis_kelamin'];
    $alamat = $pegawai['alamat'];
    $no_hp = $pegawai['no_hp'];
    $username = $pegawai['username'];
    $foto = $pegawai['foto'];
  }


?>
       <!-- [ Main Content ] start -->
  <div class="container">
    <div class="content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <!-- <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                <li class="breadcrumb-item" aria-current="page">Account Profile</li>
              </ul>
            </div> -->
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">My Account</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header pb-0">
              <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">                
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-1" href="<?= base_url('pegawai/home/home.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-clipboard-check"></i>Absensi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-2" href="<?= base_url('pegawai/presensi/rekap_presensi.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-clipboard-check me-2"></i>Rekap Presensi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab"
                    aria-selected="true">
                    <i class="ti ti-id me-2"></i>My Account
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" id="profile-tab-4" href="<?= base_url('pegawai/fitur_lainnya/profile.php') ?>"   role="tab"
                    aria-selected="true">
                    <i class="ti ti-user me-2"></i>Profile
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-5" href="<?= base_url('pegawai/ketidakhadiran/ketidakhadiran.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-clipboard-x me-2"></i>Ketidakhadiran
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-6" href="<?= base_url('auth/logout.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-logout me-2"></i>Logout
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane show active" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                  <di class="row">
                      <div class="card">
                        <div class="card-header">
                          <h5>General Settings</h5>
                        </div>
                        <form action="<?= base_url('pegawai/fitur_lainnya/edit.php')?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                                <input type="text"  name="nama" class="form-control" value="<?= $nama  ?>">                                
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text"  name="username" class="form-control" value="<?= $username  ?>">                                
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text"  name="alamat" class="form-control"value="<?= $alamat  ?>">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option <?php if($jenis_kelamin == 'Laki-laki') {
                                        echo 'selected';
                                    }?> value="Laki-laki">Laki-laki</option>
                                    <option <?php if($jenis_kelamin == 'Perempuan') {
                                        echo 'selected';
                                    }?> value="Perempuan">Perempuan</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="form-label">No Handphone <span class="text-danger">*</span></label>
                                <input type="text"  name="no_hp" class="form-control"value="<?= $no_hp  ?>">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="">Foto</label>
                                <input type="hidden" class="form-control" name="foto_lama" value="<?= $foto  ?>">
                                <input type="file" class="form-control" name="foto">
                                <input type="hidden" value="<?= $id ?>" name="id">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>                    
                    <div class="card">
                    <div class="card-header">
                      <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password_baru" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="ulangi_password_baru" class="form-control">
                          </div>
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
                      <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      
      <!-- [ Main Content ] end -->
  <?php include('../layout/footer.php') ?>
  