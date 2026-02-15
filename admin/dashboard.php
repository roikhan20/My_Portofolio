<?php
session_start();

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// CRUD PROYEK
if (isset($_POST['tambah_proyek'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link_demo = mysqli_real_escape_string($conn, $_POST['link_demo']);

    $gambar = "";
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $gambar = basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $gambar);
    }

    $sql = "INSERT INTO projek (nama, deskripsi, gambar, link_demo) VALUES ('$nama', '$deskripsi', '$gambar', '$link_demo')";
    mysqli_query($conn, $sql);
}

if (isset($_GET['hapus_proyek'])) {
    $id = $_GET['hapus_proyek'];
    $res = mysqli_query($conn, "SELECT gambar FROM projek WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if ($row['gambar'] && file_exists("uploads/" . $row['gambar'])) unlink("uploads/" . $row['gambar']);
    mysqli_query($conn, "DELETE FROM projek WHERE id=$id");
}

if (isset($_POST['update_proyek'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $link_demo = $_POST['link_demo'];

    $gambar = $_FILES['gambar']['name'];
    if ($gambar) {
        $target_dir = "uploads/";
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $gambar);
        $sql = "UPDATE projek SET nama='$nama', deskripsi='$deskripsi', link_demo='$link_demo', gambar='$gambar' WHERE id=$id";
    } else {
        $sql = "UPDATE projek SET nama='$nama', deskripsi='$deskripsi', link_demo='$link_demo' WHERE id=$id";
    }
    mysqli_query($conn, $sql);
}

$projek = mysqli_query($conn, "SELECT * FROM projek ORDER BY id DESC");
$edit_projek = isset($_GET['edit_proyek']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM projek WHERE id=".$_GET['edit_proyek'])) : null;

// CRUD PENDIDIKAN
if (isset($_POST['tambah_pendidikan'])) {
    $nama_sekolah = mysqli_real_escape_string($conn, $_POST['nama_sekolah']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    mysqli_query($conn, "INSERT INTO pendidikan (nama_sekolah, jurusan, tahun) VALUES ('$nama_sekolah', '$jurusan', '$tahun')");
}

if (isset($_GET['hapus_pendidikan'])) {
    $id = $_GET['hapus_pendidikan'];
    mysqli_query($conn, "DELETE FROM pendidikan WHERE id=$id");
}

if (isset($_POST['update_pendidikan'])) {
    $id = $_POST['id'];
    $nama_sekolah = $_POST['nama_sekolah'];
    $jurusan = $_POST['jurusan'];
    $tahun = $_POST['tahun'];
    mysqli_query($conn, "UPDATE pendidikan SET nama_sekolah='$nama_sekolah', jurusan='$jurusan', tahun='$tahun' WHERE id=$id");
}

$pendidikan = mysqli_query($conn, "SELECT * FROM pendidikan ORDER BY id DESC");
$edit_pendidikan = isset($_GET['edit_pendidikan']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pendidikan WHERE id=".$_GET['edit_pendidikan'])) : null;

// ========================
// CRUD SKILL
// ========================
if (isset($_POST['tambah_skill'])) {
    $nama_skill = mysqli_real_escape_string($conn, $_POST['nama_skill']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    mysqli_query($conn, "INSERT INTO skills (nama_skill, level) VALUES ('$nama_skill', '$level')");
}

if (isset($_GET['hapus_skill'])) {
    $id = $_GET['hapus_skill'];
    mysqli_query($conn, "DELETE FROM skills WHERE id=$id");
}

if (isset($_POST['update_skill'])) {
    $id = $_POST['id'];
    $nama_skill = $_POST['nama_skill'];
    $level = $_POST['level'];
    mysqli_query($conn, "UPDATE skills SET nama_skill='$nama_skill', level='$level' WHERE id=$id");
}

$skills = mysqli_query($conn, "SELECT * FROM skills ORDER BY id DESC");
$edit_skill = isset($_GET['edit_skill']) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM skills WHERE id=".$_GET['edit_skill'])) : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin</title>
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #333;
    }
    .container {
        width: 90%;
        max-width: 1000px;
        background: #fff;
        margin: 40px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    h1, h2 { 
        text-align: center; 
    }
    form { 
        margin-bottom: 30px; 
    }
    label { 
        display:block; 
        margin:10px 0 5px; 
        font-weight:600; 
    }
    input[type="text"], input[type="url"], textarea {
        width: 100%; 
        padding:10px; 
        border-radius:8px; 
        border:1px solid #ccc;
    }
    button {
        margin-top: 10px;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: white; 
        border: none; 
        padding:10px 20px; 
        border-radius:8px; 
        cursor:pointer;
    }
    button:hover { 
        opacity: 0.9; 
        transform: scale(1.03); 
    }
    table { width:100%; 
        border-collapse: collapse; 
        margin-top:10px; 
    }
    th, td { 
        border-bottom:1px solid #ddd; 
        padding:8px; 
    }
    th { 
        background:#f4f4f4; 
    }
    img { 
        width:80px; 
        border-radius:8px; 
    }
    .section { 
        margin-top:60px; 
    }
    .logout {
        float:right; 
        background:#e74c3c; 
        color:white; 
        padding:8px 15px;
        border-radius:8px; 
        text-decoration:none;
    }
</style>
</head>
<body>
<div class="container">
    <a href="logout.php" class="logout">Logout</a>
    <h1>Dashboard Admin</h1>

    <div class="section">
        <h2>Manajemen Proyek</h2>
        <form method="post" enctype="multipart/form-data">
            <?php if ($edit_projek): ?>
                <input type="hidden" name="id" value="<?= $edit_projek['id'] ?>">
            <?php endif; ?>
            <label>Nama Proyek</label>
            <input type="text" name="nama" value="<?= $edit_projek['nama'] ?? '' ?>" required>
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" required><?= $edit_projek['deskripsi'] ?? '' ?></textarea>
            <label>Upload Gambar</label>
            <input type="file" name="gambar">
            <label>Link Demo</label>
            <input type="url" name="link_demo" value="<?= $edit_projek['link_demo'] ?? '' ?>">
            <button name="<?= $edit_projek ? 'update_proyek' : 'tambah_proyek' ?>">
                <?= $edit_projek ? 'Update Proyek' : 'Tambah Proyek' ?>
            </button>
        </form>

        <table>
            <tr><th>ID</th><th>Nama</th><th>Deskripsi</th><th>Gambar</th><th>Link Demo</th><th>Aksi</th></tr>
            <?php while ($p = mysqli_fetch_assoc($projek)) : ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nama'] ?></td>
                <td><?= $p['deskripsi'] ?></td>
                <td><?= $p['gambar'] ? "<img src='uploads/{$p['gambar']}'>" : '-' ?></td>
                <td><?= $p['link_demo'] ? "<a href='{$p['link_demo']}' target='_blank'>Lihat</a>" : '-' ?></td>
                <td>
                    <a href="?edit_proyek=<?= $p['id'] ?>">Edit</a> |
                    <a href="?hapus_proyek=<?= $p['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>Riwayat Pendidikan</h2>
        <form method="post">
            <?php if ($edit_pendidikan): ?>
                <input type="hidden" name="id" value="<?= $edit_pendidikan['id'] ?>">
            <?php endif; ?>
            <label>Nama Sekolah</label>
            <input type="text" name="nama_sekolah" value="<?= $edit_pendidikan['nama_sekolah'] ?? '' ?>" required>
            <label>Jurusan</label>
            <input type="text" name="jurusan" value="<?= $edit_pendidikan['jurusan'] ?? '' ?>">
            <label>Tahun</label>
            <input type="text" name="tahun" value="<?= $edit_pendidikan['tahun'] ?? '' ?>">
            <button name="<?= $edit_pendidikan ? 'update_pendidikan' : 'tambah_pendidikan' ?>">
                <?= $edit_pendidikan ? 'Update Pendidikan' : 'Tambah Pendidikan' ?>
            </button>
        </form>

        <table>
            <tr><th>ID</th><th>Nama Sekolah</th><th>Jurusan</th><th>Tahun</th><th>Aksi</th></tr>
            <?php while ($edu = mysqli_fetch_assoc($pendidikan)) : ?>
            <tr>
                <td><?= $edu['id'] ?></td>
                <td><?= $edu['nama_sekolah'] ?></td>
                <td><?= $edu['jurusan'] ?></td>
                <td><?= $edu['tahun'] ?></td>
                <td>
                    <a href="?edit_pendidikan=<?= $edu['id'] ?>">Edit</a> |
                    <a href="?hapus_pendidikan=<?= $edu['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>Keahlian / Skills</h2>
        <form method="post">
            <?php if ($edit_skill): ?>
                <input type="hidden" name="id" value="<?= $edit_skill['id'] ?>">
            <?php endif; ?>
            <label>Nama Skill</label>
            <input type="text" name="nama_skill" value="<?= $edit_skill['nama_skill'] ?? '' ?>" required>
            <label>Tingkat Keahlian</label>
            <input type="text" name="level" value="<?= $edit_skill['level'] ?? '' ?>" placeholder="Contoh: Pemula, Menengah, Ahli">
            <button name="<?= $edit_skill ? 'update_skill' : 'tambah_skill' ?>">
                <?= $edit_skill ? 'Update Skill' : 'Tambah Skill' ?>
            </button>
        </form>

        <table>
            <tr><th>ID</th><th>Nama Skill</th><th>Level</th><th>Aksi</th></tr>
            <?php while ($s = mysqli_fetch_assoc($skills)) : ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= $s['nama_skill'] ?></td>
                <td><?= $s['level'] ?></td>
                <td>
                    <a href="?edit_skill=<?= $s['id'] ?>">Edit</a> |
                    <a href="?hapus_skill=<?= $s['id'] ?>" onclick="return confirm('Hapus skill ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
