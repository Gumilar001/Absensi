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
$result = mysqli_query($connection,"SELECT * FROM ketidakhadiran ORDER BY id DESC");

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
                <li class="breadcrumb-item" aria-current="page">Ketidakhadiran</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-3">Ketidakhadiran</h3>

       <table class="table table-bordered text-center">
         <thead>
            <tr>
              <th>NO</th>
              <th>Tanggal Cuti/Izin/Sakit</th>
              <th>Keterangan</th>
              <th>Deskripsi</th>
              <th>File</th>
              <th>Status Pengajuan</th>
            </tr>

         </thead>
         <tbody>
                   <?php if(mysqli_num_rows($result) === 0 ) { ?>
                     <tr>
                       <td colspan="7">Data ketidakhadiran masih kosong</td>
                     </tr>
                     <?php } else { ?>
                       <?php 
        $no = 1;
        while($data = mysqli_fetch_array($result)) :?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= date('d F Y', strtotime($data['tanggal_pengajuan'])) ?></td>
          <td><?= $data['keterangan'] ?></td>
          <td><?= $data['deskripsi'] ?></td>
          <td>
            <a target="_blank" href="<?= base_url('assets/assets/dokumen/' . $data['file'] ) ?>" class="badge badge-pill bg-primary ti ti-download"> Download</a>
          </td>
          <td>
            <?php 
                if($data['status_pengajuan'] == 'PENDING') :            ?>
                <a class="badge badge-pill bg-warning" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id=' . $data['id']) ?>">PENDING</a>
                <?php elseif($data['status_pengajuan'] == 'REJECTED') :?>
                    <a class="badge badge-pill bg-danger" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id='. $data['id']) ?>">REJECTED</a>
                    <?php else : ?>
                        <a class="badge badge-pill bg-success" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id='. $data['id']) ?>">APPROVED</a>
                    <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>

                 <?php } ?>
                 </tbody>
               </table>
      
      </div>
    </div>
  </div>
    <!-- [ Main Content ] end -->

<?php include('../layout/footer.php') ?>