<?php

session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

$id = $_SESSION['id'];
$tahun_ini = date('Y');
$tanggal_awal = "$tahun_ini-01-01";
$tanggal_akhir = date('Y-m-d');

$result = mysqli_query($connection, "SELECT user.id_pegawai, user.username, user.status, user.role, 
pegawai.* FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");

function hitungHariKerja($start, $end) {
    $start = new DateTime($start);
    $end = new DateTime($end);
    $hari_kerja = 0;

    while ($start <= $end) {
        if (!in_array($start->format('N'), [6, 7])) {
            $hari_kerja++;
        }
        $start->modify('+1 day');
    }
    return $hari_kerja;
}
$pegawai_hadir = mysqli_query($connection, "SELECT COUNT(*) AS jumlah_hadir FROM presensi WHERE id_pegawai = '$id' 
      AND tanggal_masuk BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
$pegawai_izin = mysqli_query($connection, "SELECT COUNT(*) AS jumlah_izin FROM ketidakhadiran WHERE id_pegawai = '$id' 
      AND status_pengajuan = 'APPROVED' 
      AND tanggal_pengajuan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
");
$jumlah_izin = mysqli_fetch_assoc($pegawai_izin)['jumlah_izin'];

$jumlah_hadir = mysqli_fetch_assoc($pegawai_hadir)['jumlah_hadir'];

$total_hari_kerja = hitungHariKerja($tanggal_awal, $tanggal_akhir);
#$jumlah_alpa = max(0, $total_hari_kerja - ($jumlah_hadir + $jumlah_izin));
?>
<?php
while ($pegawai = mysqli_fetch_array($result)) :
    # code...
?>

       <!-- [ Main Content ] start -->
  <div class="container">
    <div class="content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Profile</h2>
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
                  <a class="nav-link" id="profile-tab-1" href="<?= base_url('pegawai/home/home.php') ?>" role="tab"
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
                <li class="nav-item ">
                  <a class="nav-link active" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4" role="tab"
                    aria-selected="true">
                    <i class="ti ti-user me-2"></i>Profile
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab-5" href="<?= base_url('pegawai/ketidakhadiran/ketidakhadiran.php') ?>" role="tab"
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
                <div class="tab-pane show active" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                  <div class="row">
                    <div class="col-lg-4 col-xxl-3">
                      <div class="card">
                        <div class="card-body position-relative">
                          <div class="text-center mt-3">
                            <div class="chat-avtar d-inline-flex mx-auto">
                              <img class="rounded-circle img-fluid wid-70" style="width: 150px; height: 150px; object-fit: cover;" src="<?= base_url('assets/assets/images/foto_pegawai/' . $pegawai['foto']) ?>"
                                alt="User image">
                            </div>
                            <h5 class="mb-0"><?= $pegawai['username'] ?></h5>
                            <p class="text-muted text-sm"><?= $pegawai['jabatan'] ?></p>
                            <hr class="my-3">
                            <div class="row g-3">
                              <div class="col-4">
                                <h5 class="mb-0"><?= $jumlah_hadir ?></h5>
                                <small class="text-muted">Masuk</small>
                              </div>
                              <div class="col-4 border border-top-0 border-bottom-0">
                                <h5 class="mb-0"><?= $jumlah_izin ?></h5>
                                <small class="text-muted">Izin</small>
                              </div>
                              <div class="col-4">
                                <h5 class="mb-0">0</h5>
                                <small class="text-muted">Tidak hadir</small>
                              </div>
                            </div>
                            <hr class="my-3">
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                              <i class="ti ti-mail"></i>
                              <p class="mb-0">email@gmail.com</p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                              <i class="ti ti-phone"></i>
                              <p class="mb-0"><?= $pegawai['no_hp'] ?></p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                              <i class="ti ti-map-pin"></i>
                              <p class="mb-0"><?= $pegawai['lokasi_presensi'] ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="col-lg-8 col-xxl-9">
                      
                      <div class="card">
                        <div class="card-header">
                          <h5>Personal Details</h5>
                        </div>
                        <div class="card-body">
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 pt-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Full Name</p>
                                  <p class="mb-0"><?= $pegawai['nama'] ?></p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Username</p>
                                  <p class="mb-0"><?= $pegawai['username'] ?></p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">No Handphone</p>
                                  <p class="mb-0"><?= $pegawai['no_hp'] ?></p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Lokasi Presensi</p>
                                  <p class="mb-0"><?= $pegawai['lokasi_presensi'] ?></p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Email</p>
                                  <p class="mb-0">anshan.dh81@gmail.com</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Status</p>
                                  <p class="mb-0"><?= $pegawai['status'] ?></p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0 pb-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Alamat</p>
                                  <p class="mb-0"><?= $pegawai['alamat'] ?></p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Jabatan</p>
                                  <p class="mb-0"><?= $pegawai['jabatan'] ?></p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0 pb-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Role</p>
                                  <p class="mb-0"><?= $pegawai['role'] ?></p>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
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
  <?php endwhile; ?>
  <?php include('../layout/footer.php') ?>
  