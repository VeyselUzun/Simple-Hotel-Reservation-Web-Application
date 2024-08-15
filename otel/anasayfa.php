<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otel Rezervasyon Sitesi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eaeaea; /* Light Grey */
        }
        header {
            background-color: #333; /* Koyu Gri */
            color: #fff;
            padding: 20px 0;
        }
        .container {
    width: 80%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav ul {
    list-style-type: none;
    padding: 0;
    margin-bottom: 40px;
    display: flex;
}

nav ul li {
    margin-right: 30px;
}

nav ul li:last-child {
    margin-right: 0;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 20px;
    transition: color 0.3s;
    position: relative;
}

/* Bölme işaretini stilize et */
nav ul li a::after {
    /*content: '';*/
    position: absolute;
    width: 2px;
    height: 10px;
    background-color: #fff;
    top: 50%;
    right: -10px;
    transform: translateY(-50%);
}

/* Son linkte bölme işaretini gizle */
nav ul li:last-child a::after {
    display: none;
}

nav ul li a:hover {
    color: #ff9800; /* Turuncu */
}



        main {
            padding: 20px;
            text-align: center;
        }
        .hotel-section {
            margin-bottom: 40px;
            text-align: left;
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .hotel-section:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .hotel-section .hotel-images {
            margin-right: 20px;
        }
        .hotel-section .hotel-images img {
            width: 250px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 0 0 10px;
        }
        .hotel-section .hotel-info {
            flex: 1;
            padding: 20px;
            font-size: 17px; /* Yeni eklenen satır */
        }
        .hotel-section h2 {
            color: #333; /* Dark Grey */
            margin-bottom: 10px;
        }
        .hotel-section p {
            color: #666; /* Medium Grey */
            margin-bottom: 20px;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 5%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Transparent Black */
            padding: 10px 0;
            color: #fff;
            text-align: center;
        }
        .user-actions {
            float: right;
            margin-top: -44px;
            margin-right: 30px;
        }

        .user-actions button {
            font-size: 18px;
            background-color: #2196f3;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .user-actions button:hover {
            background-color: #f57c00;
        }

        .welcome-message {
            font-size: 24px; /* Yazının fontunu büyüt */
            animation: rainbow 5s infinite; /* Animasyonlu geçiş */
            margin-right: 350px;
        }

        @keyframes rainbow {
            0% { color: #ff5722; } /* Kırmızı */
            25% { color: #e91e63; } /* Pembe */
            50% { color: #9c27b0; } /* Mor */
            75% { color: #2196f3; } /* Mavi */
            100% { color: #4caf50; } /* Yeşil */
        }

        .user-actions button[type="submit"] {
            font-size: 18px;
            background-color: #f44336; /* Kırmızı */
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .user-actions button[type="submit"]:hover {
            background-color: #d32f2f; /* Koyu kırmızı */
        }


    </style>
</head>
<body>
    <header>
    <div class="container">
        <h1>Otel Rezervasyonu</h1>
        <nav>
            <ul>
                <li><a href="iskelem.php">İskelem Otel</a></li>
                <li><a href="marmara.php">The Marmara Otel</a></li>
                <li><a href="double.php">Double/Tree By Hilton</a></li>
                <li><a href="vista.php">Vista Boutique</a></li>
                <li><a href="royal.php">Royal Teos</a></li>
                <li><a href="rezervasyonlarım.php">Rezervasyonlarım</a></li>
            </ul>
        </nav>
    </div>
    </header>

    <?php
            // Örnek olarak, kullanıcı giriş yaptıysa ve ad-soyad bilgileri bulunuyorsa
            $user_fullname = ""; // Kullanıcının ad ve soyadını bu değişkene atayacağız
            if(isset($_SESSION["ad"]) && isset($_SESSION["soyad"])) {
                $ad = ucfirst(strtolower($_SESSION["ad"])); // İlk harfi büyük yapmak için ucfirst kullanıyoruz
                $soyad = ucfirst(strtolower($_SESSION["soyad"])); // İlk harfi büyük yapmak için ucfirst kullanıyoruz
                $user_fullname = $ad . ' ' . $soyad;
            }
        ?>

<div class="user-actions">
    <?php if (!empty($user_fullname)) { ?>
        <div>
            <span class="welcome-message">Hoş geldiniz, <?php echo $user_fullname; ?>!</span>
            <form id="logout-form" method="post" action="logout.php" style="display: inline;">
                <button type="submit">Çıkış Yap</button>
            </form>
        </div>
    <?php } else { ?>
        <!-- jQuery kütüphanesi -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- jQuery ile JavaScript kodları -->
        <script>
            $(document).ready(function() {
                // Giriş Yap butonuna tıklama işlemi
                $("#login-btn").click(function() {
                    window.location.href = "giris.php";
                });

                // Kayıt Ol butonuna tıklama işlemi
                $("#register-btn").click(function() {
                    window.location.href = "kayit.php";
                });

            });
        </script>
        <button id="login-btn" onclick="window.location.href='giris.php'">Giriş Yap</button>
        <button id="register-btn" onclick="window.location.href='kayit.php'">Kayıt Ol</button>
    <?php } ?>
</div>


    <main>
    <?php
include 'baglanti.php'; // baglanti.php dosyasını include et

// Otellerin açıklamalarını, isimlerini, resimlerini ve adreslerini getiren sorgu
$sql = "SELECT b.otel_aciklama, b.otel_adres, i.otel_ismi, r.resim_yolu
        FROM tbl_otel_bilgi b
        INNER JOIN tbl_otel_resim r ON b.otel_id = r.otel_id
        INNER JOIN tbl_otel_isim i ON b.otel_id = i.otel_id";

$result = mysqli_query($baglanti, $sql); // Bağlantıyı kullanarak sorguyu çalıştır

if ($result) { // Sorgu başarılı bir şekilde çalışırsa devam et
    if (mysqli_num_rows($result) > 0) {
        // Verileri döngü ile al
        while($row = mysqli_fetch_assoc($result)) {
            // Her otel için bir HTML section oluştur
            echo "<section class='hotel-section'>";
            echo "<div class='hotel-images'>";
            echo "<img src='" . $row['resim_yolu'] . "' alt='Otel Resmi'>";
            echo "</div>";
            echo "<div class='hotel-info'>";
            echo "<h2>" . $row['otel_ismi'] . "</h2>"; // Otel ismini ekrana yazdır
            echo "<p>" . $row['otel_aciklama'] . "</p>"; // Otel açıklamasını ekrana yazdır
            echo "<p>Adres: " . $row['otel_adres'] . "</p>"; // Otel adresini ekrana yazdır
            echo "</div>";
            echo "</section>";
        }
    } else {
        echo "Veritabanında otel açıklaması bulunamadı.";
    }
} else {
    // Sorguda bir hata oluşursa hatayı yazdır
    echo "Sorguda bir hata oluştu: " . mysqli_error($baglanti);
}

// Bağlantıyı kapat
mysqli_close($baglanti);
?>
    </main>
</html>
