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

if (isset($_POST['update'])) {
  $id = $_POST['id'];
    $jabatan = htmlspecialchars($_POST['jabatan']);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($jabatan)) {
            $pesan_kesalahan = "Data jabatan wajib diisi";
        }

        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = $pesan_kesalahan;
        } else {
            $result = mysqli_query($connection, "UPDATE jabatan SET jabatan='$jabatan' WHERE id=$id");
            if($result){
              $_SESSION['berhasil'] = "Data jabatan berhasil di update";
              header("Location: jabatan.php");
              exit;
            } else {
              $_SESSION['validasi'] = "Gagal update data.";
            }
            
    }

}

}
if (isset($_GET['id'])) {
  $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

  // Ambil data dari database
  $query = mysqli_query($connection, "SELECT * FROM jabatan WHERE id = '$id'");
  $data = mysqli_fetch_assoc($query);

  // Cek apakah data ditemukan
  if (!$data) {
      echo "Data tidak ditemukan.";
      exit;
  }
} else {
  echo "ID tidak dikirim.";
  exit;
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
                <li class="breadcrumb-item" aria-current="page">Edit Data Jabatan</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Edit Data Jabatan</h3>

      <div class="card col-md-6">
        <div class="card-body">
            <form action="edit.php?id=<?= $data['id'] ?>" method="POST">
                <div class="mb-3">
                    <label for="">Nama Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" value = "<?= $data["jabatan"]  ?>">
                </div>
                <input type="hidden" name="id" value = "<?= $data["id"]  ?>">
                <button type="submit" name="update" class="btn btn-primary">Update</button>
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