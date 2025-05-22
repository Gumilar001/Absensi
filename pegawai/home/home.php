<?php 

session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');
$lokasi_presensi = $_SESSION['lokasi_presensi'];

$result = mysqli_query($connection, "SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");

while($lokasi = mysqli_fetch_array($result)){
  $latitude_kantor = $lokasi['latitude'];
  $longitude_kantor = $lokasi['longitude'];
  $radius = $lokasi['radius'];
  $zona_waktu = $lokasi['zona_waktu'];
  $jam_pulang = $lokasi['jam_pulang'];
  $nama_lokasi = $lokasi['nama_lokasi'];
}

if($zona_waktu == 'WIB'){
  date_default_timezone_set('Asia/Jakarta');
}else if($zona_waktu == 'WITA'){
  date_default_timezone_set('Asia/Makassar');
}else if($zona_waktu == 'WIT'){
  date_default_timezone_set('Asia/Jayapura');
}
?>
<style>
  .parent_date{
    display: grid;
    grid-template-columns: auto auto auto auto auto;
    font-size: 20px;
    text-align: center;
    justify-content: center;
  }
  .parent_jam{
    display: grid;
    grid-template-columns: auto auto auto auto auto;
    font-size: 30px;
    text-align: center;
    font-weight: bold;
    justify-content: center;
  }
</style>

       <!-- [ Main Content ] start -->
  <div class="container">
    <div class="content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Dashboard</h2>
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
                  <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab"
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
                  <a class="nav-link" id="profile-tab-5"href="<?= base_url('pegawai/ketidakhadiran/ketidakhadiran.php') ?>" role="tab"
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
                
                <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                      <div class="card text-center h-100">
                        <div class="card-header"><h4 class="my-3">Presensi Masuk</h4></div>
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
                            <input type="hidden" value="<?= $nama_lokasi ?>" name="nama_lokasi">
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
                        <div class="card-header"><h4 class="my-3">Presensi Keluar</h4></div>
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
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
      </div>
      </div>
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
  