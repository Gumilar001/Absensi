<?php 

session_start();
ob_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'workshop') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    if($_FILES['file_baru']['error'] === 4){
        $file_lama = $_POST['file_lama'];
    }else{
        
        $file = $_FILES['file_baru'];
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
        if($_FILES['file_baru']['error'] != 4){
            if(!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)){
                $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Hanya file JPG, JPEG, dan PNG yang diizinkan!";
            }
            if($ukuran_file > $maks_ukuran_file){
                $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Ukuran file melebihi 10mb!";
            }
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        }else{
            $result = mysqli_query($connection, "UPDATE  ketidakhadiran SET keterangan='$keterangan', deskripsi='$deskripsi', tanggal_pengajuan='$tanggal', file='$nama_file' WHERE id = $id");

            $_SESSION['berhasil'] = "Data berhasil diupdate";
            header("Location: ketidakhadiran.php");
            exit;
    }
}
}
$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM ketidakhadiran WHERE id=$id ");
while($data = mysqli_fetch_array($result)){
    $keterangan = $data['keterangan'];
    $deskripsi = $data['deskripsi'];
    $tanggal = $data['tanggal_pengajuan'];
    $file = $data['file'];
}
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
            <div class="card-body">
              <div class="tab-content">                                                
                </div>
                <div class="tab-pane show active" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                <a href="<?= base_url("workshop/ketidakhadiran/ketidakhadiran.php") ?>" class="btn btn-primary ti ti-arrow-back mb-3"> Kembali</a>    
                <div class="row justify-content-center">
                  <div class="card col-md-8">
                    <div class="card-header">
                      <h5>Edit Pengajuan Ketidakhadiran</h5>
                    </div>
                    <div class="card-body table-card">
                      <div class="table-responsive">                      
                    <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id_pegawai" >
                            <div class="mb-3">
                                <label for="">Keterangan</label>
                                <select class="form-control" name="keterangan">
                                    <option value="">Pilih Keterangan</option>
                                    <option <?php if ($keterangan == 'Cuti'){
                                        echo 'selected';
                                    } ?> value="Cuti">Cuti</option>

                                    <option <?php if ($keterangan == 'Izin'){
                                        echo 'selected';
                                    } ?> value="Izin">Izin</option>

                                    <option <?php if ($keterangan == 'Sakit'){
                                        echo 'selected';
                                    } ?> value="Sakit">Sakit</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Deskripsi</label>
                                <textarea value cols="30" rows="10" name="deskripsi" class="form-control" ><?= $deskripsi ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
                            </div>
                            <div class="mb-3">
                                <label for="">Surat Keterangan</label>
                                <input type="file" name="file_baru" class="form-control">
                                <input type="hidden" name="file_lama" value="<?= $file ?>">
                            </div>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
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
  