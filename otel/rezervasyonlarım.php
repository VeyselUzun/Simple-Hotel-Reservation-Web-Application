<?php
include 'baglanti.php';
session_start();

$kullanici_id = $_SESSION["id"];
// Kullanıcının yaptığı rezervasyonları çekmek için sorgu
$rezervasyonlar_sql = "SELECT r.rezervasyon_id, i.otel_ismi, r.oda_tipi, r.oda_numarasi, r.rezervasyon_tarihi
                       FROM tbl_rezervasyonlar r
                       INNER JOIN tbl_otel_isim i ON r.otel_id = i.otel_id
                       WHERE r.kullanici_id = $kullanici_id";

// Rezervasyonları getir
$rezervasyonlar_result = mysqli_query($baglanti, $rezervasyonlar_sql);

// Rezervasyonu iptal etmek için form gönderildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_reservation'])) {
    $rezervasyon_id = $_POST['rezervasyon_id'];
    
    // Rezervasyonu veritabanından sil
    $silme_sorgusu = "DELETE FROM tbl_rezervasyonlar WHERE rezervasyon_id = $rezervasyon_id";
    if (mysqli_query($baglanti, $silme_sorgusu)) {
        // Başarıyla silindiğine dair mesaj göster
        echo "<script>alert('Rezervasyon başarıyla iptal edildi.');</script>";
        // Sayfayı yenile
        echo "<script>window.location.href = 'anasayfa.php';</script>";
    } else {
        // Silinemediğine dair hata mesajı göster
        echo "<script>alert('Rezervasyon iptal edilemedi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyonlarım</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-reservations {
            text-align: center;
            margin-top: 20px;
        }

        .cancel-form {
            display: inline-block;
        }

        .cancel-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rezervasyonlarım</h2>
        <?php if ($rezervasyonlar_result && mysqli_num_rows($rezervasyonlar_result) > 0): ?>
            <table>
                <tr>
                    <th>Otel İsmi</th> <!-- Otel ismi sütunu -->
                    <th>Oda Tipi</th>
                    <th>Oda Numarası</th>
                    <th>Rezervasyon Tarihi</th>
                    <th></th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($rezervasyonlar_result)): ?>
                    <tr>
                        <td><?php echo $row['otel_ismi']; ?></td> <!-- Otel ismi sütunu -->
                        <td><?php echo $row['oda_tipi']; ?></td>
                        <td><?php echo $row['oda_numarasi']; ?></td>
                        <td><?php echo $row['rezervasyon_tarihi']; ?></td>
                        <td>
                            <form class="cancel-form" action="" method="post">
                                <input type="hidden" name="rezervasyon_id" value="<?php echo $row['rezervasyon_id']; ?>">
                                <button class="cancel-button" type="submit" name="cancel_reservation">İptal Et</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-reservations">Henüz rezervasyon yapmamışsınız.</p>
        <?php endif; ?>
    </div>
</body>
</html>
