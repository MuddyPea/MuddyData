<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

// Fungsi untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  session_destroy();
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Input Data</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.min.css">
  <style>
    body {
      background-color: #f4f4f9;
      font-family: Arial, sans-serif;
    }

    .navbar {
      background-color: #002366;
      color: white;
    }

    .navbar-brand,
    .navbar-nav .nav-link {
      color: white !important;
    }

    .container {
      margin-top: 30px;
    }

    .btn-primary {
      background-color: #002366;
      border-color: #002366;
    }

    .btn-primary:hover {
      background-color: #001d4c;
      border-color: #001d4c;
    }

    .custom-file-input~.custom-file-label::after {
      content: "Browse";
      background-color: #002366;
      border: none;
      padding: 0.5rem 1rem;
      color: white;
      border-radius: 0 0.25rem 0.25rem 0;
    }

    .custom-file-input:focus~.custom-file-label {
      border-color: #002366;
      box-shadow: 0 0 0 0.2rem rgba(0, 35, 102, 0.25);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Admin Input Data</a>
    <div class="ml-auto">
      <a href="halaman_input.php?action=logout" class="btn btn-danger">Logout</a>
    </div>
  </nav>
  <div class="container mt-5">
    <h2>Halaman Admin Input Data</h2>
    <a href="admin.php" class="btn btn-secondary mb-3">Kembali ke halaman admin</a>
    <form id="uploadForm" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="kategori">Kategori</label>
        <select name="kategori" id="kategori" class="form-control" required>
          <option value="Teknologi">Teknologi</option>
          <option value="Sosial">Sosial</option>
          <option value="Pertanian">Pertanian</option>
          <option value="Peternakan">Peternakan</option>
          <option value="Kesehatan">Kesehatan</option>
          <option value="Pendidikan">Pendidikan</option>
        </select>
      </div>
      <div class="form-group">
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" class="form-control" rows="5" required></textarea>
      </div>
      <div class="form-group">
        <label for="file">Unggah File</label>
        <div class="custom-file">
          <input type="file" name="file" id="file" class="custom-file-input" required>
          <label class="custom-file-label" for="file">Choose file</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Simpan Data</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function () {
      $('#uploadForm').on('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
          url: 'upload.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            var jsonResponse = JSON.parse(response);
            Swal.fire({
              title: jsonResponse.status === "success" ? 'Berhasil!' : 'Gagal!',
              text: jsonResponse.message,
              icon: jsonResponse.status === "success" ? 'success' : 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#002366',
              background: '#f4f4f9'
            }).then((result) => {
              if (jsonResponse.status === "success") {
                $('#uploadForm')[0].reset();
                $(".custom-file-label").html("Choose file");
              }
            });
          },
          error: function () {
            Swal.fire({
              title: 'Gagal!',
              text: 'Terjadi kesalahan saat mengunggah file.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#002366',
              background: '#f4f4f9'
            });
          }
        });
      });

      // Update the label of the custom file input with the selected file name
      $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    });
  </script>
</body>

</html>