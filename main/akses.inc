<?php
$pesan = ""; //inialisasi pesan
if (!isset($_SESSION['user'])) { // kondisi jika session bukan user maka akan diarahkan ke login
  $pesan = "LoginDulu"; // inialisasi pesan login
  header("location: login.php?pesan=$pesan"); // akan diarahkan ke login
  exit(); 
}
 
