<?php
// Veritabanı bağlantısını içe aktar
include 'baglanti.php';

// POST isteğinden rezervasyon ID'sini al
if(isset($_POST['reservation_id']) && !empty($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];

    // Rezervasyonu iptal etmek için sorgu
    $cancel_sql = "UPDATE tbl_rezervasyonlar SET iptal_et = 1 WHERE rezervasyon_id = '$reservation_id'";

    $response = array();

    if (mysqli_query($baglanti, $cancel_sql)) {
        // Başarıyla iptal edildi
        $response['success'] = true;
        $response['message'] = 'Rezervasyon başarıyla iptal edildi.';
    } else {
        // İptal edilemedi
        $response['success'] = false;
        $response['message'] = 'Rezervasyon iptal edilemedi: ' . mysqli_error($baglanti);
    }
} else {
    // Rezervasyon ID'si geçerli değil
    $response['success'] = false;
    $response['message'] = 'Geçersiz rezervasyon IDsi.';
}

// JSON yanıtını döndür
header('Content-Type: application/json');
echo json_encode($response);

// Veritabanı bağlantısını kapat
mysqli_close($baglanti);
?>
