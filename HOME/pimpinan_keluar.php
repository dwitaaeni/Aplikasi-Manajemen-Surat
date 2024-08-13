<?php 
session_start();
include 'koneksi.php';
// Periksa apakah session username telah diatur
if (!isset($_SESSION['pengguna_type'])) {
    echo '<script language="javascript" type="text/javascript">
    alert("Anda Tidak Berhak Masuk Kehalaman Ini!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>Surat - Data Surat Keluar</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style>
    /* Menambahkan gaya untuk warna teks merah */
    .text-red {
      color: red;
    }

    /* Menambahkan gaya untuk warna teks hijau */
    .text-green {
      color: green;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include 'menu.php'; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <!--<?php include 'notifikasi.php'; ?>-->
            <div class="topbar-divider d-none d-sm-block"></div>
            <?php include 'profil.php'; ?>
          </ul>
        </nav>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Surat Keluar</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
              <li class="breadcrumb-item"> Surat Keluar</li>
              <li class="breadcrumb-item active" aria-current="page">Data Surat Keluar</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Data Surat Keluar</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>No.</th>
                        <th>Tgl. Keluar</th>
                        <th>Nomor Agenda</th>
                        <th>No. Surat Keluar</th>
                        <th>Tgl. Surat Keluar</th>
                        <th>Tindakan</th>
                        <th>Berkas</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1;

                      $data = mysqli_query($koneksi, "SELECT * FROM tb_sk WHERE status = '2' ORDER BY id_sk DESC");
                      while ($row = mysqli_fetch_assoc($data)){
                      ?>
                      <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td><?php echo $row['tgl_keluar']; ?></td>
                        <td><?php echo $row['nomor_agenda']; ?></td>
                        <td><?php echo $row['nomor_sk']; ?></td>
                        <td><?php echo $row['tgl_sk']; ?></td>
                        <td>
                          <?php echo $row['tindakan']; ?><br>
                          <?php if ($row['status'] == 2) { ?>
                            <span class="badge badge-warning"><i class="fas fa-check"></i> Mohon Cek Berkas</span>
                          <?php } ?>
                        </td>
                        <td>
                          <a class="btn btn-sm btn-warning" href="" data-toggle="modal" data-target="#fileModal<?php echo $row['id_sk']; ?>"> Lihat File Pdf</a>
                        </td>
                        <td>
                          <a class="btn btn-sm btn-success" href="kirim_berkas.php?id=<?php echo $row['id_sk']; ?>"><i class="fas fa-eye"></i></a><br><br>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->

          <!-- Modal -->
          <?php 
          $sk = mysqli_query($koneksi,"SELECT * FROM tb_sk");
          while ($rk = mysqli_fetch_assoc($sk)){
          ?>
          <div class="modal fade" id="kirimModal<?php echo $rk['id_sk']; ?>">
            <div class="modal-dialog">
              <div class="modal-content">

                <!-- Bagian header modal -->
                <div class="modal-header">
                  <h5 class="modal-title">Data Surat Keluar</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Bagian body modal -->
                <div class="modal-body">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th>Tgl. Surat Keluar</th>
                        <th>:</th>
                        <td><?php echo $rk['tgl_keluar']; ?></td>
                      </tr>
                      <tr>
                        <th>Nomor Agenda</th>
                        <th>:</th>
                        <td><?php echo $rk['nomor_agenda']; ?></td>
                      </tr>
                      <tr>
                        <th>No. Surat Keluar</th>
                        <th>:</th>
                        <td><?php echo $rk['nomor_sk']; ?></td>
                      </tr>
                      <tr>
                        <th>Tanggal Surat</th>
                        <th>:</th>
                        <td><?php echo $rk['tgl_sk']; ?></td>
                      </tr>
                      <tr>
                        <th>Penerima</th>
                        <th>:</th>
                        <td><?php echo $rk['penerima_sk']; ?></td>
                      </tr>
                      <tr>
                        <th>Perihal</th>
                        <th>:</th>
                        <td><?php echo $rk['perihal_sk']; ?></td>
                      </tr>
                      <tr>
                        <th>Lampiran</th>
                        <th>:</th>
                        <td><?php echo $rk['lampiran_sk']; ?></td>
                      </tr>
                      <tr>
                        <th>Status</th>
                        <th>:</th>
                        <td>
                          <?php if ($rk['status'] == 2) { ?>
                            <span class="badge badge-warning"><i class="fas fa-check"></i> Mohon Cek Berkas</span>
                          <?php } ?>
                        </td>
                      </tr>
                      <tr>
                        <th>Tindakan</th>
                        <th>:</th>
                        <td><?php echo $rk['tindakan']; ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php if ($rk['status'] == 2) { ?>
                    <hr>
                    <form method="POST" action="proses_kirim.php" enctype="multipart/form-data">
                      <input type="hidden" name="idsk" value="<?php echo $rk['id_sk']; ?>">
                      <div class="form-group">
                        <label for="">Proses Kirim</label>
                        <select class="form-control" id="kirim_berkas" name="kirim_berkas" onchange="showUploadForm()">
                          <option selected disabled>Pilih Proses Kirim</option>
                          <option value="Cek Kembali">Cek Kembali (ketika surat masih ada kesalahan)</option>
                          <option value="Kirim">Kirim (ketika surat sudah benar)</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <div id="formUpload" style="display: none;">
                          <label for="fileUpload">Upload PDF Kesalahan:</label>
                          <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".pdf, .doc, .docx">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="">Tindakan</label>
                        <select class="form-control" id="tindakan" name="tindakan">
                          <option selected disabled>Pilih Tindakan</option>
                          <option value="KIRIM BERKAS">KIRIM BERKAS</option>
                          <option value="MASIH ADA KESALAHAN">MASIH ADA KESALAHAN</option>
                          <option value="SESUAIKAN DENGAN FORMAT">SESUAIKAN DENGAN FORMAT</option>
                        </select>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submitButton">Kirim Berkas</button>
                      </div>
                    </form>
                  <?php } ?>
                </div>

                <!-- Bagian footer modal -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>

              </div>
            </div>
          </div>
          <?php } ?>

          <!-- Modal File Pdf -->
          <?php 
          $surat = "SELECT * FROM tb_sk";
          $results = mysqli_query($koneksi, $surat);
          while ($rows = mysqli_fetch_assoc($results)){
            $idsk = $rows['id_sk'];
          ?>
          <div class="modal fade" id="fileModal<?php echo $idsk; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">File Surat Keluar</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <center>
                    <?php 
                    $dataf = "SELECT * FROM file_surat_k WHERE sk_id='$idsk'";
                    $result = mysqli_query($koneksi, $dataf);
                    while ($rowf = mysqli_fetch_assoc($result)){
                      $berkas_pdf = $rowf['nama_file'];
                    ?>
                    <iframe src="suratkeluar/<?php echo $berkas_pdf; ?>" style="width: 100%; height: 500px;"></iframe><br>
                    <a href="suratkeluar/<?php echo $berkas_pdf; ?>" class="btn btn-primary" download><i class="fas fa-file-pdf"></i> Unduh PDF</a><br>
                    <hr>
                    <?php } ?>
                  </center>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="keluar.php" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

  <script>
  function showUploadForm() {
    // Mendapatkan nilai terpilih dari dropdown
    var selectedOption = document.getElementById("kirim_berkas").value;

    // Mendapatkan elemen form upload PDF
    var formUpload = document.getElementById("formUpload");

    // Mendapatkan elemen tombol Kirim Berkas
    var submitButton = document.getElementById("submitButton");

    // Menampilkan atau menyembunyikan form upload PDF berdasarkan pilihan yang dipilih
    if (selectedOption === "Cek Kembali") {
      formUpload.style.display = "block";
      submitButton.innerText = "Cek Ulang Berkas";
    } else {
      formUpload.style.display = "none";
      submitButton.innerText = "Kirim Berkas";
    }
  }
</script>

<script>
    // Mendengarkan perubahan pada elemen select
    $('#kirim_berkas').change(function() {
      // Mendapatkan nilai opsi yang dipilih
      var selectedValue = $(this).val();

      // Menghapus kelas warna yang mungkin sudah ada
      $(this).removeClass('text-red text-green');

      // Menambahkan kelas warna sesuai dengan nilai opsi yang dipilih
      if (selectedValue === 'Cek Kembali') {
        $(this).addClass('text-red');
      } else if (selectedValue === 'Kirim') {
        $(this).addClass('text-green');
      }
    });
  </script>

</body>

</html>