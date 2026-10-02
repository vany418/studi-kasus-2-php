<?php
  // ================= PROSES FORM (PHP + METHOD POST) =================
  // isset($_POST['submit']) dipakai supaya bagian "hasil input" hanya
  // muncul SETELAH tombol Submit ditekan, bukan saat halaman pertama kali dibuka.
  $sudah_submit = false;
  $error = [];

  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {

    // Ambil data dari form. htmlspecialchars() dipakai supaya kalau user
    // mengetik tag HTML di form, itu ditampilkan sebagai teks biasa (bukan
    // dieksekusi sebagai HTML) -- praktik dasar keamanan saat menampilkan
    // ulang input pengguna.
    $nama      = htmlspecialchars(trim($_POST["nama"]));
    $email     = htmlspecialchars(trim($_POST["email"]));
    $kelamin   = isset($_POST["kelamin"]) ? htmlspecialchars($_POST["kelamin"]) : "";
    $alamat    = htmlspecialchars(trim($_POST["alamat"]));
    $telepon   = htmlspecialchars(trim($_POST["telepon"]));

    // Validasi sederhana: semua field wajib diisi
    if ($nama === "")    $error[] = "Nama wajib diisi.";
    if ($email === "")   $error[] = "Email wajib diisi.";
    if ($kelamin === "") $error[] = "Jenis kelamin wajib dipilih.";
    if ($alamat === "")  $error[] = "Alamat wajib diisi.";
    if ($telepon === "") $error[] = "Nomor telepon wajib diisi.";

    if (count($error) === 0) {
      $sudah_submit = true;
    }
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Studi Kasus 2 - Form Data Pengguna</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrap">
    <h1>Form Data Pengguna</h1>
    <p class="subjudul">Studi Kasus 2 &mdash; HTML Form diproses dengan PHP menggunakan method POST</p>

    <?php if (count($error) > 0): ?>
      <div class="pesan pesan-error">
        <ul>
          <?php foreach ($error as $pesan): ?>
            <li><?php echo $pesan; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($sudah_submit): ?>
      <!-- ============ HASIL INPUT (tampil setelah submit) ============ -->
      <div class="kartu kartu-hasil">
        <h2>Data Berhasil Dikirim</h2>
        <table>
          <tr><th>Nama</th><td><?php echo $nama; ?></td></tr>
          <tr><th>Email</th><td><?php echo $email; ?></td></tr>
          <tr><th>Jenis Kelamin</th><td><?php echo $kelamin; ?></td></tr>
          <tr><th>Alamat</th><td><?php echo $alamat; ?></td></tr>
          <tr><th>Nomor Telepon</th><td><?php echo $telepon; ?></td></tr>
        </table>
        <a href="index.php" class="btn btn-sekunder">Isi Form Lagi</a>
      </div>
    <?php endif; ?>

    <!-- ============ FORM INPUT ============ -->
    <div class="kartu">
      <form class="form-crud" action="index.php" method="post">

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
               value="<?php echo $sudah_submit ? '' : (isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''); ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="nama@email.com"
               value="<?php echo $sudah_submit ? '' : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''); ?>">

        <label>Jenis Kelamin</label>
        <div class="radio-group">
          <label class="radio-label">
            <input type="radio" name="kelamin" value="Laki-laki"
              <?php echo (!$sudah_submit && isset($_POST['kelamin']) && $_POST['kelamin'] === 'Laki-laki') ? 'checked' : ''; ?>>
            Laki-laki
          </label>
          <label class="radio-label">
            <input type="radio" name="kelamin" value="Perempuan"
              <?php echo (!$sudah_submit && isset($_POST['kelamin']) && $_POST['kelamin'] === 'Perempuan') ? 'checked' : ''; ?>>
            Perempuan
          </label>
        </div>

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap"
               value="<?php echo $sudah_submit ? '' : (isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''); ?>">

        <label for="telepon">Nomor Telepon</label>
        <input type="text" id="telepon" name="telepon" placeholder="08xxxxxxxxxx"
               value="<?php echo $sudah_submit ? '' : (isset($_POST['telepon']) ? htmlspecialchars($_POST['telepon']) : ''); ?>">

        <!-- Hidden field: penanda bahwa form ini yang dikirim (dipakai di PHP: isset($_POST['submit'])) -->
        <input type="hidden" name="form_id" value="data-pengguna">

        <div class="aksi-form">
          <button type="submit" name="submit" class="btn btn-primer">Submit</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>