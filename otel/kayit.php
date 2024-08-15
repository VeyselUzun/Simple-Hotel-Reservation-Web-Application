<?php

include("baglanti.php");

$ad_err = $soyad_err = $e_posta_err = $parola_err = $genel_err = ""; // Hata mesajları için değişkenler
if (isset($_POST["kaydet"])) {
    
    if (empty($_POST["ad"])) {
        $ad_err = "Ad boş geçilemez.";
    } elseif (!preg_match('/^[a-zğüşıöçĞÜŞİÖÇ_\d]{0,40}$/iu', $_POST["ad"])) {
        $ad_err = "Ad büyük küçük harften oluşmalıdır.";
    } else {
        $isim = $_POST["ad"];
    }

    if (empty($_POST["soyad"])) {
        $soyad_err = "Soyad boş geçilemez.";
    } elseif (!preg_match('/^[a-zğüşıöçĞÜŞİÖÇ_\d]{0,40}$/iu', $_POST["soyad"])) {
        $soyad_err = "Soyad büyük küçük harften oluşmalıdır.";
    } else {
        $soyisim = $_POST["soyad"];
    }

    if (empty($_POST["eposta"])) {
        $e_posta_err = "E-Posta boş bırakılamaz.";
    } elseif (!filter_var($_POST["eposta"], FILTER_VALIDATE_EMAIL)) {
        $e_posta_err = "Geçersiz e-posta adresi formatı.";
    } else {
        $email = $_POST["eposta"];
        $kontrol = "SELECT * FROM tbl_musteriler WHERE e_posta='$email'";
        $calistir = mysqli_query($baglanti, $kontrol);
        if (mysqli_num_rows($calistir) > 0) {
            $e_posta_err = "Bu e-posta adresi zaten kullanımda.";
        }
    }

    if (empty($_POST["sifre"])) {
        $parola_err = "Şifre boş geçilemez.";
    } elseif (strlen($_POST["sifre"]) < 4) {
        $parola_err = "Şifre en az 4 karakterden oluşmalıdır.";
    } elseif (strlen($_POST["sifre"]) > 10) {
        $parola_err = "Şifre en fazla 10 karakterden oluşmalıdır.";
    } else {
        $password = $_POST["sifre"];
    }

    if (empty($ad_err) && empty($soyad_err) && empty($e_posta_err) && empty($parola_err)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Şifreyi hashle
        $ekle = "INSERT INTO tbl_kullanicilar (ad, soyad, e_posta, sifre) VALUES ('$isim','$soyisim','$email','$hashed_password')";
        $calistirekle = mysqli_query($baglanti, $ekle);
    
        if ($calistirekle) {
            echo '<div class="alert alert-success" role="alert" style="color: #2ecc71; font-weight: bold;">
            Kayıt başarılı bir şekilde eklendi.
            </div>';

            
        }
        mysqli_close($baglanti);
    } else {
        $genel_err = "Lütfen formu eksiksiz doldurun.";
    }
}

?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ekranı</title>
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
            background-size: cover;
            background-position: center;
        }
        .box 
        {
            position: relative;
            width: 380px;
            height: 550px;
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
            margin-top: 25px;
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
        .success-message 
        {
            color: #2ecc71; /* Yeşil renk */
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
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
            <h2>Kayıt Ol</h2>
            <div class="inputBox">
                <input type="text" name="ad" required="required">
                <span>Ad</span>
                <i></i>
                <div class="error"><?php echo $ad_err; ?></div> <!-- Ad hata mesajı -->
            </div>
            <div class="inputBox">
                <input type="text" name="soyad" required="required">
                <span>Soyad</span>
                <i></i>
                <div class="error"><?php echo $soyad_err; ?></div> <!-- Soyad hata mesajı -->
            </div>
            <div class="inputBox">
                <input type="text" name="eposta" required="required">
                <span>E-posta</span>
                <i></i>
                <div class="error"><?php echo $e_posta_err; ?></div> <!-- E-posta hata mesajı -->
            </div>
            <div class="inputBox">
                <input type="password" name="sifre" required="required">
                <span>Şifre</span>
                <i></i>
                <div class="error"><?php echo $parola_err; ?></div> <!-- Şifre hata mesajı -->
            </div>
            <div class="links">
                <a href="giris.php">Zaten hesabın varsa giriş yap..</a>
            </div>
            <input type="submit" name="kaydet" value="Kayıt Ol">
            <div class="error"><?php echo $genel_err; ?></div> <!-- Genel hata mesajı -->
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Form gönderildiğinde kontrol et
            $("#kayitForm").submit(function(event) {
                // Hata mesajlarını gizle
                $(".error").text("");

                // Form bilgilerini al
                var ad = $("input[name='ad']").val();
                var soyad = $("input[name='soyad']").val();
                var eposta = $("input[name='eposta']").val();
                var sifre = $("input[name='sifre']").val();

                // Hata kontrolü
                if (ad === "") {
                    $(".adError").text("Ad boş geçilemez.");
                    event.preventDefault(); // Formun gönderilmesini engelle
                    return;
                }

                if (soyad === "") {
                    $(".soyadError").text("Soyad boş geçilemez.");
                    event.preventDefault();
                    return;
                }

                if (eposta === "") {
                    $(".epostaError").text("E-posta boş bırakılamaz.");
                    event.preventDefault();
                    return;
                } else if (!isValidEmail(eposta)) {
                    $(".epostaError").text("Geçersiz e-posta adresi formatı.");
                    event.preventDefault();
                    return;
                }

                if (sifre === "") {
                    $(".sifreError").text("Şifre boş geçilemez.");
                    event.preventDefault();
                    return;
                } else if (sifre.length < 4 || sifre.length > 10) {
                    $(".sifreError").text("Şifre en az 4, en fazla 10 karakter olmalıdır.");
                    event.preventDefault();
                    return;
                }
            });

            // E-posta doğrulama fonksiyonu
            function isValidEmail(email) {
                var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return pattern.test(email);
            }
        });
    </script>
</body>
</html>
