<?php 

ob_start();
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} elseif ($_SESSION["role"] != 'Admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

require_once('../../pegawai/config.php');

// $result = mysqli_query($connection, "SELECT * FROM lokasi_presensi ORDER BY id DESC");
if (isset($_POST['submit'])) {

    $ambil_nip = mysqli_query($connection, "SELECT nip FROM pegawai ORDER BY nip DESC LIMIT 1");

                        if(mysqli_num_rows($ambil_nip) > 0){
                            $row = mysqli_fetch_assoc($ambil_nip);
                            $nip_db = $row['nip'];
                            $nip_db = explode("-", $nip_db);
                            $no_baru = (int)$nip_db[1] + 1;
                            $nip_baru = "PEG-" . str_pad($no_baru, 4, 0, STR_PAD_LEFT);
                        }else{
                            $nip_baru = "PEG-0001";
                        }

    $nip = $nip_baru;
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

    if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        if(!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Hanya file JPG, JPEG, PNG dan PDF yang diizinkan!";
        }
        if($ukuran_file > $maks_ukuran_file){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Ukuran file melebihi 10mb!";
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        }else{
            $pegawai = mysqli_query($connection, "INSERT INTO pegawai(nip, nama, 
            jenis_kelamin, alamat, no_hp, jabatan, lokasi_presensi, foto ) VALUES ('$nip',
            '$nama','$jenis_kelamin','$alamat','$no_hp','$jabatan','$lokasi_presensi','$nama_file')");

            $id_pegawai = mysqli_insert_id($connection);
            
            $user = mysqli_query($connection, "INSERT INTO user(id_pegawai, username, 
            password, status, role) VALUES ('$id_pegawai','$username','$password','$status',
            '$role')");
            
        
            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: pegawai.php");
            exit;
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
              <li class="breadcrumb-item"><a href="<?=  base_url('admin/home/home.php') ?>">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="<?=  base_url('admin/data_pegawai/pegawai.php') ?>">Data Pegawai</a></li>
                <li class="breadcrumb-item" aria-current="page">Tambah Pegawai</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Tambah Pegawai</h3>
      <form action="<?= base_url('admin/data_pegawai/tambah.php')?>" method="POST" enctype="multipart/form-data">
    <div class="row">

        <div class="col-md-6">
            <div class="card">
            <div class="card-body">
                    <div class="mb-3">
                        <label for="">Nama Pegawai</label>
                        <input type="text" class="form-control" name="nama" value="<?php if(isset($_POST['nama'])) echo $_POST['nama'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option <?php if(isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 
                            'Laki-laki') {
                                echo 'selected';
                            }?> value="Laki-laki">Laki-laki</option>
                            <option <?php if(isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 
                            'Perempuan') {
                                echo 'selected';
                            }?> value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="<?php if(isset($_POST['alamat'])) echo $_POST['alamat'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">No Handphone</label>
                        <input type="text" class="form-control" name="no_hp" value="<?php if(isset($_POST['no_hp'])) echo $_POST['no_hp'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Jabatan</label>
                        <select class="form-control" name="jabatan">
                            <option value="">Pilih Jabatan</option>
                            <?php
                                $ambil_jabatan = mysqli_query($connection, "SELECT * FROM jabatan ORDER BY jabatan ASC");

                                while($jabatan = mysqli_fetch_assoc($ambil_jabatan)){
                                    $nama_jabatan = $jabatan['jabatan'];

                                    if(isset($_POST['jabatan']) && $_POST['jabatan'] == $nama_jabatan) {
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
                            <option <?php if(isset($_POST['status']) && $_POST['status'] == 
                            'Aktif') {
                                echo 'selected';
                            }?> value="Aktif">Aktif</option>
                            <option <?php if(isset($_POST['status']) && $_POST['status'] == 
                            'Tidak Aktif') {
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
                        <input type="text" class="form-control" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Password</label>
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
                            <option <?php if(isset($_POST['role']) && $_POST['role'] == 
                            'Admin') {
                                echo 'selected';
                            }?> value="Admin">Admin</option>

                            <option <?php if(isset($_POST['role']) && $_POST['role'] == 
                            'pegawai') {
                                echo 'selected';
                            }?> value="pegawai">Pegawai</option>
                            <option <?php if(isset($_POST['role']) && $_POST['role'] == 
                            'workshop') {
                                echo 'selected';
                            }?> value="workshop">Workshop</option>

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

                                    if(isset($_POST['lokasi_presensi']) && $_POST['lokasi_presensi'] == $nama_lokasi) {
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
                        <input type="file" class="form-control" name="foto" >
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
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
  

<?php include('../layout/footer.php') ?>