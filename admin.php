<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Ninja";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dapatkan kategori yang dipilih dari parameter GET
$selected_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Buat query SQL dengan kondisi kategori
$sql = "SELECT id, judul, kategori, isi, file_path FROM Kamui";
if ($selected_kategori != '') {
    $sql .= " WHERE kategori = ?";
}

// Siapkan statement
$stmt = $conn->prepare($sql);
if ($selected_kategori != '') {
    $stmt->bind_param("s", $selected_kategori);
}

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .table thead {
            background-color: #002366;
            color: white;
        }

        .btn-primary {
            background-color: #002366;
            border-color: #002366;
        }

        .btn-primary:hover {
            background-color: #001d4c;
            border-color: #001d4c;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-group-xs>.btn {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">DATASET KOMINFO</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="halaman_input.php">Tambah Data Baru</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h2 class="text-center">Data yang Tersedia</h2>
        <div class="form-group">
            <label for="kategori" class="mr-2">Sortir Berdasarkan Kategori: </label>
            <select name="kategori" id="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                <option value="Teknologi" <?php echo $selected_kategori == 'Teknologi' ? 'selected' : ''; ?>>Teknologi
                </option>
                <option value="Sosial" <?php echo $selected_kategori == 'Sosial' ? 'selected' : ''; ?>>Sosial</option>
                <option value="Pertanian" <?php echo $selected_kategori == 'Pertanian' ? 'selected' : ''; ?>>Pertanian
                </option>
                <option value="Peternakan" <?php echo $selected_kategori == 'Peternakan' ? 'selected' : ''; ?>>Peternakan
                </option>
                <option value="Kesehatan" <?php echo $selected_kategori == 'Kesehatan' ? 'selected' : ''; ?>>Kesehatan
                </option>
                <option value="Pendidikan" <?php echo $selected_kategori == 'Pendidikan' ? 'selected' : ''; ?>>Pendidikan
                </option>
            </select>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Isi</th>
                    <th>File</th>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                        <th>Aksi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody id="data-table">
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $file_name = basename($row["file_path"]);
                        ?>
                        <tr>
                            <td><?php echo $row["judul"]; ?></td>
                            <td><?php echo $row["kategori"]; ?></td>
                            <td><?php echo $row["isi"]; ?></td>
                            <td><a href="<?php echo $row["file_path"]; ?>" target="_blank"><?php echo $file_name; ?></a></td>
                            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                                <td>
                                    <div class="btn-group btn-group-xs" role="group">
                                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Ubah</a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5" class="text-center">No records found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kategori').on('change', function () {
                var selectedCategory = $(this).val();
                window.location.href = 'admin.php?kategori=' + selectedCategory;
            });
        });
    </script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>