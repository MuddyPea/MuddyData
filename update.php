<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

// Periksa apakah ID sudah diset di parameter GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data berdasarkan ID
    $stmt = $conn->prepare("SELECT judul, kategori, isi, file_path FROM Kamui WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Periksa apakah form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $judul = $_POST['judul'];
        $kategori = $_POST['kategori'];
        $isi = $_POST['isi'];

        // Periksa apakah ada file yang diunggah
        if (!empty($_FILES['file']['name'])) {
            $target_dir = "uploads/";
            // Periksa apakah folder 'uploads' ada, jika tidak, buat folder tersebut
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validasi tipe file
            $allowed_types = array("pdf", "xlsx", "csv", "jpg", "jpeg", "png");
            if (!in_array($file_type, $allowed_types)) {
                die("Sorry, only PDF, XLSX, CSV, JPG, JPEG, & PNG files are allowed.");
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $stmt = $conn->prepare("UPDATE Kamui SET judul = ?, kategori = ?, isi = ?, file_path = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $judul, $kategori, $isi, $target_file, $id);
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        } else {
            $stmt = $conn->prepare("UPDATE Kamui SET judul = ?, kategori = ?, isi = ? WHERE id = ?");
            $stmt->bind_param("sssi", $judul, $kategori, $isi, $id);
        }

        // Eksekusi query
        if ($stmt->execute()) {
            header("Location: admin.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "Invalid request.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
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
        <a class="navbar-brand" href="#">Admin Update Data</a>
        <div class="ml-auto">
            <a href="admin.php" class="btn btn-secondary">Kembali ke halaman admin</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Update Data</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $data['judul']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="Teknologi" <?php echo $data['kategori'] == 'Teknologi' ? 'selected' : ''; ?>>Teknologi
                    </option>
                    <option value="Sosial" <?php echo $data['kategori'] == 'Sosial' ? 'selected' : ''; ?>>Sosial</option>
                    <option value="Pertanian" <?php echo $data['kategori'] == 'Pertanian' ? 'selected' : ''; ?>>Pertanian
                    </option>
                    <option value="Peternakan" <?php echo $data['kategori'] == 'Peternakan' ? 'selected' : ''; ?>>
                        Peternakan</option>
                    <option value="Kesehatan" <?php echo $data['kategori'] == 'Kesehatan' ? 'selected' : ''; ?>>Kesehatan
                    </option>
                    <option value="Pendidikan" <?php echo $data['kategori'] == 'Pendidikan' ? 'selected' : ''; ?>>
                        Pendidikan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="isi">Isi</label>
                <textarea class="form-control" id="isi" name="isi" rows="4"
                    required><?php echo $data['isi']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="file">File (Optional)</label>
                <div class="custom-file">
                    <input type="file" name="file" id="file" class="custom-file-input">
                    <label class="custom-file-label" for="file">Choose file</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Update the label of the custom file input with the selected file name
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>

</html>