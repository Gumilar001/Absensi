<?php 

session_start();
ob_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

if(isset($_POST['submit'])) {
    $id = $_POST['id_pegawai'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $status_pengajuan = 'PENDING';

    if(isset($_FILES['file'])){
        $file = $_FILES['file'];
        $nama_file = $file['name'];
        $file_tmp = $file['tmp_name'];
        $ukuran_file = $file['size'];
        $file_direktori = "../../assets/assets/dokumen/" . $nama_file;

        $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_diizinkan = ["jpg", "png", "jpeg", "pdf", "Word"];
        $maks_ukuran_file = 10 * 1024 * 1024;

        move_uploaded_file($file_tmp, $file_direktori);
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($keterangan)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Keterangan wajib diisi";
        }
        if(empty($deskripsi)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Deskripsi wajib diisi";
        }
        if(empty($tanggal)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Tanggal wajib diisi";
        }
        if(!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Hanya file JPG, JPEG, dan PNG yang diizinkan!";
        }
        if($ukuran_file > $maks_ukuran_file){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Ukuran file melebihi 10mb!";
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        }else{
            $result = mysqli_query($connection, "INSERT INTO ketidakhadiran(id_pegawai, keterangan, 
            deskripsi, tanggal_pengajuan, status_pengajuan, file ) VALUES ('$id',
            '$keterangan','$deskripsi','$tanggal','$status_pengajuan','$nama_file')");

            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: ketidakhadiran.php");
            exit;
    }
}
}
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
                <h2 class="mb-0">Pengajuan Ketidakhadiran</h2>
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
                  </div>
                </div>
                <div class="tab-pane show active" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                <a href="<?= base_url("pegawai/ketidakhadiran/ketidakhadiran.php") ?>" class="btn btn-primary ti ti-arrow-back mb-3"> Kembali</a>    
                <div class="row justify-content-center">
                  <div class="card col-md-8">
                    <div class="card-header">
                      <h5>Pengajuan Ketidakhadiran</h5>
                    </div>
                    <div class="card-body table-card">
                      <div class="table-responsive">
                        <!-- <a href="<?= base_url("pegawai/ketidakhadiran/ketidakhadiran.php") ?>" class="btn btn-primary ti ti-arrow-back mb-3"> Kembali</a> -->
                    <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id_pegawai" >
                            <div class="mb-3">
                                <label for="">Keterangan</label>
                                <select class="form-control" name="keterangan">
                                    <option value="">Pilih Keterangan</option>
                                    <option <?php if(isset($_POST['keterangan']) && $_POST['keterangan'] == 
                                    'Cuti') {
                                        echo 'selected';
                                    }?> value="Cuti">Cuti</option>
                                    <option <?php if(isset($_POST['keterangan']) && $_POST['keterangan'] == 
                                    'Sakit') {
                                        echo 'selected';
                                    }?> value="Sakit">Sakit</option>
                                    <option <?php if(isset($_POST['keterangan']) && $_POST['keterangan'] == 
                                    'Izin') {
                                        echo 'selected';
                                    }?> value="Izin">Izin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Deskripsi</label>
                                <textarea value cols="30" rows="10" name="deskripsi" class="form-control" ><?php echo isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">Surat Keterangan</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Ajukan</button>
                            </form>
                      </div>
                    </div>
                    </div>
                    <!-- <div class="card-footer text-end btn-page">
                      <div class="btn btn-link-danger">Cancel</div>
                      <div type="submit" class="btn btn-primary" name="submit">Ajukan</div>
                    </div> -->
                    <!-- </form> -->
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
  