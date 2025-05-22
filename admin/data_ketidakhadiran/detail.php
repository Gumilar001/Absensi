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

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $status_pengajuan = $_POST['status_pengajuan'];

    $result = mysqli_query($connection, "UPDATE ketidakhadiran SET status_pengajuan = '$status_pengajuan' WHERE id = '$id'");

    $_SESSION['berhasil'] = "Status Pengajuan Pegawai berhasil diupdate";
            header("Location: ketidakhadiran.php");
            exit;
}

$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM ketidakhadiran WHERE id = $id");
while($data = mysqli_fetch_array($result)){
    $keterangan = $data['keterangan'];
    $deskripsi = $data['deskripsi'];
    $tanggal = $data['tanggal_pengajuan'];
    $file = $data['file'];
    $status_pengajuan = $data['status_pengajuan'];
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
                <li class="breadcrumb-item"><a href="<?=  base_url('admin/data_ketidakhadiran/ketidakhadiran.php') ?>">Ketidakhadiran</a></li>
                <li class="breadcrumb-item" aria-current="page">Pengajuan Ketidakhadiran</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Ketidakhadiran</h3>

      <div class="row justify-content-center">
       <div class="card col-md-6">
        <div class="card-body">
            <form action="" method="POST">
            <div class="mb-3">
                <label for="">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="">Keterangan</label>
                <input type="text" name="tanggal" class="form-control" value="<?= $keterangan ?>">
            </div>
            <div class="mb-3">
                <label for="">Status Pengajuan</label>
                <select class="form-control" name="status_pengajuan">
                    <option value="">Pilih STATUS</option>
                    <option <?php if ($status_pengajuan == 'PENDING'){
                        echo 'selected';
                    } ?> value="PENDING">PENDING</option>

                    <option <?php if ($status_pengajuan == 'REJECTED'){
                        echo 'selected';
                    } ?> value="REJECTED">REJECTED</option>

                    <option <?php if ($status_pengajuan == 'APPROVED'){
                        echo 'selected';
                    } ?> value="APPROVED">APPROVED</option>

                </select>
                
            </div>
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="submit" class="btn btn-primary" name="update">UPDATE</button>
            </form>
        </div>
       </div>
       </div>
      
      </div>
    </div>
  </div>
    <!-- [ Main Content ] end -->

<?php include('../layout/footer.php') ?>