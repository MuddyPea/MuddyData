<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Ninja";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    $response = array("status" => "error", "message" => "Connection failed: " . $conn->connect_error);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

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
        $response = array("status" => "error", "message" => "Sorry, only PDF, XLSX, CSV, JPG, JPEG, & PNG files are allowed.");
        echo json_encode($response);
        exit;
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO Kamui (judul, kategori, isi, file_path, file_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $judul, $kategori, $isi, $target_file, $file_type);

        if ($stmt->execute()) {
            $response = array("status" => "success", "message" => "Data has been saved successfully.");
        } else {
            $response = array("status" => "error", "message" => "Error: " . $stmt->error);
        }

        $stmt->close();
    } else {
        $response = array("status" => "error", "message" => "Sorry, there was an error uploading your file.");
    }
    echo json_encode($response);
}

$conn->close();
?>