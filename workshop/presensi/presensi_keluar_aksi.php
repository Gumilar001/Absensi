<?php 
ob_start();
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} elseif ($_SESSION["role"] != 'workshop') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

include_once('../../pegawai/config.php');

$file_foto = $_POST['photo'];
$id_presensi = $_POST['id'];
$tanggal_keluar = $_POST['tanggal_keluar'];
$jam_keluar = $_POST['jam_keluar'];

$foto = $file_foto;
$foto = str_replace('data:image/jpeg;base64,','', $foto);
$foto = str_replace(' ','+', $foto);
$data = base64_decode($foto);
$nama_file = 'foto/' . $id_presensi . '_keluar_' . date('Y-m-d') . '.png';
$file = $id_presensi . '_keluar_' . date('Y-m-d') . '.png';
file_put_contents($nama_file,$data);

$result = mysqli_query($connection, "UPDATE presensi SET tanggal_keluar = '$tanggal_keluar', jam_keluar = '$jam_keluar', foto_keluar = '$file' WHERE id = $id_presensi ");

if($result){
    $_SESSION['berhasil'] = "Presensi Keluar Berhasil";
    echo "<script>
    alert('Presensi Berhasil');
    window.location.href = '../home/home.php';
</script>";
    exit;
}else{
    $_SESSION['gagal'] = "Presensi Keluar Gagal";
    header("Location: ../home/home.php");
    exit;
}

?>
  <?php include('../layout/footer.php') ?>