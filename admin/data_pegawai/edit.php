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

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $jabatan = htmlspecialchars($_POST['jabatan']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);

    if(empty($_POST['password'])){
        $password = $_POST['password_lama'];
    }else{
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

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
        if(empty($jabatan)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Jabatan wajib diisi";
        }
        if(empty($username)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Username wajib diisi";
        }
        if($_POST['password'] != $_POST['ulangi_password']) {
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Password tidak cocok";
        }
        if(empty($password)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Password wajib diisi";
        }
        if(empty($role)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Role wajib diisi";
        }
        if(empty($status)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Status wajib diisi";
        }
        if(empty($lokasi_presensi)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Lokasi Presensi wajib diisi";
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
                jabatan = '$jabatan', 
                lokasi_presensi='$lokasi_presensi', 
                foto = '$nama_file'
            WHERE id=$id");

            $user = mysqli_query($connection, "UPDATE user SET
                username='$username',
                password = '$password', 
                status = '$status',
                role = '$role'
            WHERE id=$id");

        if (!$pegawai) {
            $_SESSION['validasi'] = "Update data pegawai gagal: " . mysqli_error($connection);
        } elseif (!$user) {
            $_SESSION['validasi'] = "Update data user gagal: " . mysqli_error($connection);
        } else {
            $_SESSION['berhasil'] = "Data Pegawai berhasil diupdate";
            header("Location: pegawai.php");
            exit;
        }

    }

}

}
// if (isset($_GET['id'])) {
  $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

  // Ambil data dari database
  $result = mysqli_query($connection, "SELECT user.id_pegawai, user.username, user.password, user.status, user.role, 
            pegawai.* FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");
  while ($pegawai = mysqli_fetch_array($result)) {
    $nama = $pegawai['nama'];
    $jenis_kelamin = $pegawai['jenis_kelamin'];
    $alamat = $pegawai['alamat'];
    $no_hp = $pegawai['no_hp'];
    $jabatan = $pegawai['jabatan'];
    $username = $pegawai['username'];
    $password = $pegawai['password'];
    $status = $pegawai['status'];
    $lokasi_presensi = $pegawai['lokasi_presensi'];
    $role = $pegawai['role'];
    $foto = $pegawai['foto'];
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
              <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?=  base_url('admin/home/home.php') ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=  base_url('admin/home/home.php') ?>">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="<?=  base_url('admin/data_pegawai/pegawai.php') ?>">Data Pegawai</a></li>
                <li class="breadcrumb-item" aria-current="page">Edit Data Pegawai</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Edit Data Pegawai</h3>

      <form action="<?= base_url('admin/data_pegawai/edit.php')?>" method="POST" enctype="multipart/form-data">
    <div class="row">

        <div class="col-md-6">
            <div class="card">
            <div class="card-body">
                    <div class="mb-3">
                        <label for="">Nama Pegawai</label>
                        <input type="text" class="form-control" name="nama" value="<?= $nama  ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Jenis Kelamin</label>
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
                    <div class="mb-3">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="<?= $alamat  ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">No Handphone</label>
                        <input type="text" class="form-control" name="no_hp" value="<?= $no_hp  ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Jabatan</label>
                        <select class="form-control" name="jabatan">
                            <option value="">Pilih Jabatan</option>
                            <?php
                                $ambil_jabatan = mysqli_query($connection, "SELECT * FROM jabatan ORDER BY jabatan ASC");

                                while($row = mysqli_fetch_assoc($ambil_jabatan)){
                                    $nama_jabatan = $row['jabatan'];

                                    if($jabatan == $nama_jabatan) {
                                        echo '<option value = "' . $nama_jabatan . '"
                                        selected = "selected">' . $nama_jabatan . '</option>';
                                    } else {
                                        echo'<option value ="' . $nama_jabatan . '">' . $nama_jabatan . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select class="form-control" name="status">
                            <option value="">Pilih Status</option>
                            <option <?php if($status == 'Aktif') {
                                echo 'selected';
                            }?> value="Aktif">Aktif</option>
                            <option <?php if($status == 'Tidak Aktif') {
                                echo 'selected';
                            }?> value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    </div>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= $username  ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Buat Password Baru</label>
                        <input type="hidden" class="form-control" name="password_lama" value="<?= $password ?> ">
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="">Ulangi Password</label>
                        <input type="password" class="form-control" name="ulangi_password">
                    </div>
                    <div class="mb-3">
                        <label for="">Role</label>
                        <select class="form-control" name="role">
                            <option value="">Pilih Role</option>
                            <option <?php if($role == 'Admin') {
                                echo 'selected';
                            }?> value="Admin">Admin</option>
                            <option <?php if($role == 'pegawai') {
                                echo 'selected';
                            }?> value="pegawai">Pegawai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Lokasi Presensi</label>
                        <select class="form-control" name="lokasi_presensi">
                            <option value="">Pilih Lokasi Presensi</option>
                            <?php
                                $ambil_lok_presensi = mysqli_query($connection, "SELECT * FROM lokasi_presensi ORDER BY nama_lokasi ASC");

                                while($lokasi = mysqli_fetch_assoc($ambil_lok_presensi)){
                                    $nama_lokasi = $lokasi['nama_lokasi'];

                                    if($lokasi_presensi == $nama_lokasi) {
                                        echo '<option value = "' . $nama_lokasi . '"
                                        selected = "selected">' . $nama_lokasi . '</option>';
                                    } else {
                                        echo'<option value ="' . $nama_lokasi . '">' . $nama_lokasi . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Foto</label>
                        <input type="hidden" class="form-control" name="foto_lama" value="<?= $foto  ?>">
                        <input type="file" class="form-control" name="foto">
                    </div>

                    <input type="hidden" value="<?= $id ?>" name="id">
                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>

    </div>
    </form>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <!-- [ Sweet Alert ] Start -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- [ Sweet Alert ] end -->

  <!-- alert validasi -->
   <?php if(isset($_SESSION['validasi'])) : ?>

    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: "error",
        title: "<?= $_SESSION['validasi'] ?>"
        });
    </script>

    <?php unset($_SESSION['validasi']); ?>

    <?php endif; ?>

<?php include('../layout/footer.php') ?>