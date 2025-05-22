<style>
    .footer-fixed {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: #fff;
      text-align: center;
      padding: 10px;
      z-index: 1000;
    }
  </style>
<footer class="pc-footer">
    <div class="footer-fixed text-center">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0"
            >Copyright (C) 2025 <a href="https://themeforest.net/user/codedthemes" target="_blank">PT. Mega Production Corp |</a> All Rights Reserved <a href="https://themewagon.com/">AA</a>.</p
          >
        </div>
      </div>
    </div>
  </footer>

  <!-- [Page Specific JS] start -->
  <script src="<?= base_url ('assets/assets/js/plugins/apexcharts.min.js') ?>"></script>
  <script src="<?= base_url ('assets/assets/js/pages/dashboard-default.js') ?>"></script>
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="<?= base_url('assets/assets/js/plugins/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/plugins/simplebar.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/plugins/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/fonts/custom-font.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/pcoded.js') ?>"></script>
  <script src="<?= base_url('assets/assets/js/plugins/feather.min.js') ?>"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <!-- sweet alert START -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <?php if (isset($_SESSION['berhasil'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '<?= $_SESSION["berhasil"]; ?>',
        showConfirmButton: false,
        timer: 2000
    });
</script>
<?php unset($_SESSION['berhasil']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['gagal'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '<?= $_SESSION["gagal"]; ?>',
        showConfirmButton: false,
        timer: 2000
    });
</script>
<?php unset($_SESSION['gagal']); ?>
<?php endif; ?>

<!-- alert validasi -->
   <?php if(isset($_SESSION['validasi'])) : ?>

<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "error",
    title: "<?= $_SESSION['validasi'] ?>"
    });
</script>

<?php unset($_SESSION['validasi']); ?>

<?php endif; ?>

<!-- alert konfirmasi hapus -->
 <script>
  $('.tombol-hapus').on('click', function(){
    var getLink = $(this).attr('href');
    Swal.fire({
  title: "Yakin hapus?",
  text: "Data yang sudah di hapus tidak dapat dikembalikan",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Iya, Hapus!"
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = getLink
  }
})
return false;
  });
 </script>

  <!-- sweet alert END-->
  
  
  <script
    src="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/js/tabler.min.js">
  </script>
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
    

</body>
<!-- [Body] end -->

</html>