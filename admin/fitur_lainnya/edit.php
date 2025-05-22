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
    $id = $_SESSION['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $username = htmlspecialchars($_POST['username']);


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
                username='$username'
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
// if (isset($_GET['id'])) {
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

      <form action="<?= base_url('admin/fitur_lainnya/edit.php')?>" method="POST" enctype="multipart/form-data">
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