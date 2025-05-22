<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
      <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

     <style>
      #map{
        height: 300px;
      }
     </style>
<?php 

session_start();
ob_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} elseif ($_SESSION["role"] != 'workshop') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include('../layout/header.php'); 

include_once('../../pegawai/config.php');

if(isset($_POST['tombol_keluar'])) {
    $id = $_POST['id'];
    $latitude_pegawai = $_POST['latitude_pegawai'];
    $longitude_pegawai = $_POST['longitude_pegawai'];
    $latitude_kantor = $_POST['latitude_kantor'];
    $longitude_kantor = $_POST['longitude_kantor'];
    $radius = $_POST['radius'];
    $zona_waktu = $_POST['zona_waktu'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $jam_keluar = $_POST['jam_keluar'];
}

if(empty($latitude_pegawai) || empty($longitude_pegawai)){
    $_SESSION['gagal'] = "Mohon Aktifkan Lokasi Anda";
    header("Location: ../home/home.php");
    exit;
  }

$perbedaan_kordinat = $longitude_kantor - $longitude_kantor;
$jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) 
* cos(deg2rad($latitude_kantor)) * cos(deg2rad($perbedaan_kordinat));
$jarak = acos($jarak);
$jarak = rad2deg($jarak);
$mil = $jarak * 60 * 1.1515;
$km = $mil * 1.609344;
$meter = $km * 1000;


?>
<?php 
if($meter > $radius){ ?>
  <?=
  $_SESSION['gagal'] = "Anda berada di luar area kantor";
  header("Location: ../home/home.php");
  exit;
  ?>
<?php }else{ ?>
  <div class="container">
    <div class="content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item mt-5"><a href="<?=  base_url('workshop/home/home.php') ?>">Home</a></li>
                <li class="breadcrumb-item mt-5"><a href="<?=  base_url('workshop/home/home.php') ?>">Dashboard</a></li>
                <li class="breadcrumb-item mt-5" aria-current="page">Absensi Keluar</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0 mt-3">Absensi Keluar</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
  <div class="page-body">
    <div class="container-xl">
      <div class="row" >

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
            <div id="map">

            </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card text-center">
            <div class="card-body" style="margin: auto;">
              <input type="hidden" id="id" value="<?= $id ?>">
              <input type="hidden" id="tanggal_keluar" value="<?= $tanggal_keluar ?>">
              <input type="hidden" id="jam_keluar" value="<?= $jam_keluar ?>">
              <div id="my_camera" style="width:420px; height:340px; margin: auto; align-items: center;"></div>
              <div id="my_result"></div>
              <div><?= date('d F Y', strtotime($tanggal_keluar)) . ' - ' . $jam_keluar ?></div>
              <button class="btn btn-danger mt-2" id="ambil_foto">Keluar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <script language="JavaScript">
        Webcam.set({
          width: 320,
          height: 240,
          dest_width: 320,
          dest_height: 240,
          image_format: 'jpeg',
          jpeg_quality: 90,
          force_flash: false
      });
          Webcam.attach( '#my_camera' );
          
          document.getElementById('ambil_foto').addEventListener('click', function() {

            let id = document.getElementById('id').value;
            let tanggal_keluar = document.getElementById('tanggal_keluar').value;
            let jam_keluar = document.getElementById('jam_keluar').value;
              Webcam.snap(function(data_uri) {
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                    document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>';
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                      window.location.href = '../home/home.php';
                    }
                  };
                  xhttp.open("POST", "presensi_keluar_aksi.php", true);
                  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  xhttp.send(
                    'photo=' + encodeURIComponent(data_uri) +
                    '&id=' + id +
                    '&tanggal_keluar=' + tanggal_keluar +
                    '&jam_keluar=' + jam_keluar
                  );
                  
              });
          });
          // Map Leaflet js
          let latitude_ktr = <?= $latitude_kantor ?>;
          let longitude_ktr = <?= $longitude_kantor ?>;
          
          let latitude_peg = <?= $latitude_pegawai ?>;
          let longitude_peg = <?= $longitude_pegawai ?>;

          let map = L.map('map').setView([latitude_ktr, longitude_ktr], 13);
          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
              maxZoom: 19,
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
          }).addTo(map);

          var marker = L.marker([latitude_ktr, longitude_ktr]).addTo(map);

          var circle = L.circle([latitude_peg, longitude_peg], {
              color: 'red',
              fillColor: '#f03',
              fillOpacity: 0.5,
              radius: 500
          }).addTo(map).bindPopup("Lokasi Anda saat ini").openPopup();
      </script>
      <!-- <a href="javascript:void(take_snapshot())" style="align-items: center;">Take Snapshot</a> -->
<?php } ?>

  <?php include('../layout/footer.php') ?>