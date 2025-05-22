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

$id = $_GET['id'];
$result = mysqli_query($connection, "SELECT user.id_pegawai, user.username, user.password, user.status, user.role, 
pegawai.* FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");
?>

<?php while($pegawai = mysqli_fetch_array($result)) : ?>

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
                <li class="breadcrumb-item" aria-current="page">Detail Data Pegawai</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Detail Data Pegawai</h3>
        <div class="page-body">
            <div class="container-xl">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td>Nama Pegawai</td>
                                        <td>: <?= $pegawai['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin Pegawai</td>
                                        <td>: <?= $pegawai['jenis_kelamin'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat pegawai</td>
                                        <td>: <?= $pegawai['alamat'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>No Handphone</td>
                                        <td>: <?= $pegawai['no_hp'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>: <?= $pegawai['jabatan'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: <?= $pegawai['status'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Username</td>
                                        <td>: <?= $pegawai['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Role</td>
                                        <td>: <?= $pegawai['role'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi Presensi</td>
                                        <td>: <?= $pegawai['lokasi_presensi'] ?></td>
                                    </tr>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="align-items: center; padding: 1rem;">
                        <img style="width: 400px; border-radius: 10px;" src="<?= base_url('assets/assets/images/foto_pegawai/' . $pegawai['foto']) ?>" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
              
      </div>
    </div>
  </div>
  <?php endwhile; ?>
    <!-- [ Main Content ] end -->
  
<?php include('../layout/footer.php') ?>