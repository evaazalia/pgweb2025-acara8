<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peta Data Kecamatan</title>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #c3ecf9, #f9c3e3);
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    h2 {
      color: #333;
      margin-bottom: 10px;
    }

    #map {
      height: 500px;
      width: 90%;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      margin-top: 20px;
    }
    
    a.btn-back {
      display: inline-block;
      margin-top: 20px;
      background: linear-gradient(90deg, #ff7eb3, #ff758c);
      color: white;
      padding: 10px 25px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    a.btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255,118,136,0.4);
    }
  </style>
</head>
<body>

  <h2>🗺️ Peta Data Kecamatan</h2>
  <div id="map"></div>
  <a href="index.php" class="btn-back">← Kembali ke Data</a>

  <?php
  // === KONEKSI DB ===
  $conn = new mysqli("localhost", "root", "", "lat8");
  if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
  }

  $sql = "SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk FROM data_kecamatan";
  $result = $conn->query($sql);

  $data = [];
  while ($row = $result->fetch_assoc()) {
      $data[] = $row;
  }
  $conn->close();
  ?>

  <script>
    const dataKecamatan = <?php echo json_encode($data); ?>;
    console.log(dataKecamatan);

    // Buat peta
    const map = L.map('map').setView([-7.77, 110.37], 11);

    // Tambahkan base map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
    }).addTo(map);

    // Tambahkan marker
    if (dataKecamatan.length === 0) {
      alert("Tidak ada data koordinat di database!");
    }

    dataKecamatan.forEach(item => {
      if (item.latitude && item.longitude) {
        L.marker([item.latitude, item.longitude])
          .addTo(map)
          .bindPopup(`<b>${item.kecamatan}</b><br>Luas: ${item.luas} km²<br>Penduduk: ${item.jumlah_penduduk}`);
      }
    });
  </script>

</body>
</html>
