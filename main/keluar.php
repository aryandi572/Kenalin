<?php
session_start(); //memluai session
unset($_SESSION['user']); //mengakhiri session yang telah ada
$pesan = "Berhasil"; // inialisasi pesan
header("location:../index.php?Logout=$pesan"); //megarahkan menu inde dengan session telah habis
 ?>
