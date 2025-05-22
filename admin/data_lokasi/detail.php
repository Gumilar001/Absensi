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
$result = mysqli_query($connection, "SELECT * FROM lokasi_presensi WHERE id = $id");
?>

<?php while($lokasi = mysqli_fetch_array($result)) : ?>

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
                <li class="breadcrumb-item"><a href="<?=  base_url('admin/data_lokasi/lokasi.php') ?>">Lokasi Presensi</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail Lokasi Presensi</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Detail Lokasi Presensi</h3>
        <div class="page-body">
            <div class="container-xl">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td>Nama Lokasi</td>
                                        <td>: <?= $lokasi['nama_lokasi'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Lokasi</td>
                                        <td>: <?= $lokasi['alamat_lokasi'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tipe Lokasi</td>
                                        <td>: <?= $lokasi['tipe_lokasi'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Latitude</td>
                                        <td>: <?= $lokasi['latitude'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Longitude</td>
                                        <td>: <?= $lokasi['longitude'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Radius</td>
                                        <td>: <?= $lokasi['radius'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Zona Waktu</td>
                                        <td>: <?= $lokasi['zona_waktu'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jam Masuk</td>
                                        <td>: <?= $lokasi['jam_masuk'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jam Pulang</td>
                                        <td>: <?= $lokasi['jam_pulang'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d76450.40702802222!2d<?= $lokasi['longitude'] ?>!3d<?= $lokasi['latitude'] ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c297b2c55e5d%3A0xe83d1433ea135d07!2sMega%20Production!5e0!3m2!1sid!2sid!4v1746704669533!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
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