<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #c3ecf9, #f9c3e3);
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px 0;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 30px 40px;
            max-width: 900px;
            width: 90%;
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            color: #444;
        }

        table {
            border-radius: 10px;
            overflow: hidden;
        }

        .btn-custom {
            background: linear-gradient(90deg, #ff7eb3, #ff758c);
            border: none;
            width: auto;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 30px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #ff758c, #ff7eb3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 118, 136, 0.4);
        }

        .alert {
            border-radius: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📋 Data Kecamatan</h2>

    <?php
    // Tampilkan pesan hasil input
    if (isset($_GET['status']) && isset($_GET['message'])) {
        $status = $_GET['status'];
        $message = $_GET['message'];
        $alertClass = $status == 'success' ? 'alert-success' : 'alert-danger';
        echo "<div class='alert $alertClass text-center fade show' role='alert'>$message</div>";
    }

    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lat8";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("<div class='alert alert-danger text-center'>Koneksi gagal: " . $conn->connect_error . "</div>");
    }

    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover text-center align-middle'>";
        echo "<thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nama Kecamatan</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Luas</th>
                    <th>Jumlah Penduduk</th>
                </tr>
              </thead>
              <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['kecamatan']}</td>
                    <td>{$row['longitude']}</td>
                    <td>{$row['latitude']}</td>
                    <td>{$row['luas']}</td>
                    <td>{$row['jumlah_penduduk']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div class='alert alert-warning text-center'>Belum ada data kecamatan.</div>";
    }

    $conn->close();
    ?>

    <!-- Tombol Tambah Data -->
    <div class="text-center mt-4">
        <a href="input/index.html" class="btn-custom shadow-sm">➕ Tambah Data Baru</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script untuk fade-out alert otomatis -->
<script>
    const alert = document.querySelector('.alert');
    if (alert) {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }, 3000); // hilang setelah 3 detik
    }
</script>

</body>
</html>
