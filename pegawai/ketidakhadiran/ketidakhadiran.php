<?php 

ob_start();
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');
$id = $_SESSION['id'];
$result = mysqli_query($connection,"SELECT * FROM ketidakhadiran WHERE id_pegawai = '$id' ORDER BY id DESC")
?>

       <!-- [ Main Content ] start -->
  <div class="container">
    <div class="content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <!-- <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                <li class="breadcrumb-item" aria-current="page">Account Profile</li>
              </ul>
            </div> -->
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Ketidakhadiran</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header pb-0">
              <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">                
                <li class="nav-item">
                  <a class="nav-link " id="profile-tab-1" href="<?= base_url('pegawai/home/home.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-clipboard-check"></i>Absensi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-2" href="<?= base_url('pegawai/presensi/rekap_presensi.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-clipboard-check me-2"></i>Rekap Presensi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-3" href="<?= base_url('pegawai/fitur_lainnya/edit.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-id me-2"></i>My Account
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-4" href="<?= base_url('pegawai/fitur_lainnya/profile.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-user me-2"></i>Profile
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="profile-tab-5" data-bs-toggle="tab" href="#profile-5" role="tab"
                    aria-selected="true">
                    <i class="ti ti-clipboard-x me-2"></i>Ketidakhadiran
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-6" href="<?= base_url('auth/logout.php') ?>" role="tab"
                    aria-selected="true">
                    <i class="ti ti-logout me-2"></i>Logout
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">                                                
                </div>
                <div class="tab-pane show active" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                  <div class="card">
                    <div class="card-header">
                      <h5>Pengajuan Ketidakhadiran</h5>
                    </div>
                    <div class="card-body table-card">
                      <div class="table-responsive">
                        <a href="<?= base_url("pegawai/ketidakhadiran/pengajuan_ketidakhadiran.php") ?>" class="btn btn-primary ti ti-layout-grid-add mb-3"> Tambah Data</a>
                        <table class="table table-bordered text-center">
                          <thead>
                            <tr>
                              <th>NO</th>
                              <th>Tanggal</th>
                              <th>Keterangan</th>
                              <th>Deskripsi</th>
                              <th>File</th>
                              <th>Status Pengajuan</th>
                              <th>Aksi</th>
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
                                      <a target="_blank" href="<?= base_url('assets/assets/dokumen/' . $data['file'] ) ?>" class="badge badge-pill bg-primary text-white ti ti-download"> Download</a>
                                    </td>
                                    <td><?= $data['status_pengajuan'] ?></td>
                                    <td>
                                      <a href="edit.php?id=<?= $data['id'] ?>"><span  class="badge badge-pill bg-success text-white"> Update</span></a>
                                      <a href="hapus.php?id=<?= $data['id'] ?>" class="badge badge-pill bg-danger text-white tombol-hapus"> Hapus</a>
                                    </td>
                                  </tr>
                                  <?php endwhile; ?>
                           
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      
      <!-- [ Main Content ] end -->
  <?php include('../layout/footer.php') ?>
  