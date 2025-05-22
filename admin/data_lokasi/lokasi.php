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

$result = mysqli_query($connection, "SELECT * FROM lokasi_presensi ORDER BY id DESC");
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
                <li class="breadcrumb-item" aria-current="page">Data Lokasi Presensi</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Data Lokasi Presensi</h3>

      <a href="<?= base_url('admin/data_lokasi/tambah.php') ?>" class="btn btn-primary mb-3 ti ti-layout-grid-add"> Tambah Data</a>

       <table class="table table-bordered text-center">
        <tr>
            <th>No.</th>
            <th>Nama Lokasi</th>
            <th>Alamat Lokasi</th>
            <th>Latitude/Longitude</th>
            <th>Radius</th>
            <th>Aksi</th>
        </tr>
         <?php if(mysqli_num_rows($result)=== 0){     ?>
            <tr>
                <td colspan="6">Data Kosong, silahkan tambahkan data baru</td>
            </tr>
            <?php } else { ?>
                <?php  $no = 1;
                    while($lokasi = mysqli_fetch_array($result)) : ?>
                    <tr>
                        <td><?= $no++    ?></td>
                        <td><?= $lokasi['nama_lokasi']    ?></td>
                        <td><?= $lokasi['alamat_lokasi']    ?></td>
                        <td><?= $lokasi['latitude'] . '/' . $lokasi['longitude']    ?></td>
                        <td><?= $lokasi['radius']    ?></td>
                        <td>
                            <a href="<?= base_url('admin/data_lokasi/detail.php?id=' . $lokasi
                            ['id'] )   ?>" class="badge badge-pill bg-primary"> Detail</a>
                            <a href="<?= base_url('admin/data_lokasi/edit.php?id=' . $lokasi
                            ['id'] )   ?>" class="badge badge-pill bg-primary"> Edit</a>
                            <a href="<?= base_url('admin/data_lokasi/hapus.php?id=' . $lokasi
                            ['id'] )   ?>" class="badge badge-pill bg-danger tombol-hapus"> Hapus</a>
                        </td>
                        
                    </tr>
                <?php   endwhile; ?>
            <?php }  ?>
       </table>
      
      </div>
    </div>
  </div>
    <!-- [ Main Content ] end -->
  
<?php include('../layout/footer.php') ?>