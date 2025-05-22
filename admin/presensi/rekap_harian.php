<?php 

session_start();
ob_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} elseif ($_SESSION["role"] != 'Admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

if(empty($_GET['tanggal_dari'])) {  
  $tanggal_hari_ini = date('Y-m-d');
  $result = mysqli_query($connection,"SELECT presensi.*, pegawai.nama, pegawai.lokasi_presensi 
    FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk = '$tanggal_hari_ini' ORDER BY tanggal_masuk DESC");
}else{
  $tanggal_dari = $_GET['tanggal_dari'];
  $tanggal_sampai = $_GET['tanggal_sampai'];
  $result = mysqli_query($connection,"SELECT presensi.*, pegawai.nama, pegawai.lokasi_presensi 
    FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk BETWEEN '$tanggal_dari' AND '$tanggal_sampai' ORDER BY tanggal_masuk DESC");
}

if (empty($_GET['tanggal_dari'])) {
    $tanggal = date('Y-m-d');
}else{
    $tanggal = $_GET['tanggal_dari'] . '-' . $_GET['tanggal_sampai'];
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
                <li class="breadcrumb-item" aria-current="page">Rekap Harian Absensi</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Rekap Absensi Harian</h3>
      <div class="row">
      <div class="col-md-2">
      <button type="button" class="btn btn-primary mb-3 " data-bs-toggle="modal"
          data-bs-target="#exampleModal">Ekspor Excel</button>
      </div>
      <div class="col-md-10">
          <form method="GET">
              <div class="input-group">
                  <input type="date" class="form-control" name="tanggal_dari">
                  <input type="date" class="form-control" name="tanggal_sampai">
                  <button type="submit" class="btn btn-primary">Tampilkan</button>
              </div>
          </form>
      </div>
  </div>

  <?php if(empty($_GET['tanggal_dari'])) :?>
    <span>Rekap Absensi Tanggal : <?= date('d F Y') ?></span>
    <?php else : ?>
      <span>Rekap Absensi Tanggal : <?= date('d F Y', strtotime($_GET['tanggal_dari'])) . 
      ' sampai ' . date('d F Y', strtotime($_GET['tanggal_sampai'])) ?></span>
      <?php endif; ?>
     
 <!-- #region -->
       <table class="table table-bordered text-center mt-2">
       <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Lokasi Absensi</th>
          <th>Tanggal</th>
          <th>Jam Masuk</th>
          <th>Jam Pulang</th>
          <th>Total Jam</th>
          <th>Total Terlambat</th>
      </tr>
      <?php if(mysqli_num_rows($result) === 0) {?>
          <tr>
              <td colspan="8">Data Rekap Presensi Masih Kosong</td>
          </tr>
          <?php } else { ?>

  <?php
      // Menghitung Total jam kerja
      $no = 1; while($rekap = mysqli_fetch_array($result)) :
      $jam_tanggal_masuk = date('Y-m-d H:i:s', strtotime($rekap['tanggal_masuk'] . ' ' . $rekap['jam_masuk']));
      $jam_tanggal_keluar = date('Y-m-d H:i:s', strtotime($rekap['tanggal_keluar'] .' '. $rekap['jam_keluar']));

      $timestamp_masuk = strtotime($jam_tanggal_masuk);
      $timestamp_keluar = strtotime($jam_tanggal_keluar);

      $selisih = $timestamp_keluar - $timestamp_masuk;

      $total_jam_kerja = floor($selisih / 3600);
      $selisih -= $total_jam_kerja * 3600;
      $selisih_menit_kerja = floor($selisih / 60);

      // Menghitung Total jam Terlambat
      $lokasi_presensi = $rekap['lokasi_presensi'];
      $lokasi = mysqli_query($connection, "SELECT * FROM  lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");
      
      while($lokasi_result = mysqli_fetch_array($lokasi)) :
          $jam_masuk_kantor = date('H:i:s', strtotime($lokasi_result['jam_masuk']));
      endwhile;

      $jam_masuk = date('H:i:s', strtotime($rekap['jam_masuk']));
      $timestamp_jam_masuk_real = strtotime($jam_masuk);
      $timestamp_jam_masuk_kantor = strtotime($jam_masuk_kantor);

      $terlambat = $timestamp_jam_masuk_real - $timestamp_jam_masuk_kantor;
      $total_jam_terlambat = floor($terlambat / 3600);
      $terlambat -= $total_jam_terlambat * 3600;
      $selisih_menit_terlambat = floor($terlambat / 60);

  ?>
  <tr>
      <td><?= $no++ ?></td>
      <td><?= $rekap['nama'] ?></td>
      <td><?= $rekap['keterangan_lokasi'] ?></td>
      <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
      <td><?= $rekap['jam_masuk'] ?></td>
      <td><?= $rekap['jam_keluar'] ?></td>
      <td>
      <?php if($rekap['tanggal_keluar'] == '0000-00-00') : ?>
              <span>0 Jam 0 Menit</span>
          <?php else: ?>
              <?= $total_jam_kerja . ' Jam ' . $selisih_menit_kerja . ' Menit ' ?>
          <?php endif; ?>
      </td>
      <td>
          <?php if($total_jam_terlambat < 0): ?>
              <span class="badge bg-success">On Time</span>
          <?php else: ?>
              <?= $total_jam_terlambat . 'Jam' . $selisih_menit_terlambat . 'Menit' ?>
          <?php endif; ?>
          
      </td>
  </tr>
  <?php endwhile;?>
  <?php } ?>
       </table>
      
      </div>
    </div>
  </div>
  <!-- export Excel -->
  <div class="modal" id="exampleModal" tabindex="-1">
                        <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
      <h5 class="modal-title">Export Excel Presensi Harian</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"
      aria-label="Close"></button>
  </div>
  <form method="POST" action="<?= base_url('admin/presensi/rekap_harian_excel.php') ?>">
  <div class="modal-body">
      <div class="mb-3">
        <label for="">Tanggal Awal</label>
        <input type="date" class="form-control" name="tanggal_dari">
      </div>
      <div class="mb-3">
        <label for="">Tanggal Akhir</label>
        <input type="date" class="form-control" name="tanggal_sampai">
      </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-danger me-auto"
      data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-success"
      data-bs-dismiss="modal">Export</button>
  </div>
  </form>
  </div>
                        </div>
                        </div>
  <!-- [ Main Content ] end -->
  
<?php include('../layout/footer.php') ?>