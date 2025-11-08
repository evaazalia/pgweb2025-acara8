<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data Kecamatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      /* warna disamakan seperti index.php */
      background: linear-gradient(135deg, #c2e9fb, #e0c3fc);
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: 600px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 30px 40px;
      text-align: center;
    }

    h3 {
      font-weight: 700;
      color: #333;
      margin-bottom: 25px;
    }

    label {
      font-weight: 500;
    }

    .btn-save {
      background: linear-gradient(90deg, #ff758c, #ff7eb3);
      color: #fff;
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      width: 100%;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-save:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 120, 150, 0.4);
    }

    a.back-link {
      display: inline-block;
      margin-top: 15px;
      color: #333;
      text-decoration: none;
      transition: 0.2s;
    }

    a.back-link:hover {
      text-decoration: underline;
      color: #ff6699;
    }
  </style>
</head>
<body>
<div class="container">
  <h3>📝 Edit Data Kecamatan</h3>
  
  <?php
  // Koneksi database
  $conn = new mysqli("localhost", "root", "", "lat8");
  if ($conn->connect_error) {
      die("<div class='alert alert-danger'>Koneksi gagal: " . $conn->connect_error . "</div>");
  }

  // Pastikan parameter id dikirim
  if (!isset($_GET['id']) || empty($_GET['id'])) {
      die("<div class='alert alert-danger text-center'>❌ ID tidak ditemukan!</div>");
  }

  $id = intval($_GET['id']);

  // Ambil data berdasarkan ID
  $sql = "SELECT * FROM data_kecamatan WHERE id = $id";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
  } else {
      die("<div class='alert alert-warning text-center'>Data tidak ditemukan!</div>");
  }
  ?>

  <form action="edit.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <div class="mb-3 text-start">
      <label class="form-label">Kecamatan</label>
      <input type="text" class="form-control" name="kecamatan" value="<?php echo $row['kecamatan']; ?>" required>
    </div>

    <div class="mb-3 text-start">
      <label class="form-label">Longitude</label>
      <input type="text" class="form-control" name="longitude" value="<?php echo $row['longitude']; ?>" required>
    </div>

    <div class="mb-3 text-start">
      <label class="form-label">Latitude</label>
      <input type="text" class="form-control" name="latitude" value="<?php echo $row['latitude']; ?>" required>
    </div>

    <div class="mb-3 text-start">
      <label class="form-label">Luas</label>
      <input type="text" class="form-control" name="luas" value="<?php echo $row['luas']; ?>" required>
    </div>

    <div class="mb-3 text-start">
      <label class="form-label">Jumlah Penduduk</label>
      <input type="text" class="form-control" name="jumlah_penduduk" value="<?php echo $row['jumlah_penduduk']; ?>" required>
    </div>

    <button type="submit" class="btn-save mt-3">💾 Simpan Perubahan</button>
  </form>

  <a href="../index.php" class="back-link">⬅️ Kembali ke Daftar</a>
</div>
</body>
</html>
