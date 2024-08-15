<?php
session_start();

// Veritabanı bağlantısı
include("baglanti.php");

// Form hata mesajları için değişkenler
$e_posta_err = $parola_err = $genel_err = "";

if(isset($_POST["giris"])) {
    // Formdan gelen verileri al
    $email = $_POST["eposta"];
    $password = trim($_POST["sifre"]);

    // E-posta ve şifre boş olmadığından emin ol
    if(empty($email)) {
        $e_posta_err = "E-Posta boş bırakılamaz.";
    } 
    if(empty($password)) {
        $parola_err = "Şifre boş geçilemez.";
    }

    // Hata yoksa giriş işlemini yap
    if(empty($e_posta_err) && empty($parola_err)) {
        // Kullanıcıyı veritabanında ara
        $sorgu = "SELECT * FROM tbl_kullanicilar WHERE e_posta = ?";
        $stmt = $baglanti->prepare($sorgu);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Eğer bir kullanıcı bulunursa, parolayı kontrol et
        if($result->num_rows == 1) {
            $kullanici = $result->fetch_assoc();
            $hashli_sifre = $kullanici["sifre"];
            if(password_verify($password,$hashli_sifre)){
                // Oturum değişkenlerini ayarla ve ana sayfaya yönlendir
                $_SESSION["id"] = $kullanici["kullanici_id"];
                $_SESSION["ad"] = $kullanici["ad"];
                $_SESSION["soyad"] = $kullanici["soyad"];
                $_SESSION["e-posta"] = $kullanici["e_posta"];
                $_SESSION["giris_yapildi"] = true;
                header("Location: anasayfa.php");
                exit;
            } else {
                // Parola yanlışsa hata mesajı göster
                $genel_err = "Hatalı şifre, lütfen tekrar deneyin.";
            }
        } else {
            // Kullanıcı bulunamadıysa hata mesajı göster
            $genel_err = "E-posta yanlış lütfen tekrar deneyin.";
        }

        // Son olarak, bağlantıyı kapat
        $stmt->close();
    }

    // Veritabanı bağlantısını kapat
    $baglanti->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Giriş Ekranı</title>
	<link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
*
{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
body {
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	flex-direction: column;
	background: #23242a;
	background-image: url('img.jpg');
	background-repeat: no-repeat;
	background-size: 100% 100%;
	background-position: center;
}

.box 
{
	position: relative;
	width: 380px;
	height: 420px;
	background: #1c1c1c;
	border-radius: 8px;
	overflow: hidden;
}
.box::before 
{
	content: '';
	z-index: 1;
	position: absolute;
	top: -50%;
	left: -50%;
	width: 380px;
	height: 420px;
	transform-origin: bottom right;
	background: linear-gradient(0deg,transparent,#45f3ff,#45f3ff);
	animation: animate 6s linear infinite;
}
.box::after 
{
	content: '';
	z-index: 1;
	position: absolute;
	top: -50%;
	left: -50%;
	width: 380px;
	height: 420px;
	transform-origin: bottom right;
	background: linear-gradient(0deg,transparent,#45f3ff,#45f3ff);
	animation: animate 6s linear infinite;
	animation-delay: -3s;
}
@keyframes animate 
{
	0%
	{
		transform: rotate(0deg);
	}
	100%
	{
		transform: rotate(360deg);
	}
}
form 
{
	position: absolute;
	inset: 2px;
	background: #28292d;
	padding: 50px 40px;
	border-radius: 8px;
	z-index: 2;
	display: flex;
	flex-direction: column;
}
h2 
{
	color: #45f3ff;
	font-weight: 500;
	text-align: center;
	letter-spacing: 0.1em;
}
.inputBox 
{
	position: relative;
	width: 300px;
	margin-top: 35px;
}
.inputBox input 
{
	position: relative;
	width: 100%;
	padding: 20px 10px 10px;
	background: transparent;
	outline: none;
	box-shadow: none;
	border: none;
	color: #23242a;
	font-size: 1em;
	letter-spacing: 0.05em;
	transition: 0.5s;
	z-index: 10;
}
.inputBox span 
{
	position: absolute;
	left: 0;
	padding: 20px 0px 10px;
	pointer-events: none;
	font-size: 1em;
	color: #8f8f8f;
	letter-spacing: 0.05em;
	transition: 0.5s;
}
.inputBox input:valid ~ span,
.inputBox input:focus ~ span 
{
	color: #45f3ff;
	transform: translateX(0px) translateY(-34px);
	font-size: 0.75em;
}
.inputBox i 
{
	position: absolute;
	left: 0;
	bottom: 0;
	width: 100%;
	height: 2px;
	background: #45f3ff;
	border-radius: 4px;
	overflow: hidden;
	transition: 0.5s;
	pointer-events: none;
	z-index: 9;
}
.inputBox input:valid ~ i,
.inputBox input:focus ~ i 
{
	height: 44px;
}
.links 
{
	display: flex;
	justify-content: space-between;
}
.links a 
{
	margin: 10px 0;
	font-size: 0.75em;
	color: #8f8f8f;
	text-decoration: beige;
}
.links a:hover, 
.links a:nth-child(2)
{
	color: #45f3ff;
}
input[type="submit"]
{
	border: none;
	outline: none;
	padding: 11px 25px;
	background: #45f3ff;
	cursor: pointer;
	border-radius: 4px;
	font-weight: 600;
	margin-top: 10px;
}
input[type="submit"]:active 
{
	opacity: 0.8;
}
.error 
{
	color: red;
	font-size: 0.75em;
	margin-top: 5px;
}
</style>
</head>
<body>
	<div class="box">
		<form method="POST" autocomplete="off">
			<h2>Giriş Yap</h2>
			<div class="inputBox">
				<input type="text" name="eposta" required="required">
				<span>E-Posta</span>
				<i></i>
			</div>
			<div class="inputBox">
				<input type="password" name="sifre" required="required">
				<span>Şifre</span>
				<i></i>
			</div>
			<div class="links">
				<a href="kayit.php">Kayıt Ol</a>
			</div>
			<input type="submit" name="giris" value="Giriş Yap">
			<div class="error"><?php echo $genel_err; ?></div>
			<div class="error"><?php echo $e_posta_err; ?></div>
			<div class="error"><?php echo $parola_err; ?></div>
		</form>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#girisForm").submit(function(event) {
                // Formun normal gönderimini engelle
                event.preventDefault();

                // Hata mesajlarını temizle
                $(".error").text("");

                // Form bilgilerini al
                var eposta = $("#eposta").val();
                var sifre = $("#sifre").val();

                // E-posta ve şifre doğrulaması
                var hata = false;
                if (eposta === "") {
                    $(".epostaError").text("E-Posta boş bırakılamaz.");
                    hata = true;
                }
                if (sifre === "") {
                    $(".sifreError").text("Şifre boş geçilemez.");
                    hata = true;
                }

                // Hata yoksa formu sunucuya gönder
                if (!hata) {
                    $.ajax({
                        type: "POST",
                        url: "giris.php",
                        data: $(this).serialize(), // Form verilerini gönder
                        success: function(response) {
                            // Sunucudan gelen yanıtı işle
                            if (response.trim() === "success") {
                                // Başarılı giriş, yönlendir
                                window.location.href = "anasayfa.php";
                            } else {
                                // Hata mesajını göster
                                $(".genelError").text(response);
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
