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

if (isset($_POST['submit'])) {
    $jabatan = htmlspecialchars($_POST['jabatan']);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($jabatan)) {
            $pesan_kesalahan = "Data jabatan wajib diisi";
        }

        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = $pesan_kesalahan;
        } else {
            $result = mysqli_query($connection, "INSERT INTO jabatan(jabatan) VALUES ('$jabatan')");
            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: jabatan.php");
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
                <li class="breadcrumb-item"><a href="<?=  base_url('admin/data_jabatan/jabatan.php') ?>">Jabatan</a></li>
                <li class="breadcrumb-item" aria-current="page">Tambah Data</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Tambah Data Jabatan</h3>

      <div class="card col-md-6">
        <div class="card-body">
            <form action="<?= base_url('admin/data_jabatan/tambah.php')?>" method="POST">
                <div class="mb-3">
                    <label for="">Nama Jabatan</label>
                    <input type="text" class="form-control" name="jabatan">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
      </div>

      

       
      
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <!-- [ Sweet Alert ] Start -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- [ Sweet Alert ] end -->
  

<?php include('../layout/footer.php') ?>