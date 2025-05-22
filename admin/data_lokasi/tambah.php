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

// $result = mysqli_query($connection, "SELECT * FROM lokasi_presensi ORDER BY id DESC");
if (isset($_POST['submit'])) {
    $nama_lokasi = htmlspecialchars($_POST['nama_lokasi']);
    $alamat_lokasi = htmlspecialchars($_POST['alamat_lokasi']);
    $tipe_lokasi = htmlspecialchars($_POST['tipe_lokasi']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    $radius = htmlspecialchars($_POST['radius']);
    $zona_waktu = htmlspecialchars($_POST['zona_waktu']);
    $jam_masuk = htmlspecialchars($_POST['jam_masuk']);
    $jam_pulang = htmlspecialchars($_POST['jam_pulang']);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($nama_lokasi)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Nama lokasi wajib diisi";
        }
        if(empty($alamat_lokasi)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Alamat lokasi wajib diisi";
        }
        if(empty($tipe_lokasi)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Tipe Lokasi wajib diisi";
        }
        if(empty($latitude)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Latitude lokasi wajib diisi";
        }
        if(empty($longitude)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Longitude lokasi wajib diisi";
        }
        if(empty($radius)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Radius wajib diisi";
        }
        if(empty($zona_waktu)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Zona Waktu wajib diisi";
        }
        if(empty($jam_masuk)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Jam Masuk wajib diisi";
        }
        if(empty($jam_pulang)){
            $pesan_kesalahan[] = "<i class = 'ti ti-checkbox'></i>Jam Pulang wajib diisi";
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        }else{
            $result = mysqli_query($connection, "INSERT INTO lokasi_presensi(nama_lokasi, alamat_lokasi, 
            tipe_lokasi, latitude, longitude, radius, zona_waktu, jam_masuk, jam_pulang ) VALUES ('$nama_lokasi',
            '$alamat_lokasi','$tipe_lokasi','$latitude','$longitude','$radius','$zona_waktu','$jam_masuk','$jam_pulang')");
        
            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: lokasi.php");
            exit;
    }
}
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
                <li class="breadcrumb-item"><a href="<?=  base_url('admin/data_lokasi/lokasi.php') ?>">Data Lokasi Presensi</a></li>
                <li class="breadcrumb-item" aria-current="page">Tambah Data</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

      <h3 class="mb-2">Tambah Lokasi Presensi</h3>

      <div class="card col-md-6">
        <div class="card-body">
            <form action="<?= base_url('admin/data_lokasi/tambah.php')?>" method="POST">
                <div class="mb-3">
                    <label for="">Nama Lokasi</label>
                    <input type="text" class="form-control" name="nama_lokasi" value="<?php if(isset($_POST['nama_lokasi'])) echo $_POST['nama_lokasi'] ?>">
                </div>
                <div class="mb-3">
                    <label for="">Alamat Lokasi</label>
                    <input type="text" class="form-control" name="alamat_lokasi" value="<?php if(isset($_POST['alamat_lokasi'])) echo $_POST['alamat_lokasi'] ?>">
                </div>
                <div class="mb-3">
                    <label for="">Tipe Lokasi</label>
                    <select class="form-control" name="tipe_lokasi">
                        <option value="">Pilih Tipe Lokasi</option>
                        <option <?php if(isset($_POST['tipe_lokasi']) && $_POST['tipe_lokasi'] == 
                        'Pusat') {
                            echo 'selected';
                        }?> value="Pusat">Pusat</option>
                        <option <?php if(isset($_POST['tipe_lokasi']) && $_POST['tipe_lokasi'] == 
                        'Cabang') {
                            echo 'selected';
                        }?> value="Cabang">Cabang</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Latitude</label>
                    <input type="text" class="form-control" name="latitude" value="<?php if(isset($_POST['latitude'])) echo $_POST['latitude'] ?>">
                </div>
                <div class="mb-3">
                    <label for="">Longitude</label>
                    <input type="text" class="form-control" name="longitude" value="<?php if(isset($_POST['longitude'])) echo $_POST['longitude'] ?>">
                </div>
                <div class="mb-3">
                    <label for="">Radius</label>
                    <input type="text" class="form-control" name="radius" value="<?php if(isset($_POST['radius'])) echo $_POST['radius'] ?>">
                </div>
                <div class="mb-3">
                    <label for="">Zona Waktu</label>
                    <select class="form-control" name="zona_waktu" value="<?php if(isset($_POST['zona_waktu'])) echo $_POST['zona_waktu'] ?>">
                        <option value="">Pilih Zona Waktu</option>
                        <option <?php if(isset($_POST['zona_waktu']) && $_POST['zona_waktu'] == 
                        'WIB') {
                            echo 'selected';
                        }?> value="WIB">WIB</option>
                        <option <?php if(isset($_POST['zona_waktu']) && $_POST['zona_waktu'] == 
                        'WIT') {
                            echo 'selected';
                        }?> value="WIT">WIT</option>
                        <option <?php if(isset($_POST['zona_waktu']) && $_POST['zona_waktu'] == 
                        'WITA') {
                            echo 'selected';
                        }?> value="WITA">WITA</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Jam Masuk</label>
                    <input type="time" class="form-control" name="jam_masuk" value="<?php if(isset($_POST['jam_masuk'])) echo $_POST['jam_masuk'] ?>">
                </div>
                <div class="mb-3">
                    <label for="">Jam Pulang</label>
                    <input type="time" class="form-control" name="jam_pulang" value="<?php if(isset($_POST['jam_pulang'])) echo $_POST['jam_pulang'] ?>">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
      </div>

      

       
      
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <!-- [ Sweet Alert ] Start -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- [ Sweet Alert ] end -->
  

<?php include('../layout/footer.php') ?>