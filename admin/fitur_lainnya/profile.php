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

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT user.id_pegawai, user.username, user.status, user.role, 
pegawai.* FROM user JOIN pegawai ON user.id_pegawai = pegawai.id WHERE pegawai.id = $id");
?>
<?php
while ($pegawai = mysqli_fetch_array($result)) :
    # code...
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
                <li class="breadcrumb-item" aria-current="page">Profile</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
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
                                  <p class="mb-1 text-muted"> Status</p>
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

      <!-- <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card"> -->
              
                <!-- <div class="card-body">
                    <div style="display: flex; justify-content: center;">
                    <img class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;"  src="<?= base_url('assets/assets/images/foto_pegawai/' . $pegawai['foto']) ?>" alt="">
                    </div>
                    <table class="table table-bordered mt-4">
                        <tr>
                            <td>Nama    </td>
                            <td><?= $pegawai['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Username    </td>
                            <td><?= $pegawai['username'] ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin    </td>
                            <td><?= $pegawai['jenis_kelamin'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat    </td>
                            <td><?= $pegawai['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td>No Handphone    </td>
                            <td><?= $pegawai['no_hp'] ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan    </td>
                            <td><?= $pegawai['jabatan'] ?></td>
                        </tr>
                        <tr>
                            <td>Role    </td>
                            <td><?= $pegawai['role'] ?></td>
                        </tr>
                        <tr>
                            <td>Lokasi Presensi    </td>
                            <td><?= $pegawai['lokasi_presensi'] ?></td>
                        </tr>
                        <tr>
                            <td>Status    </td>
                            <td><?= $pegawai['status'] ?></td>
                        </tr>
                    </table>
                </div> -->
            </div>
        </div>
      </div>
      
      </div>
    </div>
  </div>
    <!-- [ Main Content ] end -->
  <?php endwhile; ?>
<?php include('../layout/footer.php') ?>