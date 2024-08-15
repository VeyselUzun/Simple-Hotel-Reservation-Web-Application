<?php
session_start();

// Oturumu sonlandır
session_unset();
session_destroy();

// Ana sayfaya yönlendir
header("Location: anasayfa.php");
exit;
?>
