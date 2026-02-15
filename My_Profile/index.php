<?php
include '../admin/koneksi.php';

// Ambil semua proyek dari database
$projek = mysqli_query($conn, "SELECT * FROM projek ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="shortcut icon" href="gambar/metallica.jpg" type="image/x-icon">

    <style>
        /* BASE STYLES */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f8f9fc;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            text-align: center;
            padding: 60px 20px;
        }

        header h1 {
            margin: 0;
            font-size: 40px;
        }

        header p {
            margin-top: 10px;
            font-size: 18px;
            color: #e0e0e0;
        }

        section {
            padding: 60px 10%;
        }

        /* ABOUT SECTION */
        .about {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; /* Penting untuk responsif */
        }

        .about-text {
            flex: 1;
            padding-right: 30px;
            min-width: 300px; /* Agar tidak terlalu kecil di layar sedang */
        }

        .about-text h2 {
            color: #6a11cb;
        }

        .about img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        /* PROJECTS SECTION */
        .projects {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .project-list {
            display: grid;
            /* Memastikan layout kolom menyesuaikan lebar layar */
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 25px;
            margin-top: 40px;
        }

        .project-item {
            background: #f8f9fc;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .project-item:hover {
            transform: translateY(-5px);
        }

        .project-item img {
            width: 100%;
            border-radius: 10px;
            /* Mengubah height ke auto agar gambar tidak terdistorsi */
            height: auto; 
            object-fit: cover;
        }


        .project-item h3 {
            margin-top: 10px;
            color: #2575fc;
        }

        /* SKILLS & EDUCATION */
        .skills, .education {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            margin-top: 50px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .skills ul, .education ul {
            list-style: none;
            padding: 0;
            display: flex; /* Tambahkan flex untuk layout yang responsif */
            flex-wrap: wrap; /* Memastikan item turun ke baris baru */
            gap: 20px; /* Jarak antar item skill */
        }
        .skills li, .education li {
            margin-bottom: 15px;
            font-size: 16px;
            background: #eaf0ff; /* Background untuk highlight skill */
            padding: 10px 15px;
            border-radius: 8px;
            flex-grow: 1; /* Biarkan item tumbuh mengisi ruang */
            min-width: 250px; /* Batas minimum lebar untuk setiap skill */
        }
        
        /* CONTACT SECTION */
        .contact {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            border-radius: 15px;
            padding: 50px;
        }
        
        .contact form {
            max-width: 500px;
            margin: auto;
        }

        .contact input, .contact textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .contact button {
            width: 100%;
            padding: 12px;
            background: #fff;
            color: #2575fc;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .contact button:hover {
            background: #e0e0e0;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* FOOTER */
        footer {
            background: #111;
            color: #bbb;
            text-align: center;
            padding: 30px 0;
        }

        .socials {
            margin-bottom: 10px;
        }

        .socials a {
            color: #bbb;
            margin: 0 15px;
            font-size: 28px;
            transition: 0.3s;
            text-decoration: none;
        }

        .socials a:hover {
            color: #2575fc;
            transform: scale(1.2);
        }


        @media (max-width: 768px) {
            section {
                /* Kurangi padding horizontal agar lebih banyak ruang konten */
                padding: 40px 5%; 
            }

            header h1 {
                font-size: 32px;
            }

            /* ABOUT SECTION: Ubah menjadi stack vertikal */
            .about {
                flex-direction: column; 
                text-align: center;
            }

            .about img {
                /* Pindahkan gambar ke atas (order: -1) atau biarkan di bawah */
                order: -1; 
                margin-bottom: 30px;
            }

            .about-text {
                padding-right: 0;
            }

            .skills li, .education li {
                /* Biarkan item skill dan pendidikan mengisi 100% lebar di tablet */
                min-width: 100%; 
            }
        }

        /* LAYAR PONSEL (Maksimum Lebar 480px) */
        @media (max-width: 480px) {
            header {
                padding: 40px 10px;
            }

            header h1 {
                font-size: 28px;
            }

            header p {
                font-size: 16px;
            }
            
            /* PROJECT LIST: Pastikan hanya 1 kolom */
            .project-list {
                grid-template-columns: 1fr;
            }

            /* ABOUT SECTION: Kecilkan gambar */
            .about img {
                width: 200px;
                height: 200px;
            }

            .skills, .education, .contact {
                padding: 25px;
            }

            .skills li, .education li {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Roikhan Rijal Firdaus</h1>
        <p>Web Developer | Mahasiswa Teknik Informatika</p>
    </header>

    <section class="about">
        <div class="about-text">
            <h2>Tentang Saya</h2>
            <p>Saya Mahasiswa Teknik Informatika Universitas Pamulang yang memiliki ketertarikan di bidang pengembangan web dan basis data. <br><br>
                Terampil dalam menggunakan PHP, MySQL, JavaScript, HTML, dan CSS. Berpengalaman membuat sistem CRUD, dashboard admin, serta integrasi data menggunakan MySQL. <br><br>
                Saya telah mengerjakan beberapa proyek seperti website profil company yang terhubung ke database MySQL dan sistem manajemen produk berbasis web yang dapat menambah, mengedit, dan menghapus data secara dinamis. <br><br>
                Saya sedang mencari peluang magang atau pekerjaan entry-level di bidang web development agar dapat mengembangkan kemampuan saya dalam pemrograman dan sistem basis data. <br><br>
                Saya dikenal sebagai pribadi yang tekun, cepat belajar, dan mampu bekerja dalam tim maupun secara mandiri.
            </p>
        </div>
        <img src="gambar/roi.png" alt="Foto Saya">
    </section>

    <section class="projects">
        <h2>Proyek Saya</h2>
        <div class="project-list">
            <?php while ($row = mysqli_fetch_assoc($projek)) { ?>
                <div class="project-item">
                    <img src="../admin/uploads/<?php echo htmlspecialchars($row['gambar']); ?>" 
                        alt="<?php echo htmlspecialchars($row['nama']); ?>">
                    <h3><?php echo $row['nama']; ?></h3>
                    <p><?php echo $row['deskripsi']; ?></p>
                    <?php if (!empty($row['link_demo'])) { ?>
                        <a href="<?php echo htmlspecialchars($row['link_demo']); ?>" target="_blank">Lihat Demo</a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="skills">
    <h2>Keahlian Saya</h2>
        <ul>
            <?php
            $skills = mysqli_query($conn, "SELECT * FROM skills ORDER BY id DESC");
            while ($s = mysqli_fetch_assoc($skills)) {
                echo "<li><strong>{$s['nama_skill']}</strong> – {$s['level']}</li>";
            }
            ?>
        </ul>
    </section>

    <section class="education">
        <h2>Riwayat Pendidikan</h2>
        <ul>
            <?php
            $edu = mysqli_query($conn, "SELECT * FROM pendidikan ORDER BY id DESC");
            while ($e = mysqli_fetch_assoc($edu)) {
                echo "<li><strong>{$e['nama_sekolah']}</strong> ({$e['tahun']})<br>{$e['jurusan']}</li>";
            }
            ?>
        </ul>
    </section>

    <footer>
        <div class="socials">
            <a href="https://wa.me/6287735036769" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="https://instagram.com/rrfirdaus20" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com/in/rrfirdaus20" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/roikhan20" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
        </div>
        <p>© 2025 Roikhan Rijal Firdaus. All rights reserved.</p>
    </footer>

</body>
</html>