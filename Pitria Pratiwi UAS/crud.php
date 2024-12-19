<?php
// Start session untuk menyimpan data sementara
session_start();

// Inisialisasi data inventaris jika belum ada
if (!isset($_SESSION['datakaryawan'])) {
    $_SESSION['datakaryawan'] = [
        ['kode' => 'INV-2022-005', 'nama' => 'Pia', 'alamat' => 'Palembang', 'jenis_kelamin' => 'Wanita', 'tanggal' => '2022-06-01'],
        ['kode' => 'INV-2022-004', 'nama' => 'Mona"', 'alamat' => 'Riau', 'jenis_kelamin' => 'Wanita ', 'tanggal' => '2022-06-02'],
        ['kode' => 'INV-2022-003', 'nama' => 'Lara ', 'alamat' => 'Jambi', 'jenis_kelamin' => 'Wanita', 'tanggal' => '2022-06-09'],
        ['kode' => 'INV-2022-002', 'nama' => 'Kusumo ', 'alamat' => 'Medan', 'jenis_kelamin' => 'Peria', 'tanggal' => '2022-06-08'],
        ['kode' => 'INV-2022-001', 'nama' => 'Miko ', 'alamat' => 'Jambi', 'jenis_kelamin' => 'Peria', 'tanggal' => '2022-06-01']
    ];
}

// Tambah/Edit Data
if (isset($_POST['simpan'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $emaill = $_POST['email'];

    // Edit data jika sudah ada
    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $_SESSION['datakaryawan'][$_POST['id']] = ['nik' => $nik, 'nama' => $nama, 'alamat' => $alamat, 'jenis_kelamin' => $jumlah, 'tanggal' => $tanggal];
    } else { 
        // Tambah data baru
        $_SESSION['datakaryawan'][] = ['kode' => $nik, 'nama' => $nama, 'asal' => $alamat, 'jenis_kelamin' => $jumlah, 'tanggal' => $tanggal];
    }
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($_SESSION['dataKaryawan'][$id]);
    $_SESSION['dataKaryawan'] = array_values($_SESSION['dataKaryawan']); // Reindex array
}

// Pencarian Data
$search = isset($_GET['cari']) ? strtolower($_GET['cari']) : '';
$dataKaryawan = $_SESSION['dataKaryawan'];
if ($search !== '') {
    $dataBarang = array_filter($dataKaryawan, function($item) use ($search) {
        return strpos(strtolower($item['nama']), $search) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Inventaris</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ddd; text-align: center; }
        th, td { padding: 10px; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 4px; }
        .btn-edit { background-color: #f1c40f; }
        .btn-hapus { background-color: #e74c3c; }
        .btn-cari { background-color: #007bff; color: white; }
        input, button { padding: 5px; }
        form { margin: 10px 0; }
    </style>
</head>
<body>


    <h2>Data Karyawan</h2>

    <!-- Form Pencarian -->
    <form method="GET">
        <input type="text" name="cari" placeholder="Masukkan kata kunci..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-cari">Cari</button>
        <a href="?"><button type="button" class="btn btn-hapus">Reset</button></a>
    </form>

    <!-- Form Tambah/Edit Data -->
    <h3>Form Tambah/Edit Data</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
        <input type="text" name="nik" placeholder="Nik karyawaan" required>
        <input type="text" name="nama" placeholder="Nama Karyawan" required>
        <input type="text" name="alamat" placeholder="Alamat Karyawan" required>
        <input type="text" name="jenis_kelamin" placeholder="Jenis_Karyawan" required>
        <input type="date" name="tanggal" required>
        <button type="submit" name="simpan" class="btn btn-cari">Simpan</button>
    </form>

    <!-- Tabel Data -->
    <table>
        <tr>
            <th>No.</th>
            <th>Nama Karyawan</th>
            <th>Nik Karyawan</th>
            <th>Asal Karyawan</th>
            <th>Email</th>
            <th>Tanggal Diterima</th>
            <th>Aksi</th>
        </tr>
        <?php if (count($dataKaryawan) > 0): ?>
            <?php foreach ($dataKaryawan as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($item['kode']); ?></td>
                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                    <td><?php echo htmlspecialchars($item['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($item['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($item['email']); ?></td>
                    <td>
                        <a href="inputdata.php"?edit=<?php echo $index; ?>" class="btn btn-edit">Edit</a>
                        <a href="?hapus=<?php echo $index; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-hapus">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data ditemukan.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>