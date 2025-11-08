<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            background: linear-gradient(135deg, #c3ecf9, #f9c3e3);
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 0;
        }

        .container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 30px 40px;
            max-width: 900px;
            width: 90%;
            margin-bottom: 30px;
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

        /* Kotak khusus peta */
        .map-container {
            background: rgba(173, 216, 230, 0.4);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 20px;
            width: 90%;
            max-width: 900px;
        }

        #map {
            height: 400px;
            border-radius: 15px;
        }

        .map-title {
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📋 Data Kecamatan</h2>

    <?php
    if (isset($_GET['status']) && isset($_GET['message'])) {
        $status = $_GET['status'];
        $message = $_GET['message'];
        $alertClass = $status == 'success' ? 'alert-success' : 'alert-danger';
        echo "<div class='alert $alertClass text-center fade show' role='alert'>$message</div>";
    }

    $conn = new mysqli("localhost", "root", "", "lat8");
    if ($conn->connect_error) {
        die("<div class='alert alert-danger text-center'>Koneksi gagal: " . $conn->connect_error . "</div>");
    }

    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn->query($sql);

    $data = [];
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
                    <th colspan='2'>Aksi</th>
                </tr>
              </thead>
              <tbody>";
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['kecamatan']}</td>
                    <td>{$row['longitude']}</td>
                    <td>{$row['latitude']}</td>
                    <td>{$row['luas']}</td>
                    <td>{$row['jumlah_penduduk']}</td>
                    <td><a href='delete.php?id={$row["id"]}'>hapus</a></td>
                    <td><a href='edit/index.php?id={$row["id"]}'>edit</a></td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div class='alert alert-warning text-center'>Belum ada data kecamatan.</div>";
    }
    $conn->close();
    ?>

    <div class="text-center mt-4">
        <a href="input/index.html" class="btn-custom shadow-sm me-2">➕ Tambah Data Baru</a>
        <a href="leafletjs.php" class="btn-custom shadow-sm">🌍 Lihat Peta Full</a>
    </div>
</div>

<!-- Kotak Peta di luar container -->
<div class="map-container">
    <h4 class="map-title">🗺️ Peta Sebaran Kecamatan Sleman</h4>
    <div id="map"></div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const data = <?php echo json_encode($data); ?>;
    const map = L.map('map').setView([-7.75, 110.35], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    data.forEach(function(item) {
        if (item.latitude && item.longitude) {
            const marker = L.marker([item.latitude, item.longitude]).addTo(map);
            marker.bindPopup(`
                <b>${item.kecamatan}</b><br>
                Luas: ${item.luas} km²<br>
                Penduduk: ${item.jumlah_penduduk}
            `);
        }
    });
</script>

</body>
</html>
