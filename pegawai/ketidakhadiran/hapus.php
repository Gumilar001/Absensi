<?php 
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
  exit;
} elseif ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
  exit;
}

require_once('../../pegawai/config.php');

if (isset($_GET['id'])) {
  $id = intval($_GET['id']); 

  $query = mysqli_query($connection, "DELETE FROM ketidakhadiran WHERE id = $id");

  if ($query) {
    $_SESSION['berhasil'] = 'Data berhasil dihapus';
  } else {
    $_SESSION['validasi'] = 'Gagal menghapus data';
  }

  header("Location: ketidakhadiran.php");
  exit;

} else {
  echo "ID tidak dikirim.";
  exit;
}
?>
