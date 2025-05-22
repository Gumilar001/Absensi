<?php 
ob_start();
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} elseif ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

require_once('../../pegawai/config.php');

$file_foto = $_POST['photo'];
$id_pegawai = $_POST['id'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$jam_masuk = $_POST['jam_masuk'];
$nama_lokasi = $_POST['nama_lokasi'];

$foto = $file_foto;
$foto = str_replace('data:image/jpeg;base64,','', $foto);
$foto = str_replace(' ','+', $foto);
$data = base64_decode($foto);
$nama_file = 'foto/' . $id_pegawai .  '_masuk_' . date('Y-m-d') . '.png';
$file = $id_pegawai . '_masuk_' . date('Y-m-d') . '.png';
file_put_contents($nama_file,$data);

$result = mysqli_query($connection, "INSERT INTO presensi(id_pegawai, keterangan_lokasi, tanggal_masuk, jam_masuk, foto_masuk) 
VALUES ('$id_pegawai','$nama_lokasi', '$tanggal_masuk', '$jam_masuk', '$file')");

if($result){
    $_SESSION['berhasil'] = "Presensi Masuk Berhasil";
    header("Location: ../home/home.php");
}else{
    $_SESSION['gagal'] = "Presensi Masuk Gagal";
    header("Location: ../home/home.php");
}

?>
  <?php include('../layout/footer.php') ?>