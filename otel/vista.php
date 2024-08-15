<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İskelem Otel Resimleri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0e0e0; /* Arka plan rengini değiştir */
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 50px;
            text-transform: uppercase;
            background: linear-gradient(to right, violet, indigo, blue, green, yellow, orange, red);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
            position: relative;
        }

        .title::after {
            content: '';
            display: block;
            width: 1300px; /* Çizgi genişliği */
            height: 2px; /* Çizgi boyunu buradan ayarlayabilirsiniz */
            background-color: black; /* Siyah bir çizgi */
            position: absolute;
            bottom: -10px;
            left: calc(100% - 1250px); /* Sayfanın tam ortasında çizgiyi yerleştir */
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .image {
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center; /* Resimleri ortala */
        }

        .image img {
            max-width: 120%; /* Resimlerin maksimum genişliği */
            max-height: 100%; /* Resimlerin maksimum yüksekliği */
            height: 250px;
            width: 500px;
            transition: transform 0.3s ease;
        }

        .image:hover img {
            transform: scale(1.1);
        }

        .room-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .room-info {
            margin-bottom: 40px;
        }

        .room-info table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .room-info th,
        .room-info td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .room-info th {
            background-color: #f2f2f2;
        }

        .reservation-form {
            text-align: center;
        }

        .reservation-form select {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }

        .reservation-form button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Geçiş efekti */
        }

        .reservation-form button:hover {
            background-color: green; /* Hover durumunda yeşil yap */
            color: white; /* Metin rengini beyaz yap */
        }

    </style>
</head>
<body>

<div class="container">

    <h1 class="title">VISTA BOUTIQUE HOTEL</h1>

    <?php
    include 'baglanti.php'; // baglanti.php dosyasını include et

    $otel_id = 2;
    $kullanici_id = $_SESSION["id"];
    // Otellerin resimlerini getiren sorgu (otel_id'si 3 olanlar)
    $otel_resim_sql = "SELECT resim_yolu FROM tbl_resim WHERE otel_id = 2";
    $oda_resim_sql = "SELECT resim_yolu FROM tbl_oda_tipi_resim WHERE otel_id = 2";
    $oda_bilgi_sql = "SELECT oda_tipi_isim, oda_tipi_fiyat FROM tbl_oda_tipi_isim_fiyat WHERE otel_id = 2";

    // Otelden resimleri çek
    $otel_resim_result = mysqli_query($baglanti, $otel_resim_sql);
    // Odadan resimleri çek
    $oda_resim_result = mysqli_query($baglanti, $oda_resim_sql);
    // Oda bilgilerini çek
    $oda_bilgi_result = mysqli_query($baglanti, $oda_bilgi_sql);

    if ($otel_resim_result) { 
        // Otel resimleri sorgusu başarılı bir şekilde çalışırsa devam et
        if (mysqli_num_rows($otel_resim_result) > 0) {
            // Otel resimlerini göster
            echo "<h2 class='room-title'>Otel Resimleri</h2>";
            echo "<div class='gallery'>";
            while($otel_row = mysqli_fetch_assoc($otel_resim_result)) {
                echo "<div class='image'>";
                echo "<img src='" . $otel_row['resim_yolu'] . "' alt='Otel Resmi'>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p style='text-align: center;'>Veritabanında otel resmi bulunamadı.</p>";
        }
    } else {
        // Otel resimleri sorgusunda bir hata oluşursa hatayı yazdır
        echo "<p style='text-align: center;'>Otel resimleri sorgusunda bir hata oluştu: " . mysqli_error($baglanti) . "</p>";
    }

    if ($oda_resim_result) { 
        // Oda resimleri sorgusu başarılı bir şekilde çalışırsa devam et
        if (mysqli_num_rows($oda_resim_result) > 0) {
            // Oda resimlerini göster
            echo "<h2 class='room-title'>Oda Tipi Resimleri</h2>";
            echo "<div class='gallery'>";
            while($oda_row = mysqli_fetch_assoc($oda_resim_result)) {
                echo "<div class='image'>";
                echo "<img src='" . $oda_row['resim_yolu'] . "' alt='Oda Resmi'>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p style='text-align: center;'>Veritabanında oda resmi bulunamadı.</p>";
        }
    } else {
        // Oda resimleri sorgusunda bir hata oluşursa hatayı yazdır
        echo "<p style='text-align: center;'>Oda resimleri sorgusunda bir hata oluştu: " . mysqli_error($baglanti) . "</p>";
    }

    // Oda bilgilerini göster
    if ($oda_bilgi_result) {
        if (mysqli_num_rows($oda_bilgi_result) > 0) {
            echo "<div class='room-info'>";
            echo "<h2 class='room-title'>Oda Tipleri ve Fiyatları</h2>";
            echo "<table>";
            echo "<tr><th>Oda Tipi</th><th>Fiyat</th></tr>";
            while ($row = mysqli_fetch_assoc($oda_bilgi_result)) {
                echo "<tr>";
                echo "<td>{$row['oda_tipi_isim']}</td>";
                echo "<td>{$row['oda_tipi_fiyat']} TL</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p style='text-align: center;'>Veritabanında oda bilgisi bulunamadı.</p>";
        }
    } else {
        // Oda bilgisi sorgusunda bir hata oluşursa hatayı yazdır
        echo "<p style='text-align: center;'>Oda bilgisi sorgusunda bir hata oluştu: " . mysqli_error($baglanti) . "</p>";
    }

    // Rezervasyon formunu göster
    echo "<div class='reservation-form'>";
    echo "<form action='' method='post'>"; // Formun action özelliği boş bırakıldı, yani bu sayfaya yönlendirilecek
    echo "<label for='oda'>Oda Tipi Seçin:</label>";
    echo "<select name='oda' id='oda'>";
    mysqli_data_seek($oda_bilgi_result, 0); // Sonuç kümesini başa al
    while ($row = mysqli_fetch_assoc($oda_bilgi_result)) {
        echo "<option value='{$row['oda_tipi_isim']}'>{$row['oda_tipi_isim']}</option>";
    }
    echo "</select>";

    echo "<label for='oda_numarasi'>Oda Numarası Seçin:</label>";
    echo "<select name='oda_numarasi' id='oda_numarasi'>";
    // Oda numaralarını 1'den 100'e kadar göster
    for ($i = 1; $i <= 100; $i++) {
        echo "<option value='{$i}'>{$i}</option>";
    }
    echo "</select>";
    
    if (!isset($_SESSION['giris_yapildi'])) {
        echo "<p>Lütfen önce giriş yapınız.</p>";
        echo "<a href='giris.php'>Giriş yap</a>";
    } else {
        echo "<button type='submit'>Rezervasyon Yap</button>";
    }
    echo "</form>";
    echo "</div>";

    // Formdan gelen verileri alıp işlemek için rezervasyon yapma kodları burada olacak
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formdan gelen verileri al
        $selected_room_type = $_POST['oda'];
        $selected_room_number = $_POST['oda_numarasi'];

        // Rezervasyon tarihi
        $reservation_date = date("Y-m-d"); // Şu anki tarih
        
        // Veritabanına rezervasyonu ekle
        $rezervasyon_ekle_sql = "INSERT INTO tbl_rezervasyonlar (otel_id, kullanici_id, oda_tipi, oda_numarasi, rezervasyon_tarihi) 
                                VALUES ('$otel_id', '$kullanici_id', '$selected_room_type', '$selected_room_number', '$reservation_date')";

        if (mysqli_query($baglanti, $rezervasyon_ekle_sql)) {
            echo "<p style='text-align: center; color: #009900;'>Rezervasyon başarıyla yapıldı.</p>";
        } else {
            echo "<p style='text-align: center;'>Rezervasyon sırasında bir hata oluştu: " . mysqli_error($baglanti) . "</p>";
        }
    }

    // Bağlantıyı kapat
    mysqli_close($baglanti);
?>


</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("form").submit(function(event) {
            // Kullanıcı girişi kontrolü ve yönlendirme
            if (!<?php echo isset($_SESSION['giris_yapildi']) ? 'true' : 'false'; ?>) {
                event.preventDefault(); // Formun gönderilmesini engelle
                window.location.href = "giris.php"; // Giriş sayfasına yönlendir
            }
        });
    });
</script>

</body>
</html>