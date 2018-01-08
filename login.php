<?php
include "main/connect.php"; //Untuk akses connect ke database
$messageuser = $messagepass = $user = $pass = "";  // inialisasi string kosong
session_start(); //untuk memulai session
if (isset($_POST['login'])) { // terdapat kondisi if jika value post login ditekan 
    if (empty($_POST['user'])) {  //pengecekan jika user kondisi kosong
        $messageuser = "Username Kosong";  //terdapat pesan error untuk username kosong
        if (empty($_POST['pass'])) { //pengecekan jika password kondisi kosong
            $messagepass = "Password Kosong"; //terdapat pesan error untuk username kosong
        }
    } else {
        $user = $_POST['user']; //inialisasi value $user dengan nilai post nama usrname
        $pass = $_POST['pass']; //inialisasi value $pass dengan nilai post password
    }

    $stmt = $dbh->prepare("select * from akun where username = :username and password = SHA2(:password, 0)"); //query sql menampilkan username dan password dari user
    $stmt->bindValue(":username", $user);  //inialisasi value user untuk dimasuakn ke query
    $stmt->bindValue(":password", $pass); //inialisasi value pass untuk dimasuakn ke query
    $stmt->execute(); // melakukan eksekusi sql

    $cek = $stmt->rowCount() > 0; // kondisi jika terdapat baris yg dieksekusi lebhh dari  0

    if ($cek) { //pengecekan value eksekusi query jika terdapat baris lebih dari 0
        $_SESSION['user'] = $user; // inisalisasi session user yang login
        header("Location:index.php?pesan=berhasil"); //jika berhasil diarahkan ke index
    }
} // akhir kondisi if jika value post login ditekan 
?>
<!DOCTYPE HTML>
<html>
    <head> <!-- tag class head  -->
        <title>Daftar Kenalin</title> <!-- untuk judul  -->
        <link rel="stylesheet" href="css/masuk.css" /> <!-- import file css -->
    </head> <!-- tag penutup class head  -->

    <body> <!-- pembuka body  -->
        <div class="container"> <!-- tag class container  -->
            <div class="main">
                <a href="index.php"> <img alt="logo" src="gambar/logo-login2.png" class="logo"> </a>  <!-- Logo Kenalin -->

                <form method="post" action="#" enctype="multipart/form-data"> <!-- tampilan form  -->
                    <label>Username</label>
                    <input id="Name" class="input" type="text" name="user" placeholder="Username">
                    <div class="error"> <?php echo $messageuser; ?></div> <!-- untuk menampilkan pesan error -->
                    <label>Password</label>
                    <input id="pass" class="input" type="password" name="pass" placeholder="Password">
                    <div class="error"><?php echo $messagepass; ?></div> <!-- untuk menampilkan pesan error -->
                    <input class="submit" type="submit" name="login" value="Masuk">   <!-- button Login -->
                    <p class="tulisan-register"> Mau Kenalin ? <a href="register.php"> Daftar </a></p> <!-- button register -->
                </form> <!-- akhir tampilan form  -->
            </div>
        </div> <!-- tag penutup class container  -->
    </body> <!-- penutup body  -->
</html>
