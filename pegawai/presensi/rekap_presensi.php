<?php

session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

if(empty($_GET['tanggal_dari'])) {
    $id = $_SESSION['id'];
    $result = mysqli_query($connection,"SELECT * FROM presensi WHERE id_pegawai = '$id' ORDER BY tanggal_masuk DESC");
}else{
    $tanggal_dari = $_GET['tanggal_dari'];
    $tanggal_sampai = $_GET['tanggal_sampai'];
    $id = $_SESSION['id'];
    $result = mysqli_query($connection,"SELECT * FROM presensi WHERE id_pegawai = '$id' AND tanggal_masuk BETWEEN '$tanggal_dari' AND '$tanggal_sampai' ORDER BY tanggal_masuk DESC");
}




$lokasi_presensi = $_SESSION['lokasi_presensi'];
$lokasi = mysqli_query($connection, "SELECT * FROM  lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");

while($lokasi_result = mysqli_fetch_array($lokasi)) :
    $jam_masuk_kantor = date('H:i:s', strtotime($lokasi_result['jam_masuk']));
endwhile;


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
                <h2 class="mb-0">Rekap Presensi</h2>
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
                  <a class="nav-link active" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab"
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
                <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                  <div class="row">
                    <div class="col-lg-4 col-xxl-3">
                      <div class="card">
                        <div class="card-body position-relative">
                          <!-- <div class="position-absolute end-0 top-0 p-3">
                            <span class="badge bg-primary">Pro</span>
                          </div> -->
                          <div class="text-center mt-3">
                            <div class="chat-avtar d-inline-flex mx-auto">
                              <img class="rounded-circle img-fluid wid-70" src="../assets/images/user/avatar-5.jpg"
                                alt="User image">
                            </div>
                            <h5 class="mb-0">Username</h5>
                            <p class="text-muted text-sm">Jabatan</p>
                            <hr class="my-3">
                            <div class="row g-3">
                              <div class="col-4">
                                <h5 class="mb-0">86</h5>
                                <small class="text-muted">Masuk</small>
                              </div>
                              <div class="col-4 border border-top-0 border-bottom-0">
                                <h5 class="mb-0">40</h5>
                                <small class="text-muted">Izin</small>
                              </div>
                              <div class="col-4">
                                <h5 class="mb-0">4</h5>
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
                              <p class="mb-0">No Handphone</p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                              <i class="ti ti-map-pin"></i>
                              <p class="mb-0">Lokasi Presensi</p>
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
                                  <p class="mb-0">Anshan Handgun</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Father Name</p>
                                  <p class="mb-0">Mr. Deepen Handgun</p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">No Handphone</p>
                                  <p class="mb-0">(+1-876) 8654 239 581</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Lokasi Presensi</p>
                                  <p class="mb-0">New York</p>
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
                                  <p class="mb-1 text-muted">Zip Code</p>
                                  <p class="mb-0">956 754</p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0 pb-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Alamat</p>
                                  <p class="mb-0">Street 110-B Kalians Bag, Dewan, M.P. New York</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Jabatan</p>
                                  <p class="mb-0">Street 110-B Kalians Bag, Dewan, M.P. New York</p>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane show active" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                  <div class="row">
                    <!-- <div class="col-lg-6"> -->
                      <div class="card">
                        <div class="card-header">
                          <h5>Rekap Presensi</h5>
                        </div>
                        <div class="card-body">
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
                          <div class="row">
                          
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Total Jam</th>
                                    <th>Total Terlambat</th>
                                </tr>

                                <?php if(mysqli_num_rows($result) === 0) {?>
                                    <tr>
                                        <td colspan="6">Data Rekap Presensi Masih Kosong</td>
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
                                        <span class="badge bg-success text-white">On Time</span>
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
                      <form method="POST" action="<?= base_url('pegawai/presensi/rekap_absen_excel.php') ?>">
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
                          <button type="button" class="btn me-auto"
                          data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success"
                          data-bs-dismiss="modal">Export</button>
                      </div>
                      </form>
                      </div>
                        </div>
                        </div>
                    
                  </div>
                </div>
                <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                  <div class="row">
                      <div class="card">
                        <div class="card-header">
                          <h5>General Settings</h5>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="Ashoka_Tano_16">
                                <small class="form-text text-muted">Your Profile URL:
                                  https://pc.com/Ashoka_Tano_16</small>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="form-label">Account Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="demo@sample.com">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" value="Ashoka_Tano_16">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>                    
                    <div class="card">
                    <div class="card-header">
                      <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <h5>New password must contain:</h5>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 8 characters</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 lower letter (a-z)
                            </li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 uppercase letter
                              (A-Z)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 number (0-9)</li>
                            <li class="list-group-item"><i class="ti ti-minus me-2"></i> At least 1 special characters
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="col-12 text-end">
                      <button class="btn btn-outline-dark ms-2">Clear</button>
                      <button class="btn btn-primary">Update Profile</button>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                      <div class="card text-center h-100">
                        <div class="card-header">Presensi Masuk</div>
                        <div class="card-body">

                        <?php 
                          
                          $id_pegawai = $_SESSION['id'];
                          $tanggal_hari_ini = date('Y-m-d');
                          $cek_presensi_masuk = mysqli_query($connection, "SELECT * FROM presensi WHERE 
                          id_pegawai = '$id_pegawai' AND tanggal_masuk = '$tanggal_hari_ini'"); 
                          ?>

                          <?php if(mysqli_num_rows($cek_presensi_masuk) === 0) { ?>

                          <div class="parent_date">
                            <div id="tanggal_masuk"></div>
                            <div class="ms-2"></div>
                            <div id="bulan_masuk"></div>
                            <div class="ms-2"></div>
                            <div id="tahun_masuk"></div>
                          </div>
                          <div class="parent_jam">
                            <div id="jam_masuk"></div>
                            <div>:</div>
                            <div id="menit_masuk"></div>
                            <div>:</div>
                            <div id="detik_masuk"></div>
                          </div>
                          
                          <form method="POST" action="<?= base_url('pegawai/presensi/presensi_masuk.php') ?>">
                            <input type="hidden" name="latitude_pegawai" id="latitude_pegawai">
                            <input type="hidden" name="longitude_pegawai" id="longitude_pegawai">
                            <input type="hidden" value="<?= $latitude_kantor ?>" name="latitude_kantor">
                            <input type="hidden" value="<?= $longitude_kantor ?>" name="longitude_kantor">
                            <input type="hidden" value="<?= $radius ?>" name="radius">
                            <input type="hidden" value="<?= $zona_waktu ?>" name="zona_waktu">
                            <input type="hidden" value="<?= date('Y-m-d') ?>" name="tanggal_masuk">
                            <input type="hidden" value="<?= date('H:i:s') ?>" name="jam_masuk">
                            <button type="submit" name="tombol_masuk" class="btn btn-primary mt-3">Masuk</button>
                          </form>
                          <?php }else { ?>
                            <i class="ti ti-circle-check ti-2fa text-success" style="font-size: 42px;"></i>
                            <h4 class="my-3">Anda telah melakukan <br> presensi masuk</h4>
                          <?php } ?>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card text-center h-100">
                        <div class="card-header">Presensi Keluar</div>
                        <div class="card-body">
                            <?php 
                            
                              $ambil_data_presensi= mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id_pegawai' AND tanggal_masuk = '$tanggal_hari_ini'");
                            
                            ?>
                            <?php $waktu_sekarang = date('H:i:s');

                            if(strtotime($waktu_sekarang) <= strtotime($jam_pulang)) { ?>
                              <i class="ti ti-x ti-2fa text-danger" style="font-size: 38px;"></i>
                              <h4 class="my-3">Belum Waktunya Pulang</h4>
                            
                              <?php } else if(strtotime($waktu_sekarang) >= strtotime($jam_pulang) && 
                                mysqli_num_rows($ambil_data_presensi) == 0) { ?>
                                <i class="ti ti-x ti-2fa text-danger" style="font-size: 38px;"></i>
                                <h5 class="my-3">Silahkan melakukan presensi masuk <br> terlebih dahulu</h5>

                              <?php } else { ?>

                                <?php while($cek_presensi_keluar = mysqli_fetch_array($ambil_data_presensi)) : ?>
                                  <?php if(($cek_presensi_keluar['tanggal_masuk']) && $cek_presensi_keluar['tanggal_keluar'] == '0000-00-00') { ?>
                              
                          <div class="parent_date">
                            <div id="tanggal_keluar"></div>
                            <div class="ms-2"></div>
                            <div id="bulan_keluar"></div>
                            <div class="ms-2"></div>
                            <div id="tahun_keluar"></div>
                          </div>
                          <div class="parent_jam">
                            <div id="jam_keluar"></div>
                            <div>:</div>
                            <div id="menit_keluar"></div>
                            <div>:</div>
                            <div id="detik_keluar"></div>
                          </div>
                          
                          <form method="POST" action="<?= base_url('pegawai/presensi/presensi_keluar.php') ?>">
                            <input type="hidden" name="id" value="<?= $cek_presensi_keluar['id'] ?>">
                            <input type="hidden" name="latitude_pegawai" id="latitude_pegawai">
                            <input type="hidden" name="longitude_pegawai" id="longitude_pegawai">
                            <input type="hidden" value="<?= $latitude_kantor ?>" name="latitude_kantor">
                            <input type="hidden" value="<?= $longitude_kantor ?>" name="longitude_kantor">
                            <input type="hidden" value="<?= $radius ?>" name="radius">
                            <input type="hidden" value="<?= $zona_waktu ?>" name="zona_waktu">
                            <input type="hidden" value="<?= date('Y-m-d') ?>" name="tanggal_keluar">
                            <input type="hidden" value="<?= date('H:i:s') ?>" name="jam_keluar">

                            <button type="submit" name="tombol_keluar" class="btn btn-danger mt-3">Keluar</button>
                          </form>
                          <?php }else{ ?>
                            <i class="ti ti-circle-check ti-2fa text-success" style="font-size: 38px;"></i>
                            <h4 class="my-3">Anda telah melakukan <br> presensi keluar</h4>
                            <?php } ?>
                          <?php endwhile; ?>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2"></div>
                  </div>
                </div>
                <div class="tab-pane" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                  <div class="card">
                    <div class="card-header">
                      <h5>Invite Team Members</h5>
                    </div>
                    <div class="card-body">
                      <h4>5/10 <small>members available in your plan.</small></h4>
                      <hr class="my-3">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <div class="row">
                              <div class="col">
                                <input type="email" class="form-control">
                              </div>
                              <div class="col-auto">
                                <button class="btn btn-primary">Send</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body table-card">
                      <div class="table-responsive">
                        <table class="table mb-0">
                          <thead>
                            <tr>
                              <th>MEMBER</th>
                              <th>ROLE</th>
                              <th class="text-end">STATUS</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-1.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Addie Bass</h5>
                                    <p class="text-muted f-12 mb-0">mareva@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-primary">Owner</span></td>
                              <td class="text-end"><span class="badge bg-success">Joined</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-4.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Agnes McGee</h5>
                                    <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-light-info">Manager</span></td>
                              <td class="text-end"><a href="#" class="btn btn-link-danger">Resend</a> <span
                                  class="badge bg-light-success">Invited</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-5.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Agnes McGee</h5>
                                    <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-light-warning">Staff</span></td>
                              <td class="text-end"><span class="badge bg-success">Joined</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-1.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Addie Bass</h5>
                                    <p class="text-muted f-12 mb-0">mareva@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-primary">Owner</span></td>
                              <td class="text-end"><span class="badge bg-success">Joined</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-4.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Agnes McGee</h5>
                                    <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-light-info">Manager</span></td>
                              <td class="text-end"><a href="#" class="btn btn-link-danger">Resend</a> <span
                                  class="badge bg-light-success">Invited</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-5.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Agnes McGee</h5>
                                    <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-light-warning">Staff</span></td>
                              <td class="text-end"><span class="badge bg-success">Joined</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-1.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Addie Bass</h5>
                                    <p class="text-muted f-12 mb-0">mareva@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-primary">Owner</span></td>
                              <td class="text-end"><span class="badge bg-success">Joined</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-4.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Agnes McGee</h5>
                                    <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-light-info">Manager</span></td>
                              <td class="text-end"><a href="#" class="btn btn-link-danger">Resend</a> <span
                                  class="badge bg-light-success">Invited</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="row">
                                  <div class="col-auto pe-0">
                                    <img src="../assets/images/user/avatar-5.jpg" alt="user-image"
                                      class="wid-40 rounded-circle">
                                  </div>
                                  <div class="col">
                                    <h5 class="mb-0">Agnes McGee</h5>
                                    <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                  </div>
                                </div>
                              </td>
                              <td><span class="badge bg-light-warning">Staff</span></td>
                              <td class="text-end"><span class="badge bg-success">Joined</span></td>
                              <td class="text-end"><a href="#" class="avtar avtar-s btn-link-secondary"><i
                                    class="ti ti-dots f-18"></i></a></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="card-footer text-end btn-page">
                      <div class="btn btn-link-danger">Cancel</div>
                      <div class="btn btn-primary">Update Profile</div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="profile-6" role="tabpanel" aria-labelledby="profile-tab-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h5>Email Settings</h5>
                        </div>
                        <div class="card-body">
                          <h6 class="mb-4">Setup Email Notification</h6>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Email Notification</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Send Copy To Personal Email</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header">
                          <h5>Updates from System Notification</h5>
                        </div>
                        <div class="card-body">
                          <h6 class="mb-4">Email you with?</h6>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">News about PCT-themes products and feature updates</p>
                            </div>
                            <div class="form-check p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Tips on getting more out of PCT-themes</p>
                            </div>
                            <div class="form-check p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Things you missed since you last logged into PCT-themes</p>
                            </div>
                            <div class="form-check  p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">News about products and other services</p>
                            </div>
                            <div class="form-check p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Tips and Document business products</p>
                            </div>
                            <div class="form-check p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h5>Activity Related Emails</h5>
                        </div>
                        <div class="card-body">
                          <h6 class="mb-4">When to email?</h6>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Have new notifications</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">You're sent a direct message</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Someone adds you as a connection</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                          <hr class="my-4">
                          <h6 class="mb-4">When to escalate emails?</h6>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Upon new order</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">New membership approval</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch">
                            </div>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Member registration</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative" type="checkbox" role="switch" checked="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 text-end btn-page">
                      <div class="btn btn-outline-secondary">Cancel</div>
                      <div class="btn btn-primary">Update Profile</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      <script>
        // Set Waktu Presensi Masuk
        window.setTimeout("waktuMasuk()", 1000);
        namaBulan = ["Januari","Februari","Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        function waktuMasuk(){
          const waktu = new Date();
          setTimeout("waktuMasuk()", 1000);
          document.getElementById("tanggal_masuk").innerHTML = waktu.getDate();
          document.getElementById("bulan_masuk").innerHTML = namaBulan[waktu.getMonth()];
          document.getElementById("tahun_masuk").innerHTML = waktu.getFullYear();
          document.getElementById("jam_masuk").innerHTML = waktu.getHours();
          document.getElementById("menit_masuk").innerHTML = waktu.getMinutes();
          document.getElementById("detik_masuk").innerHTML = waktu.getSeconds();
        }
        <!-- Set Waktu Presensi Keluar -->
        window.setTimeout("waktuKeluar()", 1000);
        namaBulan = ["Januari","Februari","Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        function waktuKeluar(){
          const waktu = new Date();
          setTimeout("waktuKeluar()", 1000);
          document.getElementById("tanggal_keluar").innerHTML = waktu.getDate();
          document.getElementById("bulan_keluar").innerHTML = namaBulan[waktu.getMonth()];
          document.getElementById("tahun_keluar").innerHTML = waktu.getFullYear();
          document.getElementById("jam_keluar").innerHTML = waktu.getHours();
          document.getElementById("menit_keluar").innerHTML = waktu.getMinutes();
          document.getElementById("detik_keluar").innerHTML = waktu.getSeconds();
        }

        getLocation();

        function getLocation(){
          if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(showPosition);
          }else{
            alert("Browser anda tidak mendukung Lokasi");
          }
        }

        function showPosition(position){
          $('#latitude_pegawai').val(position.coords.latitude);
          $('#longitude_pegawai').val(position.coords.longitude);
        }

        window.onload = getLocation;

        form.addEventListener("submit", function (e) {
          if (latitudeField.value === "" || longitudeField.value === "") {
            e.preventDefault(); // blokir form
            alert("Koordinat belum didapat. Tunggu beberapa saat atau refresh.");
          }
  });
      </script>
      
      <!-- [ Main Content ] end -->
  <?php include('../layout/footer.php') ?>
  